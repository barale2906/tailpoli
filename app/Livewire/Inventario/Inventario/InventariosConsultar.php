<?php

namespace App\Livewire\Inventario\Inventario;

use App\Models\Configuracion\Sede;
use App\Models\Inventario\Inventario;
use Livewire\Component;

class InventariosConsultar extends Component
{
    public $id='';
    public $tipo='';
    public $fecha_movimiento = '';
    public $cantidad='';
    public $saldo='';
    public $nuevoSaldo='';
    public $precio='';
    public $descripcion='';
    public $almacen_id='';
    public $almaceName='';
    public $producto_id='';
    public $productoName='';
    public $user='';

    public $saldostate=true;
    public $almacenstate=false;

    public function mount($elegido = null)
    {
        $this->id=$elegido['id'];
        $this->tipo=$elegido['tipo'];
        $this->fecha_movimiento=$elegido['fecha_movimiento'];
        $this->cantidad=$elegido['cantidad'];
        $this->saldo=$elegido['saldo'];
        $this->precio=$elegido['precio'];
        $this->almacen_id=$elegido['almacen_id'];
        $this->producto_id=$elegido['producto_id'];
        $this->descripcion=$elegido['descripcion'];
        $this->almaceName=$elegido['almacen']['name'];
        $this->productoName=$elegido['producto']['name'];
        $this->user=$elegido['user']['name'];
        //dd($elegido);
    }

    private function saldos(){
        return Inventario::where('status', true)
                        ->where('producto_id', $this->producto_id)
                        ->get();
    }



    public function render()
    {
        return view('livewire.inventario.inventario.inventarios-consultar', [
            'saldos'=>$this->saldos(),
        ]);
    }
}
