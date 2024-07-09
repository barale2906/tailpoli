<?php

namespace App\Livewire\Financiera\CerrarCaja;

use Livewire\Component;
use App\Traits\ComunesTrait;
use App\Traits\CajaCierraTrait;
use Illuminate\Support\Facades\Auth;


class CierraJornadaCajero extends Component
{
    use ComunesTrait;
    use CajaCierraTrait;

    public $ruta=1;
    public $print=false;

    public function mount($ruta=null){

        $this->cierre();
        $this->recibos(Auth::user()->id);
        $this->ruta=$ruta;

    }

    public function render()
    {
        return view('livewire.financiera.cerrar-caja.cierra-jornada-cajero');
    }
}
