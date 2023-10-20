<?php

namespace App\Livewire\Inventario\Inventario;

use App\Models\Configuracion\Sector;
use App\Models\Inventario\Producto;
use Livewire\Component;

class PagoConfigCrear extends Component
{
    public $inicia;
    public $finaliza;
    public $descripcion;
    public $sector_id;

    public $buscapro=null;
    public $buscaproducto=0;
    public $producto_id=0;
    public $productoName='';
    public $precio;

    public $elegidos=[];

    //Buscar producto
    public function buscaProducto(){
        $this->buscaproducto=strtolower($this->buscapro);
    }

    //Limpiar variables
    public function limpiarpro(){
        $this->reset('buscapro', 'producto_id', 'buscaproducto', 'crt');
    }

    // Seleccionar producto
    public function selProduc($item){

        $crt=0;
        foreach($this->elegidos as $value){
            if($value['id']===$item['id']){
                $crt=1;
                $this->dispatch('alerta', name:'el producto '.$this->productoName.' ya esta cargado.');
                $this->limpiarpro();
            }
        }
        if($crt===0){
            $this->producto_id=$item['id'];
            $this->productoName=$item['name'];
        }
    }

    //Cargar producto
    public function carProduc(){

            $nuevo=[
                'id'=>$this->producto_id,
                'name'=>$this->productoName,
                'precio'=>$this->precio
            ];

            if(in_array($nuevo, $this->elegidos)){

            }else{
                array_push($this->elegidos, $nuevo);
            }

            $this->reset('producto_id', 'productoName', 'precio');
            $this->limpiarpro();
    }

    //Eliminar producto
    public function elimProduc($id){

        foreach($this->elegidos as $value){
            if($value['id']===$id){
                $nuevo=[
                    'id'=>$id,
                    'name'=>$value['name'],
                    'precio'=>$value['precio'],
                ];

                $indice=array_search($nuevo,$this->elegidos,true);
                unset($this->elegidos[$indice]);
            }
        }
    }


    /**
     * Reglas de validación
     */
    protected $rules = [
        'precio'=> 'required',
        'inicia'=>'required',
        'finaliza'=>'required',
        'descripcion'=> 'required',
        'sector_id'=> 'required',
        'producto_id'=>'required'
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(

            'precio',
            'inicia',
            'finaliza',
            'descripcion',
            'sector_id',
            'producto_id'
        );
    }

    public function new(){

        // validate
        $this->validate();

    }

    private function ciudades(){
        return Sector::where('status', true)
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
        return view('livewire.inventario.inventario.pago-config-crear', [
            'ciudades'=>$this->ciudades(),
            'productos'=> $this->productos()
        ]);
    }
}
