<?php

namespace App\Livewire\Inventario\Inventario;

use App\Models\Configuracion\Sector;
use App\Models\Inventario\PagoConfig;
use App\Models\Inventario\Producto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PagoConfigEditar extends Component
{
    public $id;
    public $inicia;
    public $finaliza;
    public $descripcion;
    public $sector_id;
    public $actual;

    public $cargados=[];

    public $precio=[];

    public $elegidos=[];

    public function mount($elegido = null){
        $this->id=$elegido['id'];
        $this->actual=PagoConfig::whereId($elegido['id'])->first();
        $this->cargados=DB::table('pago_configs_producto')
                            ->where('pago_configs_id', $elegido['id'])
                            ->orderBy('name', 'ASC')
                            ->get();

        $this->asignar();

    }

    public function asignar(){
        $this->inicia=$this->actual->inicia;
        $this->finaliza=$this->actual->finaliza;
        $this->descripcion=$this->actual->descripcion;
        $this->sector_id=$this->actual->sector_id;

        $this->actuales();
    }

    public function actuales(){
        foreach ($this->cargados as $item) {
            $nuevo=[
                'id'=>$item->producto_id,
                'name'=>$item->name,
                'precio'=>$item->valor
            ];

            if(in_array($nuevo, $this->elegidos)){

            }else{
                array_push($this->elegidos, $nuevo);
            }
        }
    }

    //Cargar producto
    public function carProduc($item){

        $crt=0;
        foreach($this->elegidos as $value){
            if($value['id']===$item['id']){
                $crt=1;
                $this->dispatch('alerta', name:'Para modificar el producto eliminalo y lo vuelves a cargar.');
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

    //Actualizar
    public function edit(){

        // validate
        $this->validate();

        if($this->inicia>$this->finaliza){
            $this->dispatch('alerta', name:'La fecha de inicio debe ser menor a la fecha de finalización');
        }else if(count($this->elegidos)>0){

            $descri="--- ¡MODIFICADA! --- ".now()." ".Auth::user()->name." modifico la configuración de pago. --- ".$this->actual->descripcion;

            PagoConfig::whereId($this->id)
                        ->update([
                            'inicia'        =>$this->inicia,
                            'finaliza'      =>$this->finaliza,
                            'descripcion'   =>$descri,
                            'sector_id'     =>$this->sector_id
                        ]);

            // Eliminar registros anteriores
            DB::table('pago_configs_producto')->where('pago_configs_id', $this->id)
                ->delete();

            // Cargar productos
            foreach ($this->elegidos as $value) {
                DB::table('pago_configs_producto')
                    ->insert([
                        'pago_configs_id'   =>$this->id,
                        'producto_id'       =>$value['id'],
                        'name'              =>$value['name'],
                        'valor'             =>$value['precio'],
                        'created_at'        =>now(),
                        'updated_at'        =>now(),
                    ]);
            }

        }else{
            $this->dispatch('alerta', name:'Debe elegir productos para poder generar la configuración');
        }


        $this->dispatch('alerta', name:'Se ha editado correctamente la Configuración de Pago: '.$this->id);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('Editando');

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
        return view('livewire.inventario.inventario.pago-config-editar', [
            'ciudades'=>$this->ciudades(),
            'productos'=> $this->productos()
        ]);
    }
}
