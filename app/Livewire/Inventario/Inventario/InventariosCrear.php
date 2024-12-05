<?php

namespace App\Livewire\Inventario\Inventario;

use App\Models\Inventario\Almacen;
use App\Models\Inventario\Inventario;
use App\Models\Inventario\Producto;
use App\Traits\CrtStatusTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class InventariosCrear extends Component
{
    use CrtStatusTrait;

    public $tipo='';
    public $tipon;
    public $fecha_movimiento = '';
    public $cantidad='';
    public $cantiAlge='';
    public $saldo='';
    public $precio='';
    public $descripcion='';
    public $almacen_id='';
    public $almaceName='';
    public $sedeName='';
    public $producto_id='';
    public $productoName='';
    public $ultimoregistro;

    public $buscar=null;
    public $buscasede=0;
    public $buscapro=null;
    public $buscaproducto=0;

    public function mount($tipon = null)    {

        $this->tipo=intval($tipon);

    }

    //Buscar almacén
    public function buscAlmacen(){
        $this->buscasede=strtolower($this->buscar);
    }

    //Buscar producto
    public function buscaProducto(){
        $this->buscaproducto=strtolower($this->buscapro);
    }

    /**
     * Reglas de validación
     */
    protected $rules = [
        'tipo'=> 'required',
        'fecha_movimiento'=> 'required',
        'cantidad'=> 'required',
        'precio'=> 'required',
        'descripcion'=> 'required',
        'almacen_id'=> 'required',
        'producto_id'=>'required'
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
            'tipo',
            'fecha_movimiento',
            'cantidad',
            'saldo',
            'precio',
            'descripcion',
            'almacen_id',
            'producto_id'
        );
    }

    // Cargar almacen
    public function selAlmacen($item)
    {
        $this->almacen_id=$item['id'];
        $this->almaceName=$item['name'];
        $this->sedeName=$item['sede']['name'];
    }
    //Limpiar variables
    public function limpiar(){
        $this->reset('almacen_id', 'buscar');
    }

    //Limpiar variables
    public function limpiarpro(){
        $this->reset('producto_id', 'buscapro');
    }

    // Cargar producto
    public function selProduc($item){
        $this->producto_id=$item['id'];
        $this->productoName=$item['name'];
        $this->actual();
    }

    //Seleccionar registro activo
    public function actual(){
        $this->ultimoregistro= Inventario::where('almacen_id', $this->almacen_id)
                                        ->where('producto_id', $this->producto_id)
                                        ->where('status', true)
                                        ->first();
    }

    //Cargar producto al temporal
    public function temporal(){
        if($this->tipo===1 && $this->ultimoregistro===null){
            DB::table('apoyo_recibo')->insert([
                'tipo'=>'inventario',
                'id_creador'=>Auth::user()->id,
                'id_concepto'=>5,
                'concepto'=>"Sálida de Inventario",
                'valor'=>$this->precio,
                'cantidad'=>$this->cantidad,
                'id_producto'=>$this->producto_id,
                'producto'=>$this->productoName,
                'id_almacen'=>$this->almacen_id,
                'almacen'=>$this->almaceName,
                'id_ultimoreg'=>0,
                'saldo'=>0
            ]);
        }
        if($this->precio>0 && $this->cantidad>0 && $this->ultimoregistro!==null && $this->cantidad<$this->ultimoregistro->saldo &&$this->tipo===0){
            DB::table('apoyo_recibo')->insert([
                'tipo'=>'inventario',
                'id_creador'=>Auth::user()->id,
                'id_concepto'=>5,
                'concepto'=>"Sálida de Inventario",
                'valor'=>$this->precio,
                'cantidad'=>$this->cantidad,
                'id_producto'=>$this->producto_id,
                'producto'=>$this->productoName,
                'id_almacen'=>$this->almacen_id,
                'almacen'=>$this->almaceName,
                'id_ultimoreg'=>$this->ultimoregistro->id,
                'saldo'=>$this->ultimoregistro->saldo
            ]);
        } else {
            $this->dispatch('alerta', name:'Debe tener costo, cantidad y ser menor que el saldo');
        }

        $this->reset(
            'cantidad',
            'precio',
            'producto_id'
        );

        $this->dispatch('cargados');
    }

    // Crear
    public function new(){

        //dd($this->tipon, $this->almacen_id, $this->producto_id);

        // validate
        $this->validate();

        if($this->ultimoregistro==null && $this->tipo===0){
            $this->dispatch('alerta', name:'¡NO SE PUEDE SACAR UN PRODUCTO INEXISTENTE!');
        }else{

            if($this->tipo===0 && $this->ultimoregistro){
                $this->cantiAlge=$this->cantidad*(-1);
            }else{
                $this->cantiAlge=$this->cantidad;
            }

            if($this->ultimoregistro){
                $this->saldo=$this->ultimoregistro->saldo+$this->cantiAlge;
            }else{
                $this->saldo=$this->cantiAlge;
            }

            if($this->saldo<0){
                $this->dispatch('alerta', name:'¡No alcanza el inventario!');
            } else {
                //Crear registro
                Inventario::create([
                    'tipo'=>$this->tipon,
                    'fecha_movimiento'=>$this->fecha_movimiento,
                    'cantidad'=>$this->cantidad,
                    'saldo'=>$this->saldo,
                    'precio'=>$this->precio,
                    'descripcion'=>$this->descripcion,
                    'almacen_id'=>$this->almacen_id,
                    'producto_id'=>$this->producto_id,
                    'user_id'=>Auth::user()->id
                ]);


                if($this->ultimoregistro){
                    //Actualizar registro anterior
                    Inventario::whereId($this->ultimoregistro->id)->update([
                        'status'=>false
                    ]);
                }

                // Notificación
                $this->dispatch('alerta', name:'Se ha cargado correctamente el movimiento de inventario');
                $this->resetFields();

                //refresh
                $this->dispatch('refresh');
                $this->dispatch('cancelando');
            }
        }

    }

    //Almacenes
    private function almacens()
    {
        return Almacen::query()
                        ->with(['sede'])
                        ->when($this->buscasede, function($query){
                            return $query->where('status', true)
                                    ->where('name', 'like', "%".$this->buscasede."%")
                                    ->orWhereHas('sede', function($q){
                                        $q->where('name', 'like', "%".$this->buscasede."%");
                                    });
                        })
                        ->orderBy('name')
                        ->get();
    }

    //Productos
    private function productos()
    {
        return Producto::where('status', true)
                        ->where('name', 'like', "%".$this->buscaproducto."%")
                        ->orderBy('name')
                        ->get();
    }

    public function render()
    {
        return view('livewire.inventario.inventario.inventarios-crear', [
            'almacens' => $this->almacens(),
            'productos'=> $this->productos()
        ]);
    }
}
