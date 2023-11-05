<?php

namespace App\Livewire\Impresiones;

use App\Models\Financiera\CierreCaja;
use App\Models\Financiera\ReciboPago;
use Livewire\Attributes\Url;
use Livewire\Component;

class ImpCierre extends Component
{
    #[Url(as: 'c')]
    public $id='';

    #[Url(as: 'o')]
    public $ori='';

    public $obtener;
    public $recibos;
    public $ruta;

    public function mount(){

        $this->obtener=CierreCaja::find($this->id);
        $this->obterecibo();

    }

    public function obterecibo(){

        $this->recibos=ReciboPago::where('cierre', $this->id)->get();
        $this->urlruta();
    }

    public function urlruta(){

        if ($this->ori===1) {
            $this->ruta="/financiera/cajero";
        } else if($this->ori===0){
            $this->ruta="/financiera/cierrecaja";
        }

    }


    public function render()
    {
        return view('livewire.impresiones.imp-cierre');
    }
}
