<?php

namespace App\Livewire\Inventario\Inventario;

use App\Models\Configuracion\Sector;
use App\Models\Inventario\PagoConfig;
use App\Models\Inventario\Producto;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PagoConfigCreate extends Component
{
    public $inicia;
    public $finaliza;
    public $descripcion;
    public $sector_id;
    public $precio;

    public $elegidos=[];


    //Cargar producto
    public function carProduc($item){

        $crt=0;
        foreach($this->elegidos as $value){
            if($value['id']===$item['id']){
                $crt=1;
                $this->dispatch('alerta', name:'el producto '.$item['name'].' ya esta cargado.');
                $this->reset('precio');
            }
        }

        if($crt===0){
            $nuevo=[
                'id'=>$item['id'],
                'name'=>$item['name'],
                'precio'=>$this->precio
            ];

            if(in_array($nuevo, $this->elegidos)){

            }else{
                array_push($this->elegidos, $nuevo);
            }

            $this->reset('precio');
        }
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
        'inicia'=>'required',
        'finaliza'=>'required',
        'descripcion'=> 'required',
        'sector_id'=> 'required'
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(

            'inicia',
            'finaliza',
            'descripcion',
            'sector_id'
        );
    }

    public function new(){

        // validate
        $this->validate();

        if($this->inicia>$this->finaliza){
            $this->dispatch('alerta', name:'La fecha de inicio debe ser menor a la fecha de finalización');
        }else if(count($this->elegidos)>0){

            $status=true;
            if(now()<$this->inicia){
                $status=!$status;
            }

            $config=PagoConfig::create([
                'inicia'        =>$this->inicia,
                'finaliza'      =>$this->finaliza,
                'descripcion'   =>$this->descripcion,
                'sector_id'     =>$this->sector_id,
                'status'        =>$status
            ]);

            // Cargar productos
            foreach ($this->elegidos as $value) {
                DB::table('pago_configs_producto')
                    ->insert([
                        'pago_configs_id'   =>$config->id,
                        'producto_id'       =>$value['id'],
                        'name'              =>$value['name'],
                        'valor'             =>$value['precio'],
                        'created_at'        =>now(),
                        'updated_at'        =>now(),
                    ]);
            }

            // Notificación
            $this->dispatch('alerta', name:'Se ha creado correctamente la configuración de pago');
            $this->resetFields();

            //refresh
            $this->dispatch('refresh');
            $this->dispatch('created');

        }else{
            $this->dispatch('alerta', name:'Debe elegir productos para poder generar la configuración');
        }
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
                        ->orderBy('name')
                        ->get();
    }

    public function render()
    {
        return view('livewire.inventario.inventario.pago-config-create', [
            'ciudades'=>$this->ciudades(),
            'productos'=> $this->productos()
        ]);
    }
}
