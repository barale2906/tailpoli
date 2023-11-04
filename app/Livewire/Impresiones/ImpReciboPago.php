<?php

namespace App\Livewire\Impresiones;

use App\Models\Financiera\ReciboPago;
use Livewire\Attributes\Url;
use Livewire\Component;

class ImpReciboPago extends Component
{
    #[Url(as: 'r')]
    public $recibo='';


    private function obtener(){

        return ReciboPago::whereId($this->recibo)->first();
    }

    public function render()
    {
        return view('livewire.impresiones.imp-recibo-pago',[
            'obtener' => $this->obtener(),
        ]);
    }
}
