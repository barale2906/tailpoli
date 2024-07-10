<?php

namespace App\Traits;

use App\Models\Financiera\ReciboPago;
use App\Models\Financiera\ConceptoPago;
use App\Models\Financiera\CierreCaja;
use App\Models\Configuracion\Sede;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

trait CajaCierraTrait
{
    public $reciboscaja;
    public $sedes;
    public $numerosedes=true;
    public $sede_id;
    public $cajero_id;
    public $unica;
    public $valor_anulado;

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
    public $tarjetaventa; //Verificar diferencias con l anterior
    public $totalpensiones;
    public $totalefectivopensiones;
    public $totalchequepensiones;
    public $totaltarjetapensiones;
    public $totaltransaccionpensiones;
    public $totaldesefectivo;
    public $totalefectivo;
    public $efectivoentrega;

    public $totalmedios;

    public $dinero_entegado;
    public $comentarios;
    public $valor_total;
    public $descuentosT;
    public $reciboselegidos;

    public $valor_otros;
    public $valor_efectivo_o;
    public $valor_cheque_o;
    public $valor_consignacion_o;
    public $valor_tarjetas_o;
    public $dia=false;

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

        $this->reciboscaja=ReciboPago::where('creador_id', $usuario)
                                    ->where('status', '!==', 1)
                                    ->where('cierre', null)
                                    ->get();

        $this->cajero_id=$usuario;
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
            $this->unica=Sede::find($ids[0]);
            $this->updatedCajeroId();
        }else{

            $this->numerosedes=false;
            $this->sedes=Sede::whereIn('id',$ids)
                                ->orderBy('name', 'ASC')
                                ->get();
        }


    }

    public function eligesede(){
        $this->updatedCajeroId();
    }

    public function updatedCajeroId(){

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
            array_push($this->carteraids,$value->id);
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

        $this->valor_anulado=ReciboPago::where('creador_id', $this->cajero_id)
                                        ->where('status', 2)
                                        ->where('cierre', null)
                                        ->sum('valor_total');

        //Descuento total
        $this->descuentosT=DB::table('concepto_pago_recibo_pago')
                                ->whereIn('recibo_pago_id', $this->recibosids)
                                ->whereIn('concepto_pago_id', $this->descuentosids)
                                ->sum('valor');

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
        $this->calculaotrostotales();
    }

    public function calculaotrostotales(){

        //otros
        $this->otros=DB::table('concepto_pago_recibo_pago')
                        ->whereIn('recibo_pago_id',$this->recibosids)
                        ->whereNotIn('concepto_pago_id',$this->otrosids)
                        ->get();

        $this->valor_otros = $this->otros->sum('valor');

        $this->valor_efectivo_o = $this->otros->where('medio','efectivo')->sum('valor');

        $this->valor_cheque_o = $this->otros->where('medio','cheque')->sum('valor');

        $this->valor_consignacion_o = $this->otros->whereIn('medio',['consignacion', 'PSE'])->sum('valor');

        $this->valor_tarjetas_o = $this->otros->where('medio', 'like', '%Tarjeta%')->sum('valor');
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
                                    ->whereIn('recibo_pago_id',$this->recibosids)
                                    ->whereIn('concepto_pago_id',$this->descuentosids)
                                    ->where('medio','efectivo')
                                    ->sum('valor');

        foreach ($this->totalmedios as $value) {
            if($value->medio==='efectivo'){
                $this->efectivoentrega=$value->total-$this->totaldesefectivo; //Efectivo que debe entregar
                $this->totalefectivo=$value->total;
            }

            if (strpos($value->medio, 'Tarjeta') !== false) {
                $this->tarjetaventa=$this->tarjetaventa+$value->total;
            }
        }
    }

    /**
     * Reglas de validación
     */
    protected $rules = [
        'valor_total'       => 'required',
        'comentarios'       => 'required',
        'dinero_entegado'   => 'required'
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset('valor_total', 'comentarios', 'dinero_entegado');
    }

    public function generaCierre($origen=null){

        if($origen){
            $this->dinero_entegado=0;
            $this->dia=true;
        }

        // validate
        $this->validate();

        $cierre=CierreCaja::create([
            'fecha_cierre'=>now(),
            'fecha'=>now(),
            'valor_total'=>$this->valor_total,
            'valor_reportado'=>$this->dinero_entegado,
            'efectivo'=>$this->totalefectivo,
            'efectivo_descuento'=>$this->totaldesefectivo,
            'efectivo_disponible'=>$this->efectivoentrega,
            'cobro_tarjeta'=>$this->totaltarjeta,
            'tarjeta'=>$this->tarjetaventa,
            'descuentotal'=>$this->descuentosT,
            'observaciones'=>$this->comentarios,

            'valor_pensiones'=>$this->totalpensiones,
            'valor_efectivo'=>$this->totalefectivopensiones,
            'valor_tarjeta'=>$this->totaltarjetapensiones,
            'valor_cheque'=>$this->totalchequepensiones,
            'valor_consignacion'=>$this->totaltransaccionpensiones,

            'valor_otros'=>$this->valor_otros,
            'valor_efectivo_o'=>$this->valor_efectivo_o,
            'valor_tarjeta_o'=>$this->valor_otros-$this->valor_efectivo_o-$this->valor_cheque_o-$this->valor_consignacion_o,
            'valor_cheque_o'=>$this->valor_cheque_o,
            'valor_consignacion_o'=>$this->valor_consignacion_o,

            'sede_id'=>$this->sede_id,
            'cajero_id'=>$this->cajero_id,
            'coorcaja_id'=>Auth::user()->id,
            'dia'=>$this->dia
        ]);

        //relacionar recibos
        foreach ($this->reciboselegidos as $value) {

            $this->status=2;

            //Actualizar recibo
            ReciboPago::whereId($value->id)->update([
                                    'status'=>$this->status,
                                    'cierre'=>$cierre->id
                                ]);

            //Cargar recibo al cierre
            DB::table('cierre_caja_recibo_pago')
            ->insert([
                'cierre_caja_id'=>$cierre->id,
                'recibo_pago_id'=>$value->id,
                'created_at'=>now(),
                'updated_at'=>now(),
            ]);
        }

        //agregar recibos anulados

        //Datos de impresión
        $this->elegido=$cierre;

        // Notificación
        $this->dispatch('alerta', name:'Se ha realizado correctamente el cierre de caja N°: '.$cierre->id);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->print=!$this->print;
        //OJO OJO OJO CUADRAR IMPRESIONES

        $ruta='/impresiones/impcierre?o='.$this->ruta.'&c='.$cierre->id;

        $this->redirect($ruta);
    }

}
