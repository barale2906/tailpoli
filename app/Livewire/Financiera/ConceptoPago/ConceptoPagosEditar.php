<?php

namespace App\Livewire\Financiera\ConceptoPago;

use App\Models\Financiera\ConceptoPago;
use Livewire\Component;

class ConceptoPagosEditar extends Component
{
    public $name = '';
    public $tipo = '';
    public $id = '';
    public $elegido;

    /**
     * Reglas de validación
     */
    protected $rules = [
        'name'  => 'required|max:100',
        'tipo' => 'required',
        'id'    => 'required'
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset('name', 'id', 'tipo');
    }

    public function mount($elegido = null)
    {
        $this->name=$elegido['name'];
        $this->tipo=$elegido['tipo'];
        $this->id=$elegido['id'];
    }

    //Actualizar Regimen de Salud
    public function edit()
    {
        // validate
        $this->validate();

        //Actualizar registros
        ConceptoPago::whereId($this->id)->update([
            'name'=>strtolower($this->name),
            'tipo'=>strtolower($this->tipo),
        ]);

        $this->dispatch('alerta', name:'Se ha modificado correctamente el estado: '.$this->name);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('Editando');
    }

    public function render()
    {
        return view('livewire.financiera.concepto-pago.concepto-pagos-editar');
    }
}
