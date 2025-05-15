<?php

namespace App\Livewire\Financiera\ReciboPago;

use App\Models\Financiera\Cartera;
use App\Models\Financiera\EstadoCartera;
use App\Models\Financiera\ReciboPago;
use App\Models\Financiera\Transaccion;
use App\Models\Inventario\Inventario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

use function Laravel\Prompts\table;

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
                            ->select('concepto_pagos.name', 'concepto_pago_recibo_pago.valor', 'concepto_pago_recibo_pago.tipo', 'concepto_pago_recibo_pago.id_relacional','concepto_pago_recibo_pago.concepto_pago_id')
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

                case 'financiero':
                    $this->ajusDescuento($value);
                    break;

                case 'inventario':
                    $this->ajusInventario($value);
                    break;
            }
        }

        if($this->reciboActual->medio==="transferencia" || $this->reciboActual->medio==="PSE" || $this->reciboActual->medio==="cheque"){
            $this->transacciones();
        }

        $this->dispatch('alerta', name:'Se ha ANULADO correctamente el recibo de pago N°: '.$this->reciboActual->numero_recibo);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('Editando');

    }

    public function transacciones(){
        $reci=Transaccion::where('observaciones', 'like', "%".$this->reciboActual->numero_recibo."%")
                            ->first();

        if($reci){
            $reci->update([
                'status'=>1,
                'status_academico'=>0,
                'observaciones'=>now().': '.Auth::user()->name.' ANULO EL RECIBO: '.$this->reciboActual->numero_recibo.' Y REACTIVO LA TRANSACCIÓN. ----- '.$reci->observaciones,
            ]);
        }
    }

    public function ajusCartera($value){

        $registro=Cartera::whereId(intval($value->id_relacional))->first();


        $saldo=$registro->saldo+$value->valor;
        $observaciones=now()." ".Auth::user()->name." ANULO EL RECIBO N°: ".$this->reciboActual->numero_recibo." por el motivo: ".$this->motivo.", se descontaron $ ".number_format($value->valor, 0, ',', '.')." --- ".$registro->observaciones;

        if($registro->valor>$saldo){
            $esta=EstadoCartera::where('name', 'abonada')->first();
            $this->estado=$esta->id;
        }else if(floatval($registro->valor)===floatval($saldo)){
            $esta=EstadoCartera::where('name', 'activa')->first();
            $this->estado=$esta->id;
        }

        $registro->update([
            'saldo'             =>$saldo,
            'observaciones'     =>$observaciones,
            'estado_cartera_id' =>$this->estado,
            'status'            =>$this->estado,
            'fecha_real'        =>Null
        ]);
    }

    public function ajusDescuento($value){

        if(intval($value->concepto_pago_id)===21){

            $registro=Cartera::whereId(intval($value->id_relacional))->first();
            $valor=$registro->descuento-$value->valor;

            $registro->update([
                'descuento'     =>$valor,
                'fecha_real'    =>Null
            ]);
        }

    }

    public function ajusInventario($value){
        //Buscar el movimiento del registro con el
        $reg=Inventario::where('id',intval($value->id_relacional))->first();
        if($reg->tipo===0){

                $ultimoregistro= Inventario::where('almacen_id', $reg->almacen_id)
                                            ->where('producto_id', $reg->producto_id)
                                            ->where('status', true)
                                            ->first();
                // Crear registro inverso
                $nuevoRegistro=Inventario::create([
                                                'tipo'=>1,
                                                'fecha_movimiento'=>now(),
                                                'cantidad'=>$reg->cantidad,
                                                'saldo'=>$reg->cantidad+$ultimoregistro->saldo,
                                                'precio'=>$reg->precio,
                                                'descripcion'=>"--- ¡ANULACIÓN! ---".now()." ".Auth::user()->name." ANULO EL RECIBO N°: ".$this->reciboActual->numero_recibo." por el motivo: ".$this->motivo.", se sumaron: ".$reg->cantidad." ----- ",
                                                'almacen_id'=>$reg->almacen_id,
                                                'producto_id'=>$reg->producto_id,
                                                'user_id'=>Auth::user()->id
                                            ]);

                //Actualizar registros
                $reg->update([
                    'descripcion'=>"--- ¡ANULADO! ---".now()." ".Auth::user()->name." creo el movimiento de anulación N°: ".$nuevoRegistro->id." por: ".$this->motivo.". ".$reg->descripcion,
                    'status'=>false
                ]);

                Inventario::whereId($ultimoregistro->id)->update([
                    'status'=>false
                ]);
        }else{
            //Actualizar registros
            $reg->update([
                'descripcion'=>"--- ¡ANULADO! ---".now()." ".Auth::user()->name." cambia estado de pendiente . ".$reg->descripcion,
                'status'=>false,
                'entregado'=>true
            ]);
        }
    }

    public function render()
    {
        return view('livewire.financiera.recibo-pago.recibos-pago-anular');
    }
}
