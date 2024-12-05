<?php

namespace App\Livewire\Inventario\Traslado;

use App\Models\Configuracion\Sede;
use App\Models\Inventario\Almacen;
use App\Models\Inventario\Inventario;
use App\Models\Inventario\Producto;
use App\Traits\CrtStatusTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Envia extends Component
{
    use CrtStatusTrait;

    public $almacen;
    public $almacen_id;
    public $sede;
    public $ruta;
    public $desede;
    public $almacenes;
    public $dealma;
    public $accion=0;


    public $buscapro=null;
    public $buscaproducto=0;

    public $producto_id;
    public $producto;
    public $saldo;
    public $id_ultimo;
    public $movimientos;
    public $ultimoregistro;
    public $precio;
    public $cantidad;

    public $observaciones;

    public $trasl;

    public $crtsaldo=0;




    public function mount($almacen_id, $sede_id, $ruta=null){

        $id=intval($almacen_id);
        $idsede=intval($sede_id);
        $this->almacen=Almacen::find($id);
        $this->almacen_id=$id;
        $this->sede=Sede::find($idsede);
        if($ruta){
            $this->ruta=$ruta;
        }
    }

    public function objetivo($id){
        $this->accion=$id;
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
        $this->actual();
    }

    //Seleccionar registro activo
    public function actual(){

        $this->reset('saldo');

        $this->ultimoregistro= Inventario::where('almacen_id', $this->almacen->id)
                                        ->where('producto_id', $this->producto->id)
                                        ->where('status', true)
                                        ->first();

        if($this->ultimoregistro){
            $this->saldo=$this->ultimoregistro->saldo;
            $this->id_ultimo=$this->ultimoregistro->id;
            $this->precio=$this->ultimoregistro->precio;
        }
    }

    //cargar productos
    public function temporal(){

        if($this->cantidad<=$this->saldo){
            $this->saldo=$this->saldo-$this->cantidad;

            DB::table('apoyo_recibo')->insert([
                'tipo'=>'inventario',
                'id_creador'=>Auth::user()->id,
                'valor'=>$this->precio,
                'cantidad'=>$this->cantidad,
                'id_producto'=>$this->producto->id,
                'producto'=>$this->producto->name,
                'id_ultimoreg'=>$this->id_ultimo,
                'saldo'=>$this->saldo
            ]);

            $this->reset('cantidad','precio','producto','producto_id');

            $this->cargando();
        }else{
            $this->dispatch('alerta', name:'No puede enviar mas de lo existente');
        }


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

    public function traslado(){
        //obtener numero de traslado
        $max=Inventario::max('traslado');
        if($max){
            $this->trasl=$max+1;
        }else{
            $this->trasl=1;
        }

        $desc=now()." ".Auth::user()->name." Genero traslado por: ".$this->observaciones;


        if($this->movimientos->count()>0){

            foreach ($this->movimientos as $value) {

                // Verificar el saldo antes de cargar en la sálida
                $evaluapoyo=Inventario::where('almacen_id', $this->almacen->id)
                                        ->where('producto_id', $value->id_producto)
                                        ->where('status', true)
                                        ->select('id','saldo')
                                        ->first();

                if($evaluapoyo){

                    //Registrar salidas
                    $saldoFin=$evaluapoyo->saldo-$value->cantidad;
                    if($saldoFin>=0){
                        $salida =Inventario::create([
                                    'tipo'=>3,
                                    'traslado'=>$this->trasl,
                                    'envia'=>$this->almacen->id,
                                    'fecha_movimiento'=>now(),
                                    'cantidad'=>$value->cantidad,
                                    'saldo'=>$saldoFin,
                                    'precio'=>$value->valor,
                                    'descripcion'=>$desc,
                                    'almacen_id'=>$this->almacen->id,
                                    'producto_id'=>$value->id_producto,
                                    'user_id'=>Auth::user()->id,
                                    'compra_id'=>$value->id_ultimoreg,
                                    'entregado'=>false
                                ]);

                        Inventario::whereId($value->id_ultimoreg)
                                    ->update([
                                        'status'=>false
                                    ]);

                        //Registrar entradas
                        $hay=Inventario::where('almacen_id', $this->dealma)
                                        ->where('producto_id', $value->id_producto)
                                        ->where('status', true)
                                        ->select('id','saldo')
                                        ->first();

                        if($hay){
                            $saldoent=$hay->saldo+$value->cantidad;
                        }else{
                            $saldoent=$value->cantidad;
                        }

                        Inventario::create([
                                    'tipo'=>3,
                                    'traslado'=>$this->trasl,
                                    'recibe'=>$this->dealma,
                                    'fecha_movimiento'=>now(),
                                    'cantidad'=>$value->cantidad,
                                    'saldo'=>$saldoent,
                                    'precio'=>$value->valor,
                                    'status'=>false,
                                    'descripcion'=>$desc,
                                    'almacen_id'=>$this->dealma,
                                    'producto_id'=>$value->id_producto,
                                    'user_id'=>Auth::user()->id,
                                    'compra_id'=>$salida->id,
                                    'entregado'=>false
                                ]);


                    }else{
                        $this->crtsaldo=$this->crtsaldo+1;
                    }

                }

            }

            if($this->crtsaldo>0){
                $this->dispatch('alerta', name:'Revise las cantidades, no de todos habia saldo.');
            }

            $this->dispatch('alerta', name:'Se genero el traslado con el número: '.$this->trasl);

            $ruta='/impresiones/impTraslado?rut='.$this->ruta.'&tras='.$this->trasl;

            $this->redirect($ruta);

        }else{
            $this->dispatch('alerta', name:'Debe cargar productos');
        }
    }


    private function sedes(){
        return Sede::where('status', true)
                    ->orderBy('name', 'ASC')
                    ->get();
    }

    //Productos
    private function productos(){
        return Producto::where('status', true)
                        ->where('name', 'like', "%".$this->buscaproducto."%")
                        ->orderBy('name')
                        ->get();
    }

    public function render()
    {
        return view('livewire.inventario.traslado.envia', [
            'sedes'=>$this->sedes(),
            'productos'=>$this->productos(),
        ]);
    }
}
