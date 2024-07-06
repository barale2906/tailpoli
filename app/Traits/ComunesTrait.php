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
    public $pensiones;
    public $otros;


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

    public function carteradet(){

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

        $this->pensiones = DB::table('concepto_pago_recibo_pago')
                                    ->whereIn('recibo_pago_id',$this->idsrecibos)
                                    ->whereIn('concepto_pago_id',$this->idscartera)
                                    ->get();

        $this->valor_tarjeta = DB::table('concepto_pago_recibo_pago')
                                    ->whereIn('recibo_pago_id',$this->idsrecibos)
                                    ->whereIn('concepto_pago_id',$this->idstarjetas)
                                    ->sum('valor');

        $this->valor_pensiones=$this->pensiones->sum('valor');

        $this->valor_efectivo=$this->pensiones->where('medio', 'efectivo')->sum('valor');

        $this->valor_cheque = $this->pensiones->whereIn('medio', 'cheque')->sum('valor');

        $this->valor_consignacion = $this->pensiones->where('medio', ['consignacion', 'PSE'])->sum('valor');

        $this->otrosdet();

    }

    public function otrosdet(){

        $this->otros=DB::table('concepto_pago_recibo_pago')
                        ->whereIn('recibo_pago_id',$this->idsrecibos)
                        ->whereNotIn('concepto_pago_id',$this->idsotros)
                        ->get();

        $this->valor_otros = $this->otros->sum('valor');

        $this->valor_efectivo_o = $this->otros->where('medio','efectivo')->sum('valor');

        $this->valor_cheque_o = $this->otros->where('medio','cheque')->sum('valor');

        $this->valor_consignacion_o = $this->otros->whereIn('medio',['consignacion', 'PSE'])->sum('valor');

    }
}
