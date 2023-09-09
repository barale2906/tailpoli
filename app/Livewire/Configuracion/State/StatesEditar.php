<?php

namespace App\Livewire\Configuracion\State;

use App\Models\Configuracion\State;
use Livewire\Component;

class StatesEditar extends Component
{
    public $name = '';
    public $codeZip = '';
    public $id = '';
    public $elegido;

    /**
     * Reglas de validación
     */
    protected $rules = [
        'name' => 'required|max:100',
        'codeZip'=>'required|integer|min:1',
        'id'    => 'required'
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset('name', 'id', 'codeZip');
    }

    public function mount($elegido = null)
    {
        $this->name=$elegido['name'];
        $this->id=$elegido['id'];
        $this->codeZip=$elegido['codeZip'];
    }

    //Actualizar Regimen de Salud
    public function edit()
    {
        // validate
        $this->validate();

        //Actualizar registros
        State::whereId($this->id)->update([
            'name'=>strtolower($this->name),
            'codeZip'=>$this->codeZip,
        ]);

        $this->dispatch('alerta', name:'Se ha modificado correctamente el departamento: '.$this->name);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('EditandoSub');
    }

    public function render()
    {
        return view('livewire.configuracion.state.states-editar');
    }
}
