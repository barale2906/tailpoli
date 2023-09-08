<?php

namespace App\Livewire\Inventario\Producto;

use App\Models\Inventario\Producto;
use Livewire\Component;

class ProductoEditar extends Component
{
    public $name = '';
    public $descripcion = '';
    public $id = '';
    public $elegido;

    /**
     * Reglas de validación
     */
    protected $rules = [
        'name'  => 'required|max:100',
        'descripcion'=>'required',
        'id'    => 'required'
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset('name', 'id', 'descripcion');
    }

    public function mount($elegido = null)
    {
        $this->name=$elegido['name'];
        $this->descripcion=$elegido['descripcion'];
        $this->id=$elegido['id'];
    }

    //Actualizar Regimen de Salud
    public function edit()
    {
        // validate
        $this->validate();

        //Actualizar registros
        Producto::whereId($this->id)->update([
            'name'=>$this->name,
            'descripcion'=>$this->descripcion
        ]);

        $this->dispatch('alerta', name:'Se ha modificado correctamente el producto: '.$this->name);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('Editando');
    }

    public function render()
    {
        return view('livewire.inventario.producto.producto-editar');
    }
}
