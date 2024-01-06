<?php

namespace App\Livewire\Academico\Estudiante;

use App\Models\Academico\Ciclo;
use App\Models\Academico\Ciclogrupo;
use App\Models\Academico\Control;
use App\Models\Academico\Grupo;
use App\Models\Academico\Modulo;
use App\Models\Clientes\Pqrs;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CasoEspecial extends Component
{
    public $actual;
    public $modulos;
    public $elegido;
    public $registro=false;
    public $eleGrupo;
    public $fecha;
    public $ciclos;
    public $cicloEle;

    public function mount($id, $registro=null){
        $this->actual=User::find($id);
        if($registro){
            $this->registro=true;
        }
        $this->fecha=Carbon::today();
        $this->obteModulos();

    }

    public function obteModulos(){
        $this->modulos=DB::table('matricula_modulos_aprobacion')
                            ->where('alumno_id', $this->actual->id)
                            ->get();

    }

    public function elegirModulo($id){
        $this->elegido=Modulo::find($id);
        $this->grupos();
    }

    public function grupos(){
        $ids=[];
        foreach ($this->elegido->grupos as $value) {
            foreach ($value->alumnos as $item) {
                if ($item->id===$this->actual->id) {
                    array_push($ids,$value->id);
                }
            }
        }

        if(count($ids)>0){
            $this->eleGrupo=DB::table('notas_detalle')
                                ->where('alumno_id', $this->actual->id)
                                ->whereIn('grupo_id', $ids)
                                ->get();

            $this->ciclosGr();
        }
    }

    public function ciclosGr(){

        $feinicio=$this->fecha->subDays(5);
        $ids=[];
        foreach ($this->elegido->grupos as $value) {
            array_push($ids,$value->id);
        }

        $this->ciclos=Ciclogrupo::whereIn('grupo_id', $ids)
                                    ->where('fecha_inicio', '>=', $feinicio)
                                    ->orderBy('fecha_inicio', 'ASC')
                                    ->get();

    }

    public function elegirCiclo($id){
        $this->cicloEle=Ciclo::find($id);
    }

    public function inscribe($id){
        //Obtener datos del ciclo elegido
        $ciclo=Ciclo::find($id);

        //Identificar matricula actual
        $matricula=DB::table('matricula_modulos_aprobacion')
                            ->where('alumno_id', $this->actual->id)
                            ->where('modulo_id', $this->elegido->id)
                            ->select('matricula_id')
                            ->first();

        // Identificar control Actual
        $control=Control::where('estudiante_id', $this->actual->id)
                            ->where('matricula_id', $matricula->matricula_id)
                            ->first();

        //Restar del ciclo anterior y sumar al actual
        $anteCiclo=Ciclo::find($control->ciclo_id);
        $anteCiclo->update([
            'registrados'=>$anteCiclo->registrados-1
        ]);

        $ciclo->update([
            'registrados'=>$ciclo->registrados+1
        ]);

        //Cambiar control
        $control->update([
            'ciclo_id'      =>$ciclo->id,
            'inicia'        =>$ciclo->inicia,
            'sede_id'       =>$ciclo->sede_id,
        ]);



        Pqrs::create([
            'estudiante_id' =>$control->estudiante_id,
            'gestion_id'    =>Auth::user()->id,
            'fecha'         =>now(),
            'tipo'          =>4,
            'observaciones' =>'ACÁDEMICO: '.Auth::user()->name." TRASLADO A LA PROGRAMACIÓN: ".$ciclo->name.", POR CASO ESPECIAL. -----",
            'status'        =>4
        ]);

        //Elimina registro anterior
        $registro=DB::table('grupo_matricula')
                        ->where('matricula_id', $control->matricula_id)
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
                        ->where('matricula_id', $control->matricula_id)
                        ->delete();


        foreach ($ciclo->ciclogrupos as $value) {
            DB::table('grupo_matricula')
                ->insert([
                    'grupo_id'      =>$value->grupo_id,
                    'matricula_id'  =>$control->matricula_id,
                    'created_at'    =>now(),
                    'updated_at'    =>now(),
                ]);

            DB::table('grupo_user')
                ->insert([
                    'grupo_id'      =>$value->grupo_id,
                    'user_id'       =>$control->estudiante_id,
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
    }

    public function render()
    {
        return view('livewire.academico.estudiante.caso-especial');
    }
}
