<?php

namespace App\Livewire\Admin\Multi;

use App\Models\Admin\PersonaMulticultural;
use Livewire\Component;

class PersonamultiCreate extends Component
{
    public $name = '';

    /**
     * Reglas de validación
     */
    protected $rules = [
        'name' => 'required|max:100'
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset('name');
    }

    // Crear Regimen de Salud
    public function newMulti(){
        // validate
        $this->validate();

        //Verificar que no exista el registro en la base de datos
        $existe=PersonaMulticultural::Where('name', '=',strtolower($this->name))->count();

        if($existe>0){
            $this->dispatch('alerta', name:'Ya existe este tipo de persona multicultural: '.$this->name);
        } else {
            //Crear registro
            PersonaMulticultural::create([
                'name'=>strtolower($this->name),
            ]);

            // Notificación
            $this->dispatch('alerta', name:'Se ha creado correctamente el tipo de persona multicultural: '.$this->name);
            $this->resetFields();

            //refresh
            $this->dispatch('refresh');
            $this->dispatch('created-multi');
        }
    }

    public function render()
    {
        return view('livewire.admin.multi.personamulti-create');
    }
}
