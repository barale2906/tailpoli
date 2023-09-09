<?php

namespace App\Livewire\Configuracion\Area;

use App\Models\Configuracion\Area;
use Livewire\Component;

class AreasEditar extends Component
{
    public $name = '';
    public $id = '';
    public $elegido;

    /**
     * Reglas de validación
     */
    protected $rules = [
        'name'  => 'required|max:100',
        'id'    => 'required'
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset('name', 'id');
    }

    public function mount($elegido = null)
    {
        $this->name=$elegido['name'];
        $this->id=$elegido['id'];
    }

    //Actualizar Regimen de Salud
    public function edit()
    {
        // validate
        $this->validate();

        //Actualizar registros
        Area::whereId($this->id)->update([
            'name'=>strtolower($this->name)
        ]);

        $this->dispatch('alerta', name:'Se ha modificado correctamente el área: '.$this->name);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('Editando');
    }

    public function render()
    {
        return view('livewire.configuracion.area.areas-editar');
    }
}
