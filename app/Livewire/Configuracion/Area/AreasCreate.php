<?php

namespace App\Livewire\Configuracion\Area;

use App\Models\Configuracion\Area;
use Livewire\Component;

class AreasCreate extends Component
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
    public function new(){
        // validate
        $this->validate();

        //Verificar que no exista el registro en la base de datos
        $existe=Area::Where('name', '=',strtolower($this->name))->count();

        if($existe>0){
            $this->dispatch('alerta', name:'Ya existe esta área: '.$this->name);
        } else {
            //Crear registro
            Area::create([
                'name'=>strtolower($this->name),
            ]);

            // Notificación
            $this->dispatch('alerta', name:'Se ha creado correctamente el área: '.$this->name);
            $this->resetFields();

            //refresh
            $this->dispatch('refresh');
            $this->dispatch('created');
        }
    }

    public function render()
    {
        return view('livewire.configuracion.area.areas-create');
    }
}
