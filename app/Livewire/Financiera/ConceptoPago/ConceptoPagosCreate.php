<?php

namespace App\Livewire\Financiera\ConceptoPago;

use App\Models\Financiera\ConceptoPago;
use Livewire\Component;

class ConceptoPagosCreate extends Component
{
    public $name = '';
    public $tipo = '';
    public $valor = 0;

    /**
     * Reglas de validación
     */
    protected $rules = [
        'name' => 'required|max:100',
        'valor' => 'required',
        'tipo' => 'required'

    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset('name', 'tipo', 'valor');
    }

    // Crear Regimen de Salud
    public function new(){
        // validate
        $this->validate();

        //Verificar que no exista el registro en la base de datos
        $existe=ConceptoPago::Where('name', '=',strtolower($this->name))->count();

        if($existe>0){
            $this->dispatch('alerta', name:'Ya existe este concepto de pago: '.$this->name);
        } else {
            //Crear registro
            ConceptoPago::create([
                'name'=>strtolower($this->name),
                'tipo'=>strtolower($this->tipo),
                'valor'=>$this->valor
            ]);

            // Notificación
            $this->dispatch('alerta', name:'Se ha creado correctamente el concepto de pago: '.$this->name);
            $this->resetFields();

            //refresh
            $this->dispatch('refresh');
            $this->dispatch('created');
        }
    }

    public function render()
    {
        return view('livewire.financiera.concepto-pago.concepto-pagos-create');
    }
}
