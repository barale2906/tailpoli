<?php

namespace App\Livewire\Academico\Matricula;

use App\Models\Academico\Ciclo;
use App\Models\Academico\Control;
use App\Models\Academico\Grupo;
use App\Models\Academico\Matricula;
use App\Models\Financiera\Cartera;
use App\Models\Financiera\EstadoCartera;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class MatriculasAnular extends Component
{
    public $matricula;
    public $motivo;
    public $id;

    public function mount($elegido = null)
    {
        $this->id=$elegido['id'];
        $this->matricula=Matricula::find($elegido['id']);
    }

    /**
     * Reglas de validación
     */
    protected $rules = [
        'motivo' => 'required'
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset('motivo', 'id');
    }

    //Actualizar
    public function edit()
    {
        // validate
        $this->validate();

        //Actualizar registros
        Matricula::whereId($this->id)->update([
            'anula'=>now()." ¡¡¡ANULADO!!! ".strtolower($this->motivo),
            'anula_user'=>Auth::user()->name,
            'status'=>false
        ]);

        // Descontar estudiante de los grupos
        foreach ($this->matricula->grupos as $value) {
            //Restar estudiante al grupo
            $inscrito=Grupo::where('id', $value['id'])
                            ->select('inscritos')
                            ->first();

            $ins=$inscrito->inscritos-1;

            Grupo::whereId($value['id'])->update([
                'inscritos'=>$ins
            ]);
        }

        // Inactivar Cartera
        $carteras=Cartera::where('matricula_id', $this->id)->get();
        $estado=EstadoCartera::where('name', 'anulada')->first();

        foreach ($carteras as $value) {
            Cartera::whereId($value->id)->update([
                'status'=>$estado->id,
                'observaciones'=>now().": Se anulo la matricula con motivo de: ".$this->motivo.", por: ".Auth::user()->name." --- ".$value->observaciones
            ]);
        }

        //Inactivar control
        $crt=Control::where('matricula_id', $this->id)->first();

        $crt->update([
            'observaciones'=>now().": Se anulo la matricula con motivo de: ".$this->motivo.", por: ".Auth::user()->name." --- ".$crt->observaciones,
            'status'=>false
        ]);

        //Descontar del ciclo
        $ciclo=Ciclo::whereId($crt->ciclo_id)->first();
        $ciclo->update([
            'registrados'=>$ciclo->registrados-1
        ]);

        //Inactivar en notas - Asistencia
        $esta=DB::table('notas_detalle')
                    ->where('alumno_id', $this->matricula->alumno_id)
                    ->get();

        if($esta){
            foreach ($esta as $value) {
                DB::table('notas_detalle')
                    ->where('id', $value->id)
                    ->update([
                        'observaciones'=>now().": Se anulo la matricula con motivo de: ".$this->motivo.", por: ".Auth::user()->name." --- ".$value->observaciones,
                        'status'=>false
                    ]);
            }
        }

        $asis=DB::table('asistencia_detalle')
                    ->where('alumno_id', $this->matricula->alumno_id)
                    ->get();

        if($asis){
            foreach ($asis as $value) {
                DB::table('aistencia_detalle')
                    ->where('id', $value->id)
                    ->update([
                        'status'=>false
                    ]);
            }
        }



        $this->dispatch('alerta', name:'Se ha anulado correctamente la matricula');
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('Editando');
    }

    public function render()
    {
        return view('livewire.academico.matricula.matriculas-anular');
    }
}
