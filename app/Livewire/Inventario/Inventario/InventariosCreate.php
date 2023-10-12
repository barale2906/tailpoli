<?php

namespace App\Livewire\Inventario\Inventario;

use App\Models\Configuracion\Sede;
use App\Models\Financiera\ConceptoPago;
use App\Models\Inventario\Almacen;
use App\Models\Inventario\Inventario;
use App\Models\Inventario\Producto;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class InventariosCreate extends Component
{
    public $sede_id;
    public $sede;
    public $almacen_id;
    public $almacen;
    public $producto_id;
    public $producto;
    public $fecha_movimiento;
    public $medio;
    public $cantidad;
    public $precio;
    public $descripcion;

    public $buscar=null;
    public $buscaestudi='';
    public $alumno_id=0;
    public $alumnoName;



    public $buscapro=null;
    public $buscaproducto=0;
    public $ultimoregistro;
    public $tipo;
    public $movimientos;
    public $Total=0;
    public $id_ultimo;
    public $saldo;
    public $conceptopago;

    public function mount(){
        DB::table('apoyo_recibo')
            ->where('id_creador', Auth::user()->id)
            ->delete();
    }

    public function updatedTipo(){
        $this->reset('sede_id', 'almacen_id', 'producto', 'movimientos');
        $this->concepto();
    }

    public function concepto(){
        $this->conceptopago=ConceptoPago::where('tipo', 'inventario')
                                            ->first();
    }

    public function updatedSedeId(){
        $this->reset('sede', 'movimientos', 'producto', 'almacen_id');
        $this->sede=Sede::find($this->sede_id);
    }

    public function updatedAlmacenId(){
        $this->reset('almacen','movimientos', 'producto');
        $this->almacen=Almacen::find($this->almacen_id);
    }

    //Buscar Alumno
    public function buscAlumno(){
        $this->buscaestudi=strtolower($this->buscar);
    }

    //Limpiar variables
    public function limpiar(){
        $this->reset('buscar');
    }

    public function selAlumno($item){
        $this->alumno_id=$item['id'];
        $this->alumnoName=$item['name'];
        $this->limpiar();
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
        $this->ultimoregistro= Inventario::where('almacen_id', $this->almacen_id)
                                        ->where('producto_id', $this->producto->id)
                                        ->where('status', true)
                                        ->first();

        if($this->tipo==="0" && $this->ultimoregistro==null){
            $this->dispatch('alerta', name:'No se puede generar salida de productos sin existencias.');
            $this->reset('producto','alumno_id','alumnoName');
        }

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

        if($this->tipo==="0"){
            $this->saldo=$this->saldo-$this->cantidad;
        }else{
            $this->saldo=$this->saldo+$this->cantidad;
        }

        if($this->saldo<0){
            $this->dispatch('alerta', name:'No se puede retirar mas del saldo');
            $this->reset('cantidad');
        }else{
            DB::table('apoyo_recibo')->insert([
                'tipo'=>'inventario',
                'id_creador'=>Auth::user()->id,
                'id_concepto'=>$this->conceptopago->id,
                'concepto'=>"Sálida de Inventario",
                'valor'=>$this->precio,
                'cantidad'=>$this->cantidad,
                'id_producto'=>$this->producto->id,
                'producto'=>$this->producto->name,
                'id_almacen'=>$this->almacen->id,
                'almacen'=>$this->almacen->name,
                'id_ultimoreg'=>$this->id_ultimo,
                'saldo'=>$this->saldo
            ]);

            $valor=$this->precio*$this->cantidad;
            $this->Total=$this->Total+$valor;

            $this->reset('cantidad','precio','producto','producto_id');

            $this->cargando();
        }
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

    //consultar estado
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
        'tipo'=> 'required',
        'fecha_movimiento'=> 'required',
        'descripcion'=> 'required',
        'almacen_id'=> 'required'
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

    public function new(){
        // validate
        $this->validate();

        foreach ($this->movimientos as $value) {
            Inventario::create([
                'tipo'=>$this->tipo,
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

    //Productos
    private function productos(){
        return Producto::where('status', true)
                        ->where('name', 'like', "%".$this->buscaproducto."%")
                        ->orderBy('name')
                        ->get();
    }

    private function estudiantes(){
        return User::where('status', true)
                        ->where('name', 'like', "%".$this->buscaestudi."%")
                        ->orWhere('documento', 'like', "%".$this->buscaestudi."%")
                        ->orderBy('name')
                        ->with('roles')->get()->filter(
                            fn ($user) => $user->roles->where('name', 'Estudiante')->toArray()
                        );
    }

    public function render()
    {
        return view('livewire.inventario.inventario.inventarios-create',[
            'sedes'         =>$this->sedes(),
            'productos'     =>$this->productos(),
            'estudiantes'   =>$this->estudiantes()
        ]);
    }
}
