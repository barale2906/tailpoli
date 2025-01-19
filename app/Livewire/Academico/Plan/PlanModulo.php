<?php

namespace App\Livewire\Academico\Plan;

use App\Models\Academico\Acaplan;
use App\Models\Academico\Acaplandeta;
use App\Models\Academico\Cronograma;
use App\Models\Academico\Cronodeta;
use App\Models\Academico\Unidade;
use App\Models\Academico\Unidtema;
use Livewire\Attributes\On;
use Livewire\Component;

class PlanModulo extends Component
{
    public $actual;
    public $detalles;
    public $cronodetalles;
    public $temas;
    public $ids=[];
    public $plan;
    public $crono;
    public $fecha;

    public $is_mostrar=true;
    public $is_cierre=false;

    public function mount($grupo,$idciclo){
        $this->actual=Acaplan::where('grupo_id',$grupo)
                                ->where('ciclo_id',$idciclo)
                                ->first();

        $this->unida();
    }

    public function unida(){
        $modulo=$this->actual->grupo->modulo_id;
        $this->temas=Unidade::join('unidtemas', 'unidtemas.unidade_id', '=', 'unidades.id')
                            ->select('unidades.name as unidad','unidades.duracion as unidura', 'unidtemas.id as temaid','unidtemas.name as tema', 'unidtemas.duracion as temadura')
                            ->where('unidades.modulo_id',$modulo)
                            ->get();
        $this->cargadetalle();
    }

    public function cargadetalle(){

        $this->detalles=Acaplandeta::where('acaplan_id',$this->actual->id)
                                    ->get();
        $this->cargacrono();
    }

    public function cargacrono(){
        $this->reset('ids');

        $cronogramas=Cronograma::where('grupo_id',$this->actual->grupo_id)
                                ->where('ciclo_id',$this->actual->ciclo_id)
                                ->select('id')
                                ->get();

        foreach ($cronogramas as $value) {
            array_push($this->ids,$value->id);
        }

        $this->carcronodet();

    }

    public function carcronodet(){
        $this->cronodetalles=Cronodeta::whereIn('cronograma_id',$this->ids)
                                        ->select('id','unidtema_id','fecha_programada')
                                        ->get();
    }

    #[On('cerrando')]
    public function fin($plan=null,$crono=null){

        $this->is_cierre=!$this->is_cierre;
        $this->is_mostrar=!$this->is_mostrar;
        $this->plan=$plan;
        $this->crono=$crono;
        $this->mount($this->actual->grupo_id,$this->actual->ciclo_id);
    }

    public function render()
    {
        return view('livewire.academico.plan.plan-modulo');
    }
}
