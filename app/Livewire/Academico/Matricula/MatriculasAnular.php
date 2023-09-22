<?php

namespace App\Livewire\Academico\Matricula;

use App\Models\Academico\Matricula;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MatriculasAnular extends Component
{
    public $matricula;
    public $motivo;
    public $id;

    public function mount($elegido = null)
    {
        $this->id=$elegido['id'];
        $this->matricula=Matricula::find($elegido['id']);
    }

    /**
     * Reglas de validación
     */
    protected $rules = [
        'motivo' => 'required'
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset('motivo', 'id');
    }

    //Actualizar
    public function edit()
    {
        // validate
        $this->validate();

        //Actualizar registros
        Matricula::whereId($this->id)->update([
            'anula'=>strtolower($this->motivo),
            'anula_user'=>Auth::user()->name,
            'status'=>false
        ]);

        $this->dispatch('alerta', name:'Se ha anulado correctamente la matricula');
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('Editando');
    }

    public function render()
    {
        return view('livewire.academico.matricula.matriculas-anular');
    }
}
