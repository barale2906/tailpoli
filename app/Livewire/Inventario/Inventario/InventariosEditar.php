<?php

namespace App\Livewire\Inventario\Inventario;

use App\Models\Configuracion\Sede;
use App\Models\Inventario\Inventario;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class InventariosEditar extends Component
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
        //$this->sedeName=$elegido['sede']['name'];
        $this->productoName=$elegido['producto']['name'];
        $this->actual($elegido['almacen']['sede_id']);
    }

    /**
     * Reglas de validación
     */
    protected $rules = [
        'motivo'=> 'required'
    ];

    //Seleccionar registro activo
    public function actual($sede){
        $this->ultimoregistro= Inventario::where('almacen_id', $this->almacen_id)
                                        ->where('producto_id', $this->producto_id)
                                        ->where('status', true)
                                        ->first();

        $sedeac=Sede::whereId($sede)->select('name')->first();
        $this->sedeName=$sedeac->name;
    }

    //Actualizar Regimen de Salud
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
            'status'=>false
        ]);

        Inventario::whereId($this->ultimoregistro->id)->update([
            'status'=>false
        ]);


        $this->dispatch('alerta', name:'Se ha ANULADO correctamente el movimiento N°: '.$this->id);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('Editando');
    }

    public function render()
    {
        return view('livewire.inventario.inventario.inventarios-editar');
    }
}
