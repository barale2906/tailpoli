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
    public $valor_consignación_h=0;

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
                                    ->get();

        $this->valor_total=ReciboPago::where('sede_id', $this->sede_id)
                                        ->where('creador_id', $this->cajero_id)
                                        ->sum('valor_total');

        $this->totalizardeta();
    }

    public function totalizardeta(){

        foreach ($this->recibos as $value) {
            switch ($value->medio) {
                case 'value':
                    # code...
                    break;

                default:
                    # code...
                    break;
            }
        }

            $detalle = DB::table('concepto_pago_recibo_pago')
                            ->where('concepto_pago_recibo_pago.recibo_pago_id',$this->sede_id)
                            ->join('concepto_pagos', 'concepto_pago_recibo_pago.concepto_pago_id', '=', 'concepto_pagos.id')
                            ->select('concepto_pagos.name', 'concepto_pago_recibo_pago.valor', 'concepto_pago_recibo_pago.tipo', 'concepto_pago_recibo_pago.id_relacional')
                            ->get();
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
