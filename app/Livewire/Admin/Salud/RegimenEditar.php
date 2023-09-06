<?php

namespace App\Livewire\Admin\Salud;

use App\Models\Admin\RegimenSalud;
use Livewire\Attributes\On;
use Livewire\Component;

class RegimenEditar extends Component
{
    public $name = '';
    public $id = '';
    public $regimenElegido;

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

    public function mount($regimenElegido = null)
    {
        $this->name=$regimenElegido['name'];
        $this->id=$regimenElegido['id'];
    }

    //Actualizar Regimen de Salud
    public function editRegimen()
    {
        // validate
        $this->validate();

        //Actualizar registros
        RegimenSalud::whereId($this->id)->update([
            'name'=>$this->name
        ]);

        $this->dispatch('alerta', name:'Se ha modificado correctamente el regímen de salud: '.$this->name);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('Editando-regimen');
    }





    public function render()
    {
        return view('livewire.admin.salud.regimen-editar');
    }
}
