<?php

namespace App\Livewire\Academico\Cronograma;

use App\Models\Academico\Cronodeta;
use App\Models\Academico\Cronograma;
use App\Models\Academico\Unidade;
use Carbon\Carbon;
use Livewire\Component;

class CronoDetalle extends Component
{
    public $actual;
    public $detalles;
    public $unidades;


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

    public function render()
    {
        return view('livewire.academico.cronograma.crono-detalle');
    }
}
