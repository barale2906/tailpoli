<?php

namespace App\Livewire\Inventario\Traslado;

use App\Models\Configuracion\Sede;
use App\Models\Inventario\Almacen;
use App\Models\Inventario\Producto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Envia extends Component
{
    public $almacen;
    public $sede;
    public $ruta;
    public $desede;
    public $almacenes;
    public $dealma;


    public $buscapro=null;
    public $buscaproducto=0;

    public $producto_id;
    public $producto;
    public $saldo;
    public $movimientos;

    public function mount($almacen_id, $sede_id, $ruta=null){
        $id=intval($almacen_id);
        $idsede=intval($sede_id);
        $this->almacen=Almacen::find($id);
        $this->sede=Sede::find($idsede);
        if($ruta){
            $this->ruta=$ruta;
        }
    }

    public function updatedDesede(){
        $this->almacenes=Almacen::where('status', true)
                                    ->where('sede_id', $this->desede)
                                    ->orderBY('name', 'ASC')
                                    ->get();
    }

    //Buscar producto
    public function buscaProducto(){
        $this->buscaproducto=strtolower($this->buscapro);
    }

    //Limpiar variables
    public function limpiarpro(){
        $this->reset('producto_id', 'buscapro');
    }

    // Cargar producto
    public function selProduc($item){
        $this->producto=Producto::find($item);
        $this->limpiarpro();
    }

    //cargar productos
    public function temporal(){

        $this->saldo=$this->saldo+$this->cantidad;

        $valor=$this->precio*$this->cantidad;


        DB::table('apoyo_recibo')->insert([
            'tipo'=>'inventario',
            'id_creador'=>Auth::user()->id,
            'id_concepto'=>$this->conceptopago->id,
            'concepto'=>"Entrada de Inventario",
            'valor'=>$this->precio,
            'cantidad'=>$this->cantidad,
            'id_producto'=>$this->producto->id,
            'producto'=>$this->producto->name,
            'id_almacen'=>$this->almacen->id,
            'almacen'=>$this->almacen->name,
            'id_ultimoreg'=>$this->id_ultimo,
            'saldo'=>$this->saldo
        ]);

        $this->reset('cantidad','precio','producto','producto_id');

        $this->cargando();
    }

    //Eliminar producto
    public function elimOtro($item){

        $prod=DB::table('apoyo_recibo')->whereId($item)->first();

        DB::table('apoyo_recibo')
            ->where('id', $item)
            ->delete();

        $valori=$prod->valor*$prod->cantidad;


        $this->cargando();
    }

    //Actualizar registros
    public function cargando(){
        $this->movimientos=DB::table('apoyo_recibo')
                                ->where('id_creador', Auth::user()->id)
                                ->orderBy('tipo')
                                ->get();
    }


    private function sedes(){
        return Sede::where('status', true)
                    ->orderBy('name', 'ASC')
                    ->get();
    }

    public function render()
    {
        return view('livewire.inventario.traslado.envia', [
            'sedes'=>$this->sedes(),
        ]);
    }
}
