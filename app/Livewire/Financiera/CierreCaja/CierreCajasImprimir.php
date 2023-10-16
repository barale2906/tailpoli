<?php

namespace App\Livewire\Financiera\CierreCaja;

use App\Models\Financiera\CierreCaja;
use App\Models\Financiera\ReciboPago;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CierreCajasImprimir extends Component
{
    public $cierre;
    public $recibos;
    public $elegido;
    public $accion;
    public $observaciones;

    public function mount($elegido = null,$accion)
    {
        $this->cierre=CierreCaja::find($elegido['id']);
        $this->recibos=ReciboPago::where('cierre', $elegido['id'])->get();
        $this->$accion=$accion;
    }
    /**
     * Reglas de validación
     */
    protected $rules = [
        'observaciones' => 'required'
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset('observaciones');
    }

    public function aprobar(){

        // validate
        $this->validate();

        $this->cierre->update([
            'observaciones'=>now()." ".Auth::user()->name." APROBO: ".$this->observaciones." --- ".$this->cierre->observaciones,
            'coorcaja_id'=>Auth::user()->id,
            'status'=>true,
        ]);

        // Notificación
        $this->dispatch('alerta', name:'Se ha aprobado correctamente el cierre de caja N°: '.$this->cierre->id);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('Inactivando');
    }

    public function render()
    {
        return view('livewire.financiera.cierre-caja.cierre-cajas-imprimir');
    }
}
