<?php

namespace App\Livewire\Academico\Cronograma;

use App\Models\Academico\Cronodeta;
use App\Models\Academico\Cronograma;
use App\Models\Academico\Unidade;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;

class CronoDetalle extends Component
{
    public $actual;
    public $detalles;
    public $unidades;

    public $is_detalle=true;
    public $is_plan=false;
    public $grupo;
    public $idciclo;


    public function mount($elegido){
        Carbon::setLocale('es');
        $this->actual=Cronograma::find(intval($elegido));
        $this->detalles=Cronodeta::where('cronograma_id',intval($elegido))->get();

        $this->unida();
    }

    public function unida(){
        $modulo=$this->actual->grupo->modulo_id;
        $this->unidades=Unidade::where('modulo_id',$modulo)->get();
    }

    #[On('planeando')]
    public function show(){
        $this->grupo=$this->actual->grupo_id;
        $this->idciclo=$this->actual->ciclo_id;
        $this->is_detalle=!$this->is_detalle;
        $this->is_plan=!$this->is_plan;
    }

    public function render()
    {
        return view('livewire.academico.cronograma.crono-detalle');
    }
}
