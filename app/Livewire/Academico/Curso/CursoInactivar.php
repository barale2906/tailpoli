<?php

namespace App\Livewire\Academico\Curso;

use App\Models\Academico\Curso;
use Livewire\Component;

class CursoInactivar extends Component
{
    public $name = '';
    public $tipo = '';
    public $duracion_horas='';
    public $duracion_meses='';
    public $id = '';
    public $elegido;
    public $status = true;

    /**
     * Reglas de validación
     */
    protected $rules = [
        'name' => 'required|max:100',
        'tipo'=>'required',
        'duracion_horas'=>'required|integer|min:1|max:1000',
        'duracion_meses'=>'required|integer|min:1|max:1000',
        'id'    => 'required'
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset('name', 'tipo', 'duracion_horas', 'duracion_meses', 'id');
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
        Curso::whereId($this->id)->update([
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
        return view('livewire.academico.curso.curso-inactivar');
    }
}
