<?php

namespace App\Livewire\Inventario\Producto;

use App\Models\Inventario\Producto;
use Livewire\Component;

class ProductoCreate extends Component
{
    public $name = '';
    public $descripcion = '';

    /**
     * Reglas de validación
     */
    protected $rules = [
        'name' => 'required|max:100',
        'descripcion'=>'required'
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset('name', 'descripcion');
    }

    // Crear Regimen de Salud
    public function new(){
        // validate
        $this->validate();

        //Verificar que no exista el registro en la base de datos
        $existe=Producto::Where('name', '=',strtolower($this->name))->count();

        if($existe>0){
            $this->dispatch('alerta', name:'Ya existe este producto: '.$this->name);
        } else {
            //Crear registro
            Producto::create([
                'name'=>strtolower($this->name),
                'descripcion'=>strtolower($this->descripcion),
            ]);

            // Notificación
            $this->dispatch('alerta', name:'Se ha creado correctamente el producto: '.$this->name);
            $this->resetFields();

            //refresh
            $this->dispatch('refresh');
            $this->dispatch('created');
        }
    }

    public function render()
    {
        return view('livewire.inventario.producto.producto-create');
    }
}
