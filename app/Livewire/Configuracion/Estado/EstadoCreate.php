<?php

namespace App\Livewire\Configuracion\Estado;

use App\Models\Configuracion\Estado;
use Livewire\Component;

class EstadoCreate extends Component
{
    public $name = '';
    public $tipo='';

    /**
     * Reglas de validación
     */
    protected $rules = [
        'name'  => 'required|max:100',
        'tipo'  => 'required'
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset('name', 'tipo');
    }

    // Crear Regimen de Salud
    public function new(){
        // validate
        $this->validate();

        //Verificar que no exista el registro en la base de datos
        $existe=Estado::Where('name', '=',strtolower($this->name))->count();

        if($existe>0){
            $this->dispatch('alerta', name:'Ya existe este estado: '.$this->name);
        } else {
            //Crear registro
            Estado::create([
                'name'=>strtolower($this->name),
                'tipo'=>strtolower($this->tipo)
            ]);

            // Notificación
            $this->dispatch('alerta', name:'Se ha creado correctamente el estado: '.$this->name);
            $this->resetFields();

            //refresh
            $this->dispatch('refresh');
            $this->dispatch('created');
        }
    }

    public function render()
    {
        return view('livewire.configuracion.estado.estado-create');
    }
}
