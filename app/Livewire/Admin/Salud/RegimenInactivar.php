<?php

namespace App\Livewire\Admin\Salud;

use App\Models\Admin\RegimenSalud;
use Livewire\Component;

class RegimenInactivar extends Component
{
    public $name = '';
    public $id = '';
    public $regimenElegido;
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

    public function mount($regimenElegido = null)
    {
        $this->name=$regimenElegido['name'];
        $this->id=$regimenElegido['id'];
        if($regimenElegido['status']===1){
            $this->status=true;
        }else{
            $this->status=false;
        }
    }

    //Inactivar Regimen de Salud
    public function inactivarRegimen()
    {

        //Actualizar registros
        RegimenSalud::whereId($this->id)->update([
            'status'=>!$this->status
        ]);

        $this->dispatch('alerta', name:'Se cambio el estado del regímen de salud: '.$this->name);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('Inactivando-regimen');
    }

    public function render()
    {
        return view('livewire.admin.salud.regimen-inactivar');
    }
}
