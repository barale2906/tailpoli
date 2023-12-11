<?php

namespace App\Livewire\Academico\Ciclo;

use App\Models\Academico\Ciclo;
use App\Models\Academico\Control;
use App\Models\Academico\Grupo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CiclosCambiar extends Component
{
    public $control;
    public $curso;
    public $curso_id;
    public $ciclo;
    public $is_cambiar=false;

    public function mount($elegido){

        $this->curso_id=$elegido['curso_id'];
        $this->control=Control::where('matricula_id', $elegido['id'])
                                ->where('estudiante_id', $elegido['alumno_id'])
                                ->first();

        $this->datocurso();
    }

    public function datocurso(){
        $this->curso=$this->control->matricula->curso->name;
    }

    public function show($id){
        $this->ciclo=Ciclo::find($id);
    }


    public function cambiar(){
        $this->is_cambiar=!$this->is_cambiar;
    }

    public function aprobar(){

        //control
        $obser=now()." ".Auth::user()->name." TRASLADO A LA PROGRAMACIÓN: ".$this->ciclo->name."-----";

        $this->control->update([
            'ciclo_id'      =>$this->ciclo->id,
            'inicia'        =>$this->ciclo->inicia,
            'sede_id'       =>$this->ciclo->sede_id,
            'observaciones' =>$obser.$this->control->observaciones
        ]);

        //Elimina registro anterior
        $registro=DB::table('grupo_matricula')
                        ->where('matricula_id', $this->control->matricula_id)
                        ->get();

        foreach ($registro as $value) {
            //Restar usuario al grupo
            $inscritos=Grupo::find($value->grupo_id);

            $tot=$inscritos->inscritos-1;

            $inscritos->update([
                'inscritos'=>$tot
            ]);
        }

        DB::table('grupo_matricula')
                        ->where('matricula_id', $this->control->matricula_id)
                        ->delete();


        foreach ($this->ciclo->ciclogrupos as $value) {
            DB::table('grupo_matricula')
                ->insert([
                    'grupo_id'      =>$value->grupo_id,
                    'matricula_id'  =>$this->control->matricula_id,
                    'created_at'    =>now(),
                    'updated_at'    =>now(),
                ]);

            DB::table('grupo_user')
                ->insert([
                    'grupo_id'      =>$value->grupo_id,
                    'user_id'       =>$this->control->estudiante_id,
                    'created_at'    =>now(),
                    'updated_at'    =>now(),
                ]);

            //Sumar usuario al grupo
            $inscritos=Grupo::find($value->grupo_id);

            $tot=$inscritos->inscritos+1;

            $inscritos->update([
                'inscritos'=>$tot
            ]);
        }

        $this->dispatch('alerta', name:'Se ha cambiado el ciclo correctamente. Las notas y Asistencias NO SE MODIFICAN NI ACTUALIZAN');

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cambiagrupo');

        $this->is_cambiar=!$this->is_cambiar;
    }

    private function ciclos(){
        return Ciclo::where('status', true)
                        ->whereNot('id', $this->control->ciclo_id)
                        ->where('curso_id', $this->curso_id)
                        ->get();
    }

    public function render()
    {
        return view('livewire.academico.ciclo.ciclos-cambiar',[
            'ciclos'=>$this->ciclos(),
        ]);
    }
}
