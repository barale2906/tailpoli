<?php

namespace App\Livewire\Financiera\CierreCaja;

use App\Models\Financiera\CierreCaja;
use App\Models\Financiera\ConceptoPago;
use App\Models\Financiera\ReciboPago;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CierreCajasImprimir extends Component
{
    public $cierre;
    public $recibos;
    public $elegido;
    public $accion;
    public $observaciones;
    public $ruta;
    public $descuentosT=0;
    public $id_concepto;
    public $valor_anulado;
    public $diferencia;

    public function mount($elegido = null,$accion,$ruta=null)
    {
        $this->cierre=CierreCaja::find($elegido['id']);
        $this->recibos=ReciboPago::where('cierre', $elegido['id'])->orderBy('fecha', 'ASC')->get();
        $this->$accion=$accion;
        $this->ruta=$ruta;
        $this->valor_anulado=ReciboPago::where('cierre', $elegido['id'])
                                        ->where('status', 2)
                                        ->sum('valor_total');

        $this->calculadiferencia();
    }

    public function calculadiferencia(){
        $descuentos=$this->cierre->efectivo_descuento+$this->cierre->valor_reportado;
        $this->diferencia=$descuentos-$this->cierre->efectivo;
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
