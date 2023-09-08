<?php

namespace App\Livewire\Admin\Multi;

use App\Models\Admin\PersonaMulticultural;
use Livewire\Component;

class PersonamultiInactivar extends Component
{
    public $name = '';
    public $id = '';
    public $multiElegido;
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

    public function mount($multiElegido = null)
    {
        $this->name=$multiElegido['name'];
        $this->id=$multiElegido['id'];
        if($multiElegido['status']===1){
            $this->status=true;
        }else{
            $this->status=false;
        }
    }

    //Inactivar Regimen de Salud
    public function inactivar()
    {

        //Actualizar registros
        PersonaMulticultural::whereId($this->id)->update([
            'status'=>!$this->status
        ]);

        $this->dispatch('alerta', name:'Se cambio el estado del tipo: '.$this->name);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('Inactivando');
    }

    public function render()
    {
        return view('livewire.admin.multi.personamulti-inactivar');
    }
}
