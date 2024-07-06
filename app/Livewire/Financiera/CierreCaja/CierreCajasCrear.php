<?php

namespace App\Livewire\Financiera\CierreCaja;

use App\Models\Configuracion\Sede;
use App\Models\Financiera\CierreCaja;
use App\Models\Financiera\ConceptoPago;
use App\Models\Financiera\ReciboPago;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Traits\ComunesTrait;
use App\Traits\CierreCajaTrait;

class CierreCajasCrear extends Component
{
    use ComunesTrait;
    use CierreCajaTrait;

    public $sede_id;
    public $cajeros;
    public $cajero_id;
    public $recibos=[];

    public $valor_total=0;
    public $valor_anulado=0;
    public $valor_efectivoT=0;
    public $comentarios;
    public $dinero_entegado;

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


    public $status=1;

    public function mount(){
        $this->id_concepto=ConceptoPago::where('name', 'Descuento')->first();
    }

    public function updatedSedeId(){
        $this->reset('cajero_id');

        $datos=ReciboPago::where('sede_id', $this->sede_id)
                            ->where('cierre', null)
                            ->where('status', '!=', 1)
                            ->select('creador_id')
                            ->get();

        $ids=array();
        foreach ($datos as $value) {
            if(in_array($value->creador_id,$ids)){

            }else{
                array_push($ids,$value->creador_id);
            }
        }

        $this->cajeros=User::whereIn('id',$ids)
                                ->orderBy('name', 'ASC')
                                ->get();
    }

    public function updatedCajeroId(){

        $this->recibos=ReciboPago::where('sede_id', $this->sede_id)
                                    ->where('creador_id', $this->cajero_id)
                                    ->where('cierre', null)
                                    ->where('status', '!=', 1)
                                    ->get();

        $this->valor_total=ReciboPago::where('sede_id', $this->sede_id)
                                        ->where('creador_id', $this->cajero_id)
                                        ->where('cierre', null)
                                        ->where('status', 0)
                                        ->sum('valor_total');

        $this->descuentosT=ReciboPago::where('sede_id', $this->sede_id)
                                        ->where('creador_id', $this->cajero_id)
                                        ->where('cierre', null)
                                        ->where('status', 0)
                                        ->sum('descuento');

        $this->valor_anulado=ReciboPago::where('sede_id', $this->sede_id)
                                        ->where('creador_id', $this->cajero_id)
                                        ->where('cierre', null)
                                        ->where('status', 2)
                                        ->sum('valor_total');

        $this->valor_efectivoT = DB::table('concepto_pago_recibo_pago')
                                    ->join('recibo_pagos', 'concepto_pago_recibo_pago.recibo_pago_id', '=', 'recibo_pagos.id')
                                    ->where('recibo_pagos.sede_id', $this->sede_id)
                                    ->where('recibo_pagos.creador_id', $this->cajero_id)
                                    ->where('recibo_pagos.status', 0)
                                    ->where('concepto_pago_recibo_pago.tipo', '!=', 'financiero')
                                    ->where('concepto_pago_recibo_pago.medio', 'efectivo')
                                    ->sum('concepto_pago_recibo_pago.valor');

        $this->carteradet($this->cajero_id);
    }

    private function sedes(){
        return Sede::query()
                    ->with(['users'])
                    ->when(Auth::user()->id, function($qu){
                        return $qu->where('status', true)
                                ->whereHas('users', function($q){
                                    $q->where('user_id', Auth::user()->id);
                                });
                    })
                    ->orderBy('name')
                    ->get();
    }

    public function render()
    {
        return view('livewire.financiera.cierre-caja.cierre-cajas-crear', [
            'sedes'=>$this->sedes(),
        ]);
    }


}

/*

    public function herramientasdet(){
        $this->valor_herramientas = DB::table('concepto_pago_recibo_pago')
                                    ->join('recibo_pagos', 'concepto_pago_recibo_pago.recibo_pago_id', '=', 'recibo_pagos.id')
                                    ->where('recibo_pagos.sede_id', $this->sede_id)
                                    ->where('recibo_pagos.creador_id', $this->cajero_id)
                                    ->where('recibo_pagos.status', 0)
                                    ->where('concepto_pago_recibo_pago.tipo', 'inventario')
                                    //->where('concepto_pago_recibo_pago.medio', 'efectivo')
                                    ->sum('concepto_pago_recibo_pago.valor');

        $this->valor_efectivo_h = DB::table('concepto_pago_recibo_pago')
                                    ->join('recibo_pagos', 'concepto_pago_recibo_pago.recibo_pago_id', '=', 'recibo_pagos.id')
                                    ->where('recibo_pagos.sede_id', $this->sede_id)
                                    ->where('recibo_pagos.creador_id', $this->cajero_id)
                                    ->where('recibo_pagos.status', 0)
                                    ->where('concepto_pago_recibo_pago.tipo', 'inventario')
                                    ->where('concepto_pago_recibo_pago.medio', 'efectivo')
                                    ->sum('concepto_pago_recibo_pago.valor');

        $this->valor_tarjeta_h = DB::table('concepto_pago_recibo_pago')
                                    ->join('recibo_pagos', 'concepto_pago_recibo_pago.recibo_pago_id', '=', 'recibo_pagos.id')
                                    ->where('recibo_pagos.sede_id', $this->sede_id)
                                    ->where('recibo_pagos.creador_id', $this->cajero_id)
                                    ->where('recibo_pagos.status', 0)
                                    ->where('concepto_pago_recibo_pago.tipo', 'inventario')
                                    ->whereIn('concepto_pago_recibo_pago.medio', ['tarjeta credito', 'tarjeta debito'])
                                    ->sum('concepto_pago_recibo_pago.valor');

        $this->valor_cheque_h = DB::table('concepto_pago_recibo_pago')
                                    ->join('recibo_pagos', 'concepto_pago_recibo_pago.recibo_pago_id', '=', 'recibo_pagos.id')
                                    ->where('recibo_pagos.sede_id', $this->sede_id)
                                    ->where('recibo_pagos.creador_id', $this->cajero_id)
                                    ->where('recibo_pagos.status', 0)
                                    ->where('concepto_pago_recibo_pago.tipo', 'inventario')
                                    ->where('concepto_pago_recibo_pago.medio', 'cheque')
                                    ->sum('concepto_pago_recibo_pago.valor');

        $this->valor_consignacion_h = DB::table('concepto_pago_recibo_pago')
                                    ->join('recibo_pagos', 'concepto_pago_recibo_pago.recibo_pago_id', '=', 'recibo_pagos.id')
                                    ->where('recibo_pagos.sede_id', $this->sede_id)
                                    ->where('recibo_pagos.creador_id', $this->cajero_id)
                                    ->where('recibo_pagos.status', 0)
                                    ->where('concepto_pago_recibo_pago.tipo', 'inventario')
                                    ->whereIn('concepto_pago_recibo_pago.medio', ['consignacion', 'PSE', ])
                                    ->sum('concepto_pago_recibo_pago.valor');

        $this->otrosdet();
    }
    */



    /* public $valor_herramientas=0;
    public $valor_efectivo_h=0;
    public $valor_tarjeta_h=0;
    public $valor_cheque_h=0;
    public $valor_consignacion_h=0; */
