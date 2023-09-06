<?php

namespace App\Livewire\Admin\Salud;

use App\Models\Admin\RegimenSalud;
use Livewire\Component;

class RegimenCreate extends Component
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
    public function newRegimen(){
        // validate
        $this->validate();

        //Verificar que no exista el registro en la base de datos
        $existe=RegimenSalud::Where('name', '=',strtolower($this->name))->count();

        if($existe>0){
            $this->dispatch('alerta', name:'Ya existe este nombre de Regimen: '.$this->name);
        } else {
            //Crear registro
            RegimenSalud::create([
                'name'=>strtolower($this->name),
            ]);

            // Notificación
            $this->dispatch('alerta', name:'Se ha creado correctamente el regímen de salud: '.$this->name);
            $this->resetFields();

            //refresh
            $this->dispatch('refresh');
            $this->dispatch('created-regimen');
        }
    }


    public function render()
    {
        return view('livewire.admin.salud.regimen-create');
    }
}
