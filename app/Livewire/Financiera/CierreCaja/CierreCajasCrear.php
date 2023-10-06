<?php

namespace App\Livewire\Financiera\CierreCaja;

use App\Models\Configuracion\Sede;
use App\Models\Financiera\CierreCaja;
use App\Models\Financiera\ReciboPago;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CierreCajasCrear extends Component
{
    public $sede_id;
    public $cajeros=[];
    public $cajero_id;
    public $recibos=[];

    public $valor_total=0;
    public $valor_anulado=0;
    public $valor_efectivoT=0;
    public $observaciones;

    public $valor_pensiones=0;
    public $valor_efectivo=0;
    public $valor_tarjeta=0;
    public $valor_cheque=0;
    public $valor_consignacion=0;

    public $valor_herramientas=0;
    public $valor_efectivo_h=0;
    public $valor_tarjeta_h=0;
    public $valor_cheque_h=0;
    public $valor_consignacion_h=0;

    public $valor_otros=0;
    public $valor_efectivo_o=0;
    public $valor_tarjeta_o=0;
    public $valor_cheque_o=0;
    public $valor_consignacion_o=0;

    /**
     * Reglas de validación
     */
    protected $rules = [
        'valor_total' => 'required',
        'observaciones' => 'required'
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset('valor_total', 'observaciones');
    }

    public function updatedSedeId(){
        $this->reset('cajero_id');

        $datos=ReciboPago::where('sede_id', $this->sede_id)
                                    ->get();

        $agrupar=$datos->groupBy('creador_id');
        $this->cajeros=$agrupar->all();
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
                                    ->where('concepto_pago_recibo_pago.medio', 'efectivo')
                                    ->sum('concepto_pago_recibo_pago.valor');

        $this->totalizardeta();
    }

    public function totalizardeta(){

        $this->valor_efectivoT = DB::table('concepto_pago_recibo_pago')
                                    ->join('recibo_pagos', 'concepto_pago_recibo_pago.recibo_pago_id', '=', 'recibo_pagos.id')
                                    ->where('recibo_pagos.sede_id', $this->sede_id)
                                    ->where('recibo_pagos.creador_id', $this->cajero_id)
                                    ->where('recibo_pagos.status', 0)
                                    ->where('concepto_pago_recibo_pago.medio', 'efectivo')
                                    ->sum('concepto_pago_recibo_pago.valor');

        $this->carteradet();
    }

    public function carteradet(){

        $this->valor_pensiones = DB::table('concepto_pago_recibo_pago')
                                    ->join('recibo_pagos', 'concepto_pago_recibo_pago.recibo_pago_id', '=', 'recibo_pagos.id')
                                    ->where('recibo_pagos.sede_id', $this->sede_id)
                                    ->where('recibo_pagos.creador_id', $this->cajero_id)
                                    ->where('recibo_pagos.status', 0)
                                    ->where('concepto_pago_recibo_pago.tipo', 'cartera')
                                    //->where('concepto_pago_recibo_pago.medio', 'efectivo')
                                    ->sum('concepto_pago_recibo_pago.valor');

        $this->valor_efectivo = DB::table('concepto_pago_recibo_pago')
                                    ->join('recibo_pagos', 'concepto_pago_recibo_pago.recibo_pago_id', '=', 'recibo_pagos.id')
                                    ->where('recibo_pagos.sede_id', $this->sede_id)
                                    ->where('recibo_pagos.creador_id', $this->cajero_id)
                                    ->where('recibo_pagos.status', 0)
                                    ->where('concepto_pago_recibo_pago.tipo', 'cartera')
                                    ->where('concepto_pago_recibo_pago.medio', 'efectivo')
                                    ->sum('concepto_pago_recibo_pago.valor');

        $this->valor_tarjeta = DB::table('concepto_pago_recibo_pago')
                                    ->join('recibo_pagos', 'concepto_pago_recibo_pago.recibo_pago_id', '=', 'recibo_pagos.id')
                                    ->where('recibo_pagos.sede_id', $this->sede_id)
                                    ->where('recibo_pagos.creador_id', $this->cajero_id)
                                    ->where('recibo_pagos.status', 0)
                                    ->where('concepto_pago_recibo_pago.tipo', 'cartera')
                                    ->whereIn('concepto_pago_recibo_pago.medio', ['tarjeta credito', 'tarjeta debito'])
                                    ->sum('concepto_pago_recibo_pago.valor');

        $this->valor_cheque = DB::table('concepto_pago_recibo_pago')
                                    ->join('recibo_pagos', 'concepto_pago_recibo_pago.recibo_pago_id', '=', 'recibo_pagos.id')
                                    ->where('recibo_pagos.sede_id', $this->sede_id)
                                    ->where('recibo_pagos.creador_id', $this->cajero_id)
                                    ->where('recibo_pagos.status', 0)
                                    ->where('concepto_pago_recibo_pago.tipo', 'cartera')
                                    ->where('concepto_pago_recibo_pago.medio', 'cheque')
                                    ->sum('concepto_pago_recibo_pago.valor');

        $this->valor_consignacion = DB::table('concepto_pago_recibo_pago')
                                    ->join('recibo_pagos', 'concepto_pago_recibo_pago.recibo_pago_id', '=', 'recibo_pagos.id')
                                    ->where('recibo_pagos.sede_id', $this->sede_id)
                                    ->where('recibo_pagos.creador_id', $this->cajero_id)
                                    ->where('recibo_pagos.status', 0)
                                    ->where('concepto_pago_recibo_pago.tipo', 'cartera')
                                    ->whereIn('concepto_pago_recibo_pago.medio', ['consignacion', 'PSE', ])
                                    ->sum('concepto_pago_recibo_pago.valor');

        $this->herramientasdet();

    }

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

    public function otrosdet(){
        $this->valor_otros = DB::table('concepto_pago_recibo_pago')
                                    ->join('recibo_pagos', 'concepto_pago_recibo_pago.recibo_pago_id', '=', 'recibo_pagos.id')
                                    ->where('recibo_pagos.sede_id', $this->sede_id)
                                    ->where('recibo_pagos.creador_id', $this->cajero_id)
                                    ->where('recibo_pagos.status', 0)
                                    ->where('concepto_pago_recibo_pago.tipo', 'otro')
                                    //->where('concepto_pago_recibo_pago.medio', 'efectivo')
                                    ->sum('concepto_pago_recibo_pago.valor');

        $this->valor_efectivo_o = DB::table('concepto_pago_recibo_pago')
                                    ->join('recibo_pagos', 'concepto_pago_recibo_pago.recibo_pago_id', '=', 'recibo_pagos.id')
                                    ->where('recibo_pagos.sede_id', $this->sede_id)
                                    ->where('recibo_pagos.creador_id', $this->cajero_id)
                                    ->where('recibo_pagos.status', 0)
                                    ->where('concepto_pago_recibo_pago.tipo', 'otro')
                                    ->where('concepto_pago_recibo_pago.medio', 'efectivo')
                                    ->sum('concepto_pago_recibo_pago.valor');

        $this->valor_tarjeta_o = DB::table('concepto_pago_recibo_pago')
                                    ->join('recibo_pagos', 'concepto_pago_recibo_pago.recibo_pago_id', '=', 'recibo_pagos.id')
                                    ->where('recibo_pagos.sede_id', $this->sede_id)
                                    ->where('recibo_pagos.creador_id', $this->cajero_id)
                                    ->where('recibo_pagos.status', 0)
                                    ->where('concepto_pago_recibo_pago.tipo', 'otro')
                                    ->whereIn('concepto_pago_recibo_pago.medio', ['tarjeta credito', 'tarjeta debito'])
                                    ->sum('concepto_pago_recibo_pago.valor');

        $this->valor_cheque_o = DB::table('concepto_pago_recibo_pago')
                                    ->join('recibo_pagos', 'concepto_pago_recibo_pago.recibo_pago_id', '=', 'recibo_pagos.id')
                                    ->where('recibo_pagos.sede_id', $this->sede_id)
                                    ->where('recibo_pagos.creador_id', $this->cajero_id)
                                    ->where('recibo_pagos.status', 0)
                                    ->where('concepto_pago_recibo_pago.tipo', 'otro')
                                    ->where('concepto_pago_recibo_pago.medio', 'cheque')
                                    ->sum('concepto_pago_recibo_pago.valor');

        $this->valor_consignacion_o = DB::table('concepto_pago_recibo_pago')
                                    ->join('recibo_pagos', 'concepto_pago_recibo_pago.recibo_pago_id', '=', 'recibo_pagos.id')
                                    ->where('recibo_pagos.sede_id', $this->sede_id)
                                    ->where('recibo_pagos.creador_id', $this->cajero_id)
                                    ->where('recibo_pagos.status', 0)
                                    ->where('concepto_pago_recibo_pago.tipo', 'otro')
                                    ->whereIn('concepto_pago_recibo_pago.medio', ['consignacion', 'PSE', ])
                                    ->sum('concepto_pago_recibo_pago.valor');
    }

    // Crear
    public function new(){
        // validate
        $this->validate();

        //Crear registro
        CierreCaja::create([
            'name'=>strtolower($this->name),
            'tipo'=>strtolower($this->tipo),
        ]);

        // Notificación
        $this->dispatch('alerta', name:'Se ha creado correctamente el concepto de pago: '.$this->name);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('created');
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
