<?php

namespace App\Livewire\Configuracion\Estado;

use App\Models\Configuracion\Estado;
use Livewire\Component;

class EstadoEditar extends Component
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
        Estado::whereId($this->id)->update([
            'name'=>$this->name
        ]);

        $this->dispatch('alerta', name:'Se ha modificado correctamente el estado: '.$this->name);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('Editando');
    }

    public function render()
    {
        return view('livewire.configuracion.estado.estado-editar');
    }
}
