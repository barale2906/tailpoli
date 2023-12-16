<?php

namespace App\Livewire\Inventario\Traslado;

use App\Models\Inventario\Almacen;
use App\Models\Inventario\Inventario;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Recep extends Component
{
    public $almacen;
    public $traslados;
    public $tras;
    public $documentos=[];
    public $id_mov;
    public $saldo;

    public function mount($almacen_id){
        $this->almacen=Almacen::find($almacen_id);
        $this->traslados=Inventario::where('recibe', $almacen_id)
                                    ->where('entregado', false)
                                    ->where('tipo', 3)
                                    ->orderBy('traslado', 'ASC')
                                    ->get();
        $this->enca();
    }

    public function enca(){

        $this->reset('documentos');

        foreach ($this->traslados as $value) {
            $crt=Inventario::where('id',$value->compra_id)->first();

            $nuevo=[
                'traslado'          =>$value->traslado,
                'fecha_movimiento'  =>$value->fecha_movimiento,
                'remitente'         =>$crt->almacen->sede->name,
                'almacen'           =>$crt->almacen->name
            ];



            if(in_array($nuevo, $this->documentos )){

            }else{
                array_push($this->documentos, $nuevo);
            }
        }
    }

    //cargar productos
    public function temporal($id){
        $this->id_mov=$id;
    }

    public function aprobar($otros){


        $ultimo=Inventario::where('status', true)
                            ->where('almacen_id', $this->almacen->id)
                            ->where('producto_id', $otros['producto_id'])
                            ->first();

        $enviado=Inventario::find($otros['compra_id']);

        $obser=now()." ".Auth::user()->name." RECIBIO EL PRODUCTO. ----- ";

        if($ultimo){
            $this->saldo=$ultimo->saldo+$otros['cantidad'];
        }else{
            $this->saldo=$otros['cantidad'];
        }

        Inventario::where('id', $this->id_mov)
                    ->update([
                        'fecha_movimiento'  =>now(),
                        'descripcion'       =>$obser.$otros['descripcion'],
                        'saldo'             =>$this->saldo,
                        'status'            =>true,
                        'entregado'         =>true,
                        'user_id'           =>Auth::user()->id,
                    ]);

        $enviado->update([
                            'descripcion'       =>$obser.$enviado->descripcion,
                            'entregado'         =>true,
                        ]);

        $this->dispatch('alerta', name:'Recibido.');
        $this->reset('id_mov');
        $this->mount($this->almacen->id);
    }

    public function render()
    {
        return view('livewire.inventario.traslado.recep');
    }
}
