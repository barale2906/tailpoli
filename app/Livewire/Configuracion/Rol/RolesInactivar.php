<?php

namespace App\Livewire\Configuracion\Rol;

use Livewire\Component;
use Spatie\Permission\Models\Role;

class RolesInactivar extends Component
{
    public $name = '';
    public $id = '';
    public $elegido;
    public $status = true;

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
        $this->reset('name', 'id', 'status');
    }

    public function mount($elegido = null)
    {
        $this->name=$elegido['name'];
        $this->id=$elegido['id'];
        if($elegido['status']===1){
            $this->status=true;
        }else{
            $this->status=false;
        }
    }

    //Inactivar Regimen de Salud
    public function inactivar()
    {

        //Actualizar registros
        Role::whereId($this->id)->update([
            'status'=>!$this->status
        ]);

        $this->dispatch('alerta', name:'Se cambio el estado de: '.$this->name);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('Inactivando');
    }

    public function render()
    {
        return view('livewire.configuracion.rol.roles-inactivar');
    }
}
