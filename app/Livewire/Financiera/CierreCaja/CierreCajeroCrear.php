<?php

namespace App\Livewire\Financiera\CierreCaja;

use App\Models\Financiera\CierreCaja;
use App\Models\Financiera\ReciboPago;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CierreCajeroCrear extends Component
{
    public $sedes=[];
    public $unica;
    public $sede_id;
    public $agrupado;
    public $recibos;
    public $observaciones;
    public $valor_reportado;
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

    public $print=false;

    public function mount (){
        $this->recibos=ReciboPago::where('creador_id', Auth::user()->id)
                                ->where('status', '!=', 1)
                                ->get();

        $this->sedeMas();
    }

    /**
     * Reglas de validación
     */
    protected $rules = [
        'valor_reportado' => 'required',
        'valor_total'=>'required',
        'observaciones' => 'required'
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset('valor_reportado', 'observaciones', 'valor_total');
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

    public function carteradet(){

        $this->valor_pensiones = DB::table('concepto_pago_recibo_pago')
                                    ->join('recibo_pagos', 'concepto_pago_recibo_pago.recibo_pago_id', '=', 'recibo_pagos.id')
                                    ->where('recibo_pagos.sede_id', $this->sede_id)
                                    ->where('recibo_pagos.creador_id', Auth::user()->id)
                                    ->where('recibo_pagos.status', 0)
                                    ->where('concepto_pago_recibo_pago.tipo', 'cartera')
                                    ->sum('concepto_pago_recibo_pago.valor');

        $this->valor_efectivo = DB::table('concepto_pago_recibo_pago')
                                    ->join('recibo_pagos', 'concepto_pago_recibo_pago.recibo_pago_id', '=', 'recibo_pagos.id')
                                    ->where('recibo_pagos.sede_id', $this->sede_id)
                                    ->where('recibo_pagos.creador_id', Auth::user()->id)
                                    ->where('recibo_pagos.status', 0)
                                    ->where('concepto_pago_recibo_pago.tipo', 'cartera')
                                    ->where('concepto_pago_recibo_pago.medio', 'efectivo')
                                    ->sum('concepto_pago_recibo_pago.valor');

        $this->valor_tarjeta = DB::table('concepto_pago_recibo_pago')
                                    ->join('recibo_pagos', 'concepto_pago_recibo_pago.recibo_pago_id', '=', 'recibo_pagos.id')
                                    ->where('recibo_pagos.sede_id', $this->sede_id)
                                    ->where('recibo_pagos.creador_id', Auth::user()->id)
                                    ->where('recibo_pagos.status', 0)
                                    ->where('concepto_pago_recibo_pago.tipo', 'cartera')
                                    ->whereIn('concepto_pago_recibo_pago.medio', ['tarjeta credito', 'tarjeta debito'])
                                    ->sum('concepto_pago_recibo_pago.valor');

        $this->valor_cheque = DB::table('concepto_pago_recibo_pago')
                                    ->join('recibo_pagos', 'concepto_pago_recibo_pago.recibo_pago_id', '=', 'recibo_pagos.id')
                                    ->where('recibo_pagos.sede_id', $this->sede_id)
                                    ->where('recibo_pagos.creador_id', Auth::user()->id)
                                    ->where('recibo_pagos.status', 0)
                                    ->where('concepto_pago_recibo_pago.tipo', 'cartera')
                                    ->where('concepto_pago_recibo_pago.medio', 'cheque')
                                    ->sum('concepto_pago_recibo_pago.valor');

        $this->valor_consignacion = DB::table('concepto_pago_recibo_pago')
                                    ->join('recibo_pagos', 'concepto_pago_recibo_pago.recibo_pago_id', '=', 'recibo_pagos.id')
                                    ->where('recibo_pagos.sede_id', $this->sede_id)
                                    ->where('recibo_pagos.creador_id', Auth::user()->id)
                                    ->where('recibo_pagos.status', 0)
                                    ->where('concepto_pago_recibo_pago.tipo', 'cartera')
                                    ->whereIn('concepto_pago_recibo_pago.medio', ['consignacion', 'PSE', ])
                                    ->sum('concepto_pago_recibo_pago.valor');

        $this->otrosdet();

    }

    public function otrosdet(){
        $this->valor_otros = DB::table('concepto_pago_recibo_pago')
                                    ->join('recibo_pagos', 'concepto_pago_recibo_pago.recibo_pago_id', '=', 'recibo_pagos.id')
                                    ->where('recibo_pagos.sede_id', $this->sede_id)
                                    ->where('recibo_pagos.creador_id', Auth::user()->id)
                                    ->where('recibo_pagos.status', 0)
                                    ->where('concepto_pago_recibo_pago.tipo','!=', 'cartera')
                                    //->where('concepto_pago_recibo_pago.medio', 'efectivo')
                                    ->sum('concepto_pago_recibo_pago.valor');

        $this->valor_efectivo_o = DB::table('concepto_pago_recibo_pago')
                                    ->join('recibo_pagos', 'concepto_pago_recibo_pago.recibo_pago_id', '=', 'recibo_pagos.id')
                                    ->where('recibo_pagos.sede_id', $this->sede_id)
                                    ->where('recibo_pagos.creador_id', Auth::user()->id)
                                    ->where('recibo_pagos.status', 0)
                                    ->where('concepto_pago_recibo_pago.tipo', '!=', 'cartera')
                                    ->where('concepto_pago_recibo_pago.medio', 'efectivo')
                                    ->sum('concepto_pago_recibo_pago.valor');

        $this->valor_tarjeta_o = DB::table('concepto_pago_recibo_pago')
                                    ->join('recibo_pagos', 'concepto_pago_recibo_pago.recibo_pago_id', '=', 'recibo_pagos.id')
                                    ->where('recibo_pagos.sede_id', $this->sede_id)
                                    ->where('recibo_pagos.creador_id', Auth::user()->id)
                                    ->where('recibo_pagos.status', 0)
                                    ->where('concepto_pago_recibo_pago.tipo', '!=', 'cartera')
                                    ->whereIn('concepto_pago_recibo_pago.medio', ['tarjeta credito', 'tarjeta debito'])
                                    ->sum('concepto_pago_recibo_pago.valor');

        $this->valor_cheque_o = DB::table('concepto_pago_recibo_pago')
                                    ->join('recibo_pagos', 'concepto_pago_recibo_pago.recibo_pago_id', '=', 'recibo_pagos.id')
                                    ->where('recibo_pagos.sede_id', $this->sede_id)
                                    ->where('recibo_pagos.creador_id', Auth::user()->id)
                                    ->where('recibo_pagos.status', 0)
                                    ->where('concepto_pago_recibo_pago.tipo', '!=', 'cartera')
                                    ->where('concepto_pago_recibo_pago.medio', 'cheque')
                                    ->sum('concepto_pago_recibo_pago.valor');

        $this->valor_consignacion_o = DB::table('concepto_pago_recibo_pago')
                                    ->join('recibo_pagos', 'concepto_pago_recibo_pago.recibo_pago_id', '=', 'recibo_pagos.id')
                                    ->where('recibo_pagos.sede_id', $this->sede_id)
                                    ->where('recibo_pagos.creador_id', Auth::user()->id)
                                    ->where('recibo_pagos.status', 0)
                                    ->where('concepto_pago_recibo_pago.tipo', '!=', 'cartera')
                                    ->whereIn('concepto_pago_recibo_pago.medio', ['consignacion', 'PSE', ])
                                    ->sum('concepto_pago_recibo_pago.valor');
    }

    // Crear
    public function new(){
        // validate
        $this->validate();

        //Crear registro
        $cierre=CierreCaja::create([
                        'fecha_cierre'=>now(),
                        'valor_total'=>$this->valor_total,
                        'valor_reportado'=>$this->valor_reportado,
                        'observaciones'=>$this->observaciones,

                        'valor_pensiones'=>$this->valor_pensiones,
                        'valor_efectivo'=>$this->valor_efectivo,
                        'valor_tarjeta'=>$this->valor_tarjeta,
                        'valor_cheque'=>$this->valor_cheque,
                        'valor_consignacion'=>$this->valor_consignacion,

                        'valor_otros'=>$this->valor_otros,
                        'valor_efectivo_o'=>$this->valor_efectivo_o,
                        'valor_tarjeta_o'=>$this->valor_tarjeta_o,
                        'valor_cheque_o'=>$this->valor_cheque_o,
                        'valor_consignacion_o'=>$this->valor_consignacion_o,

                        'sede_id'=>$this->sede_id,
                        'cajero_id'=>Auth::user()->id,
                        'coorcaja_id'=>Auth::user()->id
                    ]);

        //relacionar recibos
        foreach ($this->recibos as $value) {
            if($value===2){
                $this->status=2;
            }

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

            $this->reset('status');
        }

        // Notificación
        $this->dispatch('alerta', name:'Se ha realizado correctamente el pre-cierre de caja N°: '.$cierre->id);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->print=!$this->print;
    }

    public function render()
    {
        return view('livewire.financiera.cierre-caja.cierre-cajero-crear');
    }
}
