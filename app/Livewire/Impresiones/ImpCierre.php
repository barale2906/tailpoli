<?php

namespace App\Livewire\Impresiones;

use App\Models\Financiera\CierreCaja;
use App\Models\Financiera\ConceptoPago;
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
    public $descuentosT=0;
    public $id_concepto;

    public function mount(){

        //$this->id_concepto=ConceptoPago::where('name', 'Descuento')->first();
        $this->obtener=CierreCaja::find($this->id);
        $this->obterecibo();

    }


    public function obterecibo(){

        $this->recibos=ReciboPago::where('cierre', $this->id)->get();
        $this->urlruta();
        $this->descuenTotal();
    }

    public function descuenTotal(){
        $ids=array();

        foreach ($this->recibos as $value) {
            array_push($ids, $value->id);
        }

        $this->descuentosT = $this->recibos->sum('descuento');
    }

    public function urlruta(){

        switch ($this->ori) {
            case 0:
                $this->ruta="/financiera/cierrecaja";
                break;

            case 1:
                $this->ruta="/financiera/cajero";
                break;

            case 2:
                $this->ruta="/academico/gestion";
                break;
        }

        if ($this->ori===1) {

        } else if($this->ori===0){

        }

    }


    public function render()
    {
        return view('livewire.impresiones.imp-cierre');
    }
}
