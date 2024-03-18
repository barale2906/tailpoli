<?php

namespace App\Livewire\Cartera\Cartera;

use App\Models\Financiera\Cartera;
use App\Models\Financiera\ReciboPago;
use Livewire\Component;

class Detalle extends Component
{
    public $actual;
    public $carteras;
    public $recibos;

    public function mount($alumno){
        $this->actual->find($alumno);
        $this->deuda();
        $this->pagos();
    }

    public function deuda(){
        $this->carteras=Cartera::where('status', true)
                                ->where('responsable_id', $this->actual->id)
                                ->get();
    }

    public function pagos(){
        $this->recibos=ReciboPago::where('paga_id', $this->actual->id)->get();
    }


    public function render()
    {
        return view('livewire.cartera.cartera.detalle');
    }
}
