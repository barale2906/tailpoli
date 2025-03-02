<?php

namespace App\Livewire\Inventario\Inventario;

use App\Models\Configuracion\Sede;
use App\Models\Inventario\Inventario;
use App\Traits\CrtStatusTrait;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class InventariosEditar extends Component
{
    use CrtStatusTrait;

    public $id='';
    public $movimiento;
    public $tipo=0;
    public $fecha_movimiento = '';
    public $cantidad='';
    public $saldo='';
    public $nuevoSaldo='';
    public $precio='';
    public $descripcion='';
    public $almacen_id='';
    public $almaceName='';
    public $sedeName='';
    public $producto_id='';
    public $productoName='';
    public $ultimoregistro;
    public $motivo;


    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
            'id',
            'tipo',
            'fecha_movimiento',
            'cantidad',
            'saldo',
            'nuevoSaldo',
            'precio',
            'descripcion',
            'almacen_id',
            'producto_id',
            'motivo'
        );
    }

    public function mount($elegido = null)
    {
        $this->movimiento=Inventario::find($elegido);
        $this->variables();
    }

    public function variables(){
        $this->id=$this->movimiento->id;
        $this->tipo=$this->movimiento->tipo;
        $this->fecha_movimiento=$this->movimiento->fecha_movimiento;
        $this->cantidad=$this->movimiento->cantidad;
        $this->saldo=$this->movimiento->saldo;
        $this->precio=$this->movimiento->precio;
        $this->almacen_id=$this->movimiento->almacen_id;
        $this->producto_id=$this->movimiento->producto_id;
        $this->descripcion=$this->movimiento->descripcion;
        $this->almaceName=$this->movimiento->name;
        $this->productoName=$this->movimiento->producto->name;
        $this->actual();
    }

    /**
     * Reglas de validación
     */
    protected $rules = [
        'motivo'=> 'required'
    ];

    //Seleccionar registro activo
    public function actual(){
        $this->ultimoregistro= Inventario::where('almacen_id', $this->almacen_id)
                                        ->where('producto_id', $this->producto_id)
                                        ->where('status', true)
                                        ->first();

        $sedeac=Sede::whereId($this->movimiento->almacen->sede->id)->select('name')->first();
        $this->sedeName=$sedeac->name;
    }

    //Actualizar
    public function edit()
    {
        // validate
        $this->validate();

        if($this->tipo===1 && $this->ultimoregistro->saldo<$this->cantidad){
            $this->dispatch('alerta', name:'¡NO VALIDO!, Revise otros movimientos. ');
        } else{
            $this->valorSaldos();
        }

    }

    public function valorSaldos(){
        if($this->tipo===1){
            $this->nuevoSaldo=$this->ultimoregistro->saldo-$this->cantidad;
            $this->tipo=0;
        }else{
            $this->nuevoSaldo=$this->ultimoregistro->saldo+$this->cantidad;
            $this->tipo=1;
        }
        $this->anular();
    }

    public function anular(){

        // Crear registro inverso
        $nuevoRegistro=Inventario::create([
                    'tipo'=>$this->tipo,
                    'fecha_movimiento'=>now(),
                    'cantidad'=>$this->cantidad,
                    'saldo'=>$this->nuevoSaldo,
                    'precio'=>$this->precio,
                    'descripcion'=>"--- ¡ANULACIÓN! ---".now()." ".Auth::user()->name." crea movimiento de anulación del movimiento N°: ".$this->id." por: ".$this->motivo.". ".$this->descripcion,
                    'almacen_id'=>$this->almacen_id,
                    'producto_id'=>$this->producto_id,
                    'user_id'=>Auth::user()->id
                ]);
        //Actualizar registros
        Inventario::whereId($this->id)->update([
            'descripcion'=>"--- ¡ANULADO! ---".now()." ".Auth::user()->name." creo el movimiento de anulación N°: ".$nuevoRegistro->id." por: ".$this->motivo.". ".$this->descripcion,
            'status'=>0
        ]);

        Inventario::whereId($this->ultimoregistro->id)->update([
            'status'=>0
        ]);


        $this->dispatch('alerta', name:'Se ha ANULADO correctamente el movimiento N°: '.$this->id);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');
    }

    public function render()
    {
        return view('livewire.inventario.inventario.inventarios-editar');
    }
}
