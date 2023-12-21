<?php

namespace App\Livewire\Academico\Estudiante;

use App\Models\Academico\Ciclo;
use App\Models\Academico\Ciclogrupo;
use App\Models\Academico\Grupo;
use App\Models\Academico\Modulo;
use App\Models\User;
use Carbon\Carbon;
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
        $this->dispatch('alerta', name:'Inscribe al estudiante en la nueva programación');
    }

    public function render()
    {
        return view('livewire.academico.estudiante.caso-especial');
    }
}
