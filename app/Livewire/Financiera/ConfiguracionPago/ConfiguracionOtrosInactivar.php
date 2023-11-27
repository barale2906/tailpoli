<?php

namespace App\Livewire\Financiera\ConfiguracionPago;

use App\Models\Financiera\ConfPagOtros;
use App\Models\Financiera\ConfPagOtrosDet;
use Livewire\Component;

class ConfiguracionOtrosInactivar extends Component
{
    public $descripcion = '';
    public $id = '';
    public $elegido;
    public $status = true;

    public function mount($elegido = null)
    {
        $this->descripcion=$elegido['descripcion'];
        $this->id=$elegido['id'];
        if($elegido['status']===1){
            $this->status=true;
        }else{
            $this->status=false;
        }
    }

    //Inactivar Regimen de Salud
    public function inactivar()
    {

        //Actualizar registros
        ConfPagOtros::whereId($this->id)->update([
            'status'=>!$this->status
        ]);

        ConfPagOtrosDet::where('conf_pag_otro_id',$this->id)->update([
            'status'=>!$this->status
        ]);

        $this->dispatch('alerta', name:'Se cambio el estado de: '.$this->descripcion);

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');
    }

    public function render()
    {
        return view('livewire.financiera.configuracion-pago.configuracion-otros-inactivar');
    }
}
