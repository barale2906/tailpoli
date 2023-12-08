<?php

namespace App\Livewire\Financiera\ReciboPago;

use App\Models\Financiera\Cartera;
use App\Models\Financiera\EstadoCartera;
use App\Models\Financiera\ReciboPago;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class RecibosPagoAnular extends Component
{
    public $id='';
    public $fecha='';
    public $valor_total = '';
    public $medio='';
    public $observaciones='';
    public $motivo;
    public $reciboActual;
    public $detalles;
    public $estado;
    public $accion;

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
            'id',
            'fecha',
            'valor_total',
            'medio',
            'observaciones'
        );
    }

    public function mount($elegido = null, $accion){
        $this->accion=$accion;
        $this->id=$elegido['id'];
        $this->fecha=$elegido['fecha'];
        $this->valor_total=$elegido['valor_total'];
        $this->medio=$elegido['medio'];
        $this->observaciones=$elegido['observaciones'];
        $this->recibo();
    }

    public function recibo(){
        $this->reciboActual=ReciboPago::find($this->id);
        $this->detalles=DB::table('concepto_pago_recibo_pago')
                            ->where('concepto_pago_recibo_pago.recibo_pago_id',$this->id)
                            ->join('concepto_pagos', 'concepto_pago_recibo_pago.concepto_pago_id', '=', 'concepto_pagos.id')
                            ->select('concepto_pagos.name', 'concepto_pago_recibo_pago.valor', 'concepto_pago_recibo_pago.tipo', 'concepto_pago_recibo_pago.id_relacional')
                            ->get();
    }

    /**
     * Reglas de validación
     */
    protected $rules = [
        'motivo'=> 'required'
    ];

    //Actualizar
    public function edit()
    {
        // validate
        $this->validate();

        //Anular recibo
        ReciboPago::whereId($this->id)->update([
            'status'=>2,
            'observaciones'=>now()." ¡¡ANULADO!! ".Auth::user()->name." Anulo el recibo por: ".$this->motivo.". ----- ".$this->observaciones,
        ]);

        //reversar movimientos cartera - inventario
        foreach ($this->detalles as $value) {

            switch ($value->tipo) {
                case 'cartera':
                    $this->ajusCartera($value);
                    break;

                case 'inventario':
                    $this->ajusInventario($value);
                    break;
            }
        }


        $this->dispatch('alerta', name:'Se ha ANULADO correctamente el recibo de pago N°: '.$this->id);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('Editando');

    }

    public function ajusCartera($value){

        $registro=Cartera::whereId(intval($value->id_relacional))->first();


        $saldo=$registro->saldo+$value->valor;
        $observaciones=now()." ".Auth::user()->name." ANULO EL RECIBO N°: ".$this->id." por el motivo: ".$this->motivo.", se descontaron $ ".number_format($value->valor, 0, ',', '.')." --- ".$registro->observaciones;

        if($saldo>$value->valor){
            $esta=EstadoCartera::where('name', 'abonada')->first();
            $this->estado=$esta->id;
        }else{
            $esta=EstadoCartera::where('name', 'activa')->first();
            $this->estado=$esta->id;
        }

        $registro->update([
            'saldo'=>$saldo,
            'observaciones'=>$observaciones,
            'estado_cartera_id'=>$this->estado,
            'status'=>true
        ]);
    }

    public function ajusInventario($value){

    }

    public function render()
    {
        return view('livewire.financiera.recibo-pago.recibos-pago-anular');
    }
}
