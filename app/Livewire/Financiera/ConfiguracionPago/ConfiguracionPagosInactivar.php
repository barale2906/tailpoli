<?php

namespace App\Livewire\Financiera\ConfiguracionPago;

use App\Models\Financiera\ConfiguracionPago;
use Livewire\Component;

class ConfiguracionPagosInactivar extends Component
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
        ConfiguracionPago::whereId($this->id)->update([
            'status'=>!$this->status
        ]);

        $this->dispatch('alerta', name:'Se cambio el estado de: '.$this->descripcion);

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('Inactivando');
    }

    public function render()
    {
        return view('livewire.financiera.configuracion-pago.configuracion-pagos-inactivar');
    }
}
