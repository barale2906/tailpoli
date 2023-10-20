<?php

namespace App\Livewire\Inventario\Inventario;

use App\Models\Configuracion\Sector;
use App\Models\Inventario\PagoConfig;
use App\Models\Inventario\Producto;
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

    public $precio=[];

    public $elegidos=[];

    public function mount($elegido = null){
        $this->id=$elegido['id'];
        $this->actual=PagoConfig::whereId($elegido['id'])->first();
        $this->elegidos=DB::table('pago_configs_producto')
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
