<?php

namespace App\Livewire\Financiera\CierreCaja;

use App\Models\Financiera\CierreCaja;
use App\Models\Financiera\ConceptoPago;
use App\Models\Financiera\ReciboPago;
use App\Traits\ComunesTrait;
use App\Traits\CierreCajaTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class CierrePorCajero extends Component
{
    use ComunesTrait;
    use CierreCajaTrait;

    public $sedes=[];
    public $unica;
    public $sede_id;
    public $agrupado;
    public $recibos;
    public $comentarios;
    public $dinero_entegado;
    public $valor_total=0;
    public $status=1;

    public $valor_pensiones=0;
    public $valor_efectivo=0;
    public $valor_tarjeta=0;
    public $valor_cheque=0;
    public $valor_consignacion=0;

    public $valor_otros=0;
    public $valor_efectivo_o=0;
    public $valor_tarjeta_o=0;
    public $valor_cheque_o=0;
    public $valor_consignacion_o=0;
    public $descuentosT=0;
    public $id_concepto;

    public $elegido;
    public $accion=2;

    public $ruta=1;

    public $print=false;

    public function mount ($ruta=null){
        $this->cierre();
        $this->id_concepto=ConceptoPago::where('name', 'Descuento')->first();
        $this->recibos=ReciboPago::where('creador_id', Auth::user()->id)
                                ->where('status', '!=', 1)
                                ->get();

        $this->ruta=$ruta;

        $this->sedeMas();
    }

    public function sedeMas(){

        $this->agrupado=$this->recibos->groupBy('sede_id');

        if($this->agrupado->count()===1){
            $this->unica=ReciboPago::where('creador_id', Auth::user()->id)
                                        ->where('status', '!=', 1)
                                        ->first();

            $this->sede_id=$this->unica->sede_id;
            $this->updatedSedeId();
        }else{
            foreach ($this->recibos as $value) {
                $nuevo=[
                    'id'=>$value->sede->id,
                    'name'=>$value->sede->name,
                ];

                if(in_array($nuevo, $this->sedes)){

                }else{
                    array_push($this->sedes, $nuevo);
                }

            }
        }
    }

    public function updatedSedeId(){
        $this->reset('valor_total');
        $this->recibos=ReciboPago::where('status', 0)
                                    ->where('sede_id', $this->sede_id)
                                    ->where('creador_id', Auth::user()->id)
                                    ->get();
            $this->totalizar();

    }

    public function totalizar(){
        $this->valor_total=ReciboPago::where('sede_id', $this->sede_id)
                                        ->where('creador_id', Auth::user()->id)
                                        ->where('cierre', null)
                                        ->where('status', 0)
                                        ->sum('valor_total');

        $this->carteradet();
    }

    //volver
    #[On('volver')]
    public function vuelve(){
        $this->dispatch('created');
    }

    public function render()
    {
        return view('livewire.financiera.cierre-caja.cierre-por-cajero');
    }
}
