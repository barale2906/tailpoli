<?php

namespace App\Livewire\Financiera\CierreCaja;

use App\Models\Financiera\CierreCaja;
use App\Models\Financiera\ReciboPago;
use Livewire\Component;

class CierreCajasImprimir extends Component
{
    public $cierre;
    public $recibos;
    public $elegido;

    public function mount($elegido = null)
    {
        $this->cierre=CierreCaja::find($elegido['id']);
        $this->recibos=ReciboPago::where('cierre', $elegido['id'])->get();
    }

    public function render()
    {
        return view('livewire.financiera.cierre-caja.cierre-cajas-imprimir');
    }
}
