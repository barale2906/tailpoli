<?php

namespace App\Livewire\Admin\Multi;

use App\Models\Admin\PersonaMulticultural;
use Livewire\Component;

class PersonamultiEditar extends Component
{
    public $name = '';
    public $id = '';
    public $multiElegido;

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

    public function mount($multiElegido = null)
    {
        $this->name=$multiElegido['name'];
        $this->id=$multiElegido['id'];
    }

    //Actualizar Regimen de Salud
    public function editRegimen()
    {
        // validate
        $this->validate();

        //Actualizar registros
        PersonaMulticultural::whereId($this->id)->update([
            'name'=>$this->name
        ]);

        $this->dispatch('alerta', name:'Se ha modificado correctamente el tipo de persona multicultural: '.$this->name);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('Editando-multi');
    }

    public function render()
    {
        return view('livewire.admin.multi.personamulti-editar');
    }
}
