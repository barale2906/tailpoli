<?php

namespace App\Livewire\Financiera\CerrarCaja;

use Livewire\Component;
use App\Traits\ComunesTrait;
use App\Models\Financiera\ReciboPago;
use App\Models\Financiera\ConceptoPago;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class CierraJornadaCajero extends Component
{
    use ComunesTrait;

    public $ruta=1;

    public $reciboscaja;
    public $sedes;
    public $sede_id;
    public $cajero_id;

    //Ids de los parámetros de control
    public $recibosids=[];
    public $conceptosids=[];
    public $carteraids=[];
    public $otrosids=[];
    public $descuentosids=[];
    public $tarjetasids=[];

    public $resumen;
    public $pensiones;
    public $movimientosacademico;
    public $totaltarjeta;
    public $totalpensiones;
    public $totalefectivopensiones;
    public $totalchequepensiones;
    public $totaltarjetapensiones;
    public $totaltransaccionpensiones;
    public $totaldesefectivo;

    public $totalmedios;



    public $valor_total;
    public $reciboselegidos;

    public function mount($ruta=null){

        $this->cierre();
        $this->recibos(Auth::user()->id);
        $this->ruta=$ruta;

    }

    public function sedesinlegalizar(){
        $sedes=ReciboPago::where('status', '!==', 1)
                                ->where('cierre', null)
                                ->select('sede_id')
                                ->groupBy('sede_id')
                                ->get();

        $ids=array();
        foreach ($sedes as $value) {
            array_push($ids,$value->sede_id);
        }

        $this->sedes=Sede::whereIn('id',$ids)
                            ->orderBy('name', 'ASC')
                            ->get();
    }

    public function recibos($usuario){

        $this->cajero_id=$usuario;
        $this->reciboscaja=ReciboPago::where('creador_id', $usuario)
                                    ->where('status', '!==', 1)
                                    ->get();

        $this->sedescajero();
    }

    public function sedescajero(){

        $ids=array();

        foreach ($this->reciboscaja as $value) {

            if(in_array($value->sede_id, $ids)){

            }else{
                array_push($ids,$value->sede_id);
            }

        }

        if(count($ids)===1){

            $this->sede_id=$ids[0];
            $this->updatedSedeId();
        }else{

            $this->sedes=Sede::whereIn('id',$ids)
                                ->orderBy('name', 'ASC')
                                ->get();
        }


    }

    public function updatedSedeId(){

        $this->reset('valor_total');
        $this->reciboselegidos=ReciboPago::where('creador_id', $this->cajero_id)
                                            ->where('status', 0)
                                            ->where('sede_id', $this->sede_id)
                                            ->where('cierre', null)
                                            ->get();

        $this->valor_total=$this->reciboselegidos->sum('valor_total');

        $this->basescalculo();
    }

    public function basescalculo(){
        $this->reset([
            'recibosids',
            'conceptosids',
            'carteraids',
            'otrosids',
            'descuentosids',
            'tarjetasids',
        ]);

        foreach ($this->reciboselegidos as $value) {
            array_push($this->recibosids,$value->id);
        }


        $conceptos=DB::table('concepto_pago_recibo_pago')
                        ->whereIn('recibo_pago_id', $this->recibosids)
                        ->select('concepto_pago_id')
                        ->groupBy('concepto_pago_id')
                        ->orderBy('concepto_pago_id')
                        ->get();

        foreach ($conceptos as $value) {
            array_push($this->conceptosids,$value->concepto_pago_id);
        }

        // obtener ids Cartera
        $cartera=ConceptoPago::whereIn('id', $this->conceptosids)
                                ->where('tipo', 'cartera')
                                ->select('id')
                                ->get();

        foreach ($cartera as $value) {
            array_push($this->carteraids,$values->id);
        }

        // obtener ids descuento

        $descuento = ConceptoPago::whereIn('id', $this->conceptosids)
                                    ->where('tipo', 'financiero')
                                    ->where('name', 'like', '%descuento%')
                                    ->select('id')
                                    ->get();

        foreach ($descuento as $value) {
            array_push($this->descuentosids, $value->id);
        }

        // obtener ids tarjeta

        $tarjeta = ConceptoPago::whereIn('id', $this->conceptosids)
                                    ->where('tipo', 'financiero')
                                    ->where('name', 'like', '%tarjeta%')
                                    ->select('id')
                                    ->get();

        foreach ($tarjeta as $value) {
            array_push($this->tarjetasids, $value->id);
        }

        // buscar los ids de otros

        foreach ($this->carteraids as $value) {
            array_push($this->otrosids, $value);
        }

        foreach ($this->descuentosids as $value) {
            array_push($this->otrosids, $value);
        }

        foreach ($this->tarjetasids as $value) {
            array_push($this->otrosids, $value);
        }

        $this->calculatotales();

    }

    public function calculatotales(){

        $this->resumen=DB::table('concepto_pago_recibo_pago')
                            ->join('concepto_pagos', 'concepto_pago_recibo_pago.concepto_pago_id', '=', 'concepto_pagos.id')
                            ->join('recibo_pagos', 'concepto_pago_recibo_pago.recibo_pago_id', '=', 'recibo_pagos.id')
                            ->whereIn('concepto_pago_recibo_pago.recibo_pago_id', $this->recibosids)
                            ->select(
                                'recibo_pagos.numero_recibo',
                                'recibo_pagos.fecha',
                                'recibo_pagos.valor_total',
                                'recibo_pagos.descuento',
                                'concepto_pagos.name',
                                'concepto_pago_recibo_pago.tipo',
                                'concepto_pago_recibo_pago.medio',
                                'concepto_pago_recibo_pago.valor',
                                'concepto_pago_recibo_pago.producto',
                                'concepto_pago_recibo_pago.cantidad',
                                'concepto_pago_recibo_pago.unitario',
                                )
                            ->get();

        //Acádemico
        $this->movimientosacademico=DB::table('concepto_pago_recibo_pago')
                                        ->whereIn('recibo_pago_id', $this->recibosids)
                                        ->whereIn('concepto_pago_id', $this->carteraids)
                                        ->get();


        //total ingresos por tarjeta
        $this->totaltarjeta=DB::table('concepto_pago_recibo_pago')
                                ->whereIn('recibo_pago_id', $this->recibosids)
                                ->whereIn('concepto_pago_id', $this->tarjetasids)
                                ->sum('valor');


        // total pensiones
        $this->totalpensiones=$this->movimientosacademico->sum('valor');

        // total efectivo pensiones
        $this->totalefectivopensiones=$this->movimientosacademico->where('medio','efectivo')->sum('valor');

        // total cheque pensiones
        $this->totalchequepensiones=$this->movimientosacademico->where('medio','cheque')->sum('valor');

        // total transaccion pensiones
        $this->totaltransaccionpensiones=$this->movimientosacademico->whereIn('medio', ['consignacion', 'PSE'])->sum('valor');

        // total tarjeta pensiones
        $this->totaltarjetapensiones=$this->movimientosacademico->where('medio', 'like','%tarjeta%')->sum('valor');

        $this->totalizapormedio();
        $this->totalizadescuentoefectivo();

    }

    public function totalizapormedio(){

        $this->totalmedios=ReciboPago::whereIn('id', $this->recibosids)
                                        ->select('medio', DB::raw('SUM(valor_total) as total'))
                                        ->groupBy('medio')
                                        ->orderBy('medio')
                                        ->get();
    }

    public function totalizadescuentoefectivo(){

        $this->totaldesefectivo=DB::table('concepto_pago_recibo_pago')
                                    ->whereIn('recibo_pago_id', $this->recibosids)
                                    ->whereIn('concepto_pago_id', $this->descuentosids)
                                    ->sum('valor');
    }

    public function creaciprerre(){
        dd('excelente');
    }

    public function render()
    {
        return view('livewire.financiera.cerrar-caja.cierra-jornada-cajero');
    }
}
