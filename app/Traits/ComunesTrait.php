<?php

namespace App\Traits;

use App\Models\Financiera\CierreCaja;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Financiera\ConceptoPago;


trait ComunesTrait
{


    public $is_dia=true;
    public $idsrecibos=[];
    public $idsconceptos=[];
    public $idscartera=[];
    public $idsotros=[];
    public $idsdescuentos=[];
    public $idstarjetas=[];


    public function cierre(){

        $this->reset('is_dia');
        $fecha=now();
        $fecha=date('Y-m-d');

        $cerrado=CierreCaja::where('dia', false)
                            ->where('fecha', $fecha)
                            ->where('cajero_id', Auth::user()->id)
                            ->count('id');

        if($cerrado>0){
            $this->is_dia=!$this->is_dia;
        }


    }

    public function carteradet($usuario){

        $this->reset(
            'idsrecibos',
            'idsconceptos',
            'idscartera',
            'idsotros',
            'idsdescuentos',
            'idstarjetas',
        );

        foreach ($this->recibos as $value) {
            array_push($this->idsrecibos, $value->id);
        }

        $conceptos=DB::table('concepto_pago_recibo_pago')
                        ->whereIn('recibo_pago_id', $this->idsrecibos)
                        ->select('concepto_pago_id')
                        ->groupBy('concepto_pago_id')
                        ->orderBY('concepto_pago_id')
                        ->get();

        foreach ($conceptos as $value) {
            array_push($this->idsconceptos,$value->concepto_pago_id);
        }

        //obtener ids cartera
        $cartera=ConceptoPago::whereIn('id',$this->idsconceptos)
                                ->where('tipo','cartera')
                                ->select('id')
                                ->get();

        foreach ($cartera as $value) {
            array_push($this->idscartera,$value->id);
        }

        // Obtener ids descuentos
        $descuento=ConceptoPago::whereIn('id',$this->idsconceptos)
                                ->where('tipo','financiero')
                                ->where('name', 'like', '%descuento%')
                                ->select('id')
                                ->get();

        foreach ($descuento as $value) {
            array_push($this->idsdescuentos, $value->id);
        }

        //obtener ids tarjetas
        $tarjetas=ConceptoPago::whereIn('id',$this->idsconceptos)
                                ->where('tipo','financiero')
                                ->where('name', 'like', '%tarjeta%')
                                ->select('id')
                                ->get();

        foreach ($tarjetas as $value) {
            array_push($this->idstarjetas, $value->id);
        }

        //Obtener los que no aplican para otros
        foreach ($this->idstarjetas as $value) {
            array_push($this->idsotros, $value);
        }

        foreach ($this->idsdescuentos as $value) {
            array_push($this->idsotros, $value);
        }

        foreach ($this->idscartera as $value) {
            array_push($this->idsotros, $value);
        }

        $this->valor_pensiones = DB::table('concepto_pago_recibo_pago')
                                    ->whereIn('recibo_pago_id',$this->idsrecibos)
                                    ->whereIn('concepto_pago_id',$this->idscartera)
                                    ->get();

        $this->valor_tarjeta = DB::table('concepto_pago_recibo_pago')
                                    ->whereIn('recibo_pago_id',$this->idsrecibos)
                                    ->whereIn('concepto_pago_id',$this->idstarjetas)
                                    ->sum('valor');
                                    /*
                                    ->join('recibo_pagos', 'concepto_pago_recibo_pago.recibo_pago_id', '=', 'recibo_pagos.id')
                                    ->where('recibo_pagos.sede_id', $this->sede_id)
                                    ->where('recibo_pagos.creador_id', $usuario)
                                    ->where('recibo_pagos.status', 0)
                                    ->where('concepto_pago_recibo_pago.tipo', 'cartera')
                                    ->sum('concepto_pago_recibo_pago.valor'); */


        /* $this->valor_efectivo = DB::table('concepto_pago_recibo_pago')
                                    ->join('recibo_pagos', 'concepto_pago_recibo_pago.recibo_pago_id', '=', 'recibo_pagos.id')
                                    ->where('recibo_pagos.sede_id', $this->sede_id)
                                    ->where('recibo_pagos.creador_id', $usuario)
                                    ->where('recibo_pagos.status', 0)
                                    ->where('concepto_pago_recibo_pago.tipo', 'cartera')
                                    ->where('concepto_pago_recibo_pago.medio', 'efectivo')
                                    ->sum('concepto_pago_recibo_pago.valor');


        $this->valor_tarjeta = DB::table('concepto_pago_recibo_pago')
                                    ->join('recibo_pagos', 'concepto_pago_recibo_pago.recibo_pago_id', '=', 'recibo_pagos.id')
                                    ->where('recibo_pagos.sede_id', $this->sede_id)
                                    ->where('recibo_pagos.creador_id', $usuario)
                                    ->where('recibo_pagos.status', 0)
                                    //->where('concepto_pago_recibo_pago.tipo', 'cartera')
                                    ->where('concepto_pago_recibo_pago.medio','like', "%".'Tarjeta'."%" )
                                    ->sum('concepto_pago_recibo_pago.valor');*/

        $this->valor_efectivo=$this->valor_pensiones->where('medio', 'efectivo')->sum('valor');

        dd($this->valor_pensiones->sum('valor'),$this->valor_efectivo, $this->valor_tarjeta);

        $this->valor_cheque = DB::table('concepto_pago_recibo_pago')
                                    ->join('recibo_pagos', 'concepto_pago_recibo_pago.recibo_pago_id', '=', 'recibo_pagos.id')
                                    ->where('recibo_pagos.sede_id', $this->sede_id)
                                    ->where('recibo_pagos.creador_id', $usuario)
                                    ->where('recibo_pagos.status', 0)
                                    ->where('concepto_pago_recibo_pago.tipo', 'cartera')
                                    ->where('concepto_pago_recibo_pago.medio', 'cheque')
                                    ->sum('concepto_pago_recibo_pago.valor');

        $this->valor_consignacion = DB::table('concepto_pago_recibo_pago')
                                    ->join('recibo_pagos', 'concepto_pago_recibo_pago.recibo_pago_id', '=', 'recibo_pagos.id')
                                    ->where('recibo_pagos.sede_id', $this->sede_id)
                                    ->where('recibo_pagos.creador_id', $usuario)
                                    ->where('recibo_pagos.status', 0)
                                    ->where('concepto_pago_recibo_pago.tipo', 'cartera')
                                    ->whereIn('concepto_pago_recibo_pago.medio', ['consignacion', 'PSE'])
                                    ->sum('concepto_pago_recibo_pago.valor');

        $this->otrosdet($usuario);

    }

    public function otrosdet($usuario){
        $this->valor_otros = DB::table('concepto_pago_recibo_pago')
                                    ->join('recibo_pagos', 'concepto_pago_recibo_pago.recibo_pago_id', '=', 'recibo_pagos.id')
                                    ->where('recibo_pagos.sede_id', $this->sede_id)
                                    ->where('recibo_pagos.creador_id', $usuario)
                                    ->where('recibo_pagos.status', 0)
                                    ->where('concepto_pago_recibo_pago.tipo','!=', 'cartera')
                                    ->where('concepto_pago_recibo_pago.tipo', '!=', 'financiero')
                                    ->where('concepto_pago_recibo_pago.concepto_pago_id', '!=', $this->id_concepto->id)
                                    //->where('concepto_pago_recibo_pago.medio', 'efectivo')
                                    ->sum('concepto_pago_recibo_pago.valor');

        $this->valor_efectivo_o = DB::table('concepto_pago_recibo_pago')
                                    ->join('recibo_pagos', 'concepto_pago_recibo_pago.recibo_pago_id', '=', 'recibo_pagos.id')
                                    ->where('recibo_pagos.sede_id', $this->sede_id)
                                    ->where('recibo_pagos.creador_id', $usuario)
                                    ->where('recibo_pagos.status', 0)
                                    ->where('concepto_pago_recibo_pago.tipo', '!=', 'cartera')
                                    ->where('concepto_pago_recibo_pago.tipo', '!=', 'financiero')
                                    ->where('concepto_pago_recibo_pago.concepto_pago_id', '!=', $this->id_concepto->id)
                                    ->where('concepto_pago_recibo_pago.medio', 'efectivo')
                                    ->sum('concepto_pago_recibo_pago.valor');

        /* $this->valor_tarjeta_o = DB::table('concepto_pago_recibo_pago')
                                    ->join('recibo_pagos', 'concepto_pago_recibo_pago.recibo_pago_id', '=', 'recibo_pagos.id')
                                    ->where('recibo_pagos.sede_id', $this->sede_id)
                                    ->where('recibo_pagos.creador_id', $usuario)
                                    ->where('recibo_pagos.status', 0)
                                    ->where('concepto_pago_recibo_pago.tipo', '!=', 'cartera')
                                    ->where('concepto_pago_recibo_pago.concepto_pago_id', '!=', $this->id_concepto->id)
                                    ->where('concepto_pago_recibo_pago.medio', 'tarjeta')
                                    ->sum('concepto_pago_recibo_pago.valor'); */

        $this->valor_cheque_o = DB::table('concepto_pago_recibo_pago')
                                    ->join('recibo_pagos', 'concepto_pago_recibo_pago.recibo_pago_id', '=', 'recibo_pagos.id')
                                    ->where('recibo_pagos.sede_id', $this->sede_id)
                                    ->where('recibo_pagos.creador_id', $usuario)
                                    ->where('recibo_pagos.status', 0)
                                    ->where('concepto_pago_recibo_pago.tipo', '!=', 'cartera')
                                    ->where('concepto_pago_recibo_pago.tipo', '!=', 'financiero')
                                    ->where('concepto_pago_recibo_pago.concepto_pago_id', '!=', $this->id_concepto->id)
                                    ->where('concepto_pago_recibo_pago.medio', 'cheque')
                                    ->sum('concepto_pago_recibo_pago.valor');

        $this->valor_consignacion_o = DB::table('concepto_pago_recibo_pago')
                                    ->join('recibo_pagos', 'concepto_pago_recibo_pago.recibo_pago_id', '=', 'recibo_pagos.id')
                                    ->where('recibo_pagos.sede_id', $this->sede_id)
                                    ->where('recibo_pagos.creador_id', $usuario)
                                    ->where('recibo_pagos.status', 0)
                                    ->where('concepto_pago_recibo_pago.tipo', '!=', 'cartera')
                                    ->where('concepto_pago_recibo_pago.tipo', '!=', 'financiero')
                                    ->where('concepto_pago_recibo_pago.concepto_pago_id', '!=', $this->id_concepto->id)
                                    ->whereIn('concepto_pago_recibo_pago.medio', ['consignacion', 'PSE'])
                                    ->sum('concepto_pago_recibo_pago.valor');
    }
}
