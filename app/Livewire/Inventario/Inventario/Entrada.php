<?php

namespace App\Livewire\Inventario\Inventario;

use App\Models\Financiera\ConceptoPago;
use App\Models\Inventario\Almacen;
use App\Models\Inventario\Inventario;
use App\Models\Inventario\Producto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Entrada extends Component
{
    public $almacen;
    public $cantidad;
    public $precio;
    public $conceptopago;

    public $descripcion;

    public $movimientos;
    public $Total=0;
    public $id_ultimo;
    public $saldo;


    public $producto_id;
    public $producto;
    public $fecha_movimiento;

    public $buscapro=null;
    public $buscaproducto=0;
    public $ultimoregistro;

    public function mount($almacen_id=null){
        $id=intval($almacen_id);
        $this->almacen=Almacen::find($id);

        $this->concepto();

    }

    public function concepto(){
        $this->conceptopago=ConceptoPago::where('tipo', 'inventario')
                                            ->first();
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
        $this->ultimoregistro= Inventario::where('almacen_id', $this->almacen->id)
                                        ->where('producto_id', $this->producto->id)
                                        ->where('status', true)
                                        ->first();

        if($this->ultimoregistro){
            $this->saldo=$this->ultimoregistro->saldo;
            $this->id_ultimo=$this->ultimoregistro->id;
        }else{
            $this->saldo=0;
            $this->id_ultimo=0;
        }
    }

    //cargar productos
    public function temporal(){

        $this->saldo=$this->saldo+$this->cantidad;

        $valor=$this->precio*$this->cantidad;
        $this->Total=$this->Total+$valor;

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
        $this->Total=$this->Total-$valori;


        $this->cargando();
    }

    //Actualizar registros
    public function cargando(){
        $this->movimientos=DB::table('apoyo_recibo')
                                ->where('id_creador', Auth::user()->id)
                                ->orderBy('tipo')
                                ->get();
    }

    /**
     * Reglas de validación
     */
    protected $rules = [
        'fecha_movimiento'=> 'required',
        'descripcion'=> 'required'
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
            'fecha_movimiento',
            'cantidad',
            'saldo',
            'precio',
            'descripcion',
            'producto_id'
        );
    }

    public function new(){
        // validate
        $this->validate();


        if($this->movimientos->count()>0){
            foreach ($this->movimientos as $value) {
                Inventario::create([
                    'tipo'=>1,
                    'fecha_movimiento'=>$this->fecha_movimiento,
                    'cantidad'=>$value->cantidad,
                    'saldo'=>$value->saldo,
                    'precio'=>$value->valor,
                    'descripcion'=>$this->descripcion,
                    'almacen_id'=>$value->id_almacen,
                    'producto_id'=>$value->id_producto,
                    'user_id'=>Auth::user()->id
                ]);

                if($value->id_ultimoreg>0){
                    //Actualizar registro anterior
                    Inventario::whereId($value->id_ultimoreg)->update([
                        'status'=>false
                    ]);
                }
            }

            // Notificación
            $this->dispatch('alerta', name:'Se ha cargado correctamente el movimiento de inventario');
            $this->resetFields();

            //refresh
            $this->dispatch('refresh');
            $this->dispatch('borrarMov');
            $this->dispatch('cancelando');

        }else{
            $this->dispatch('alerta', name:'Debe cargar productos');
        }

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
        return view('livewire.inventario.inventario.entrada',[
            'productos'     =>$this->productos()
        ]);
    }
}
