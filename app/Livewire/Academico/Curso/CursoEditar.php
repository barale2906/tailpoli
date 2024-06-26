<?php

namespace App\Livewire\Academico\Curso;

use App\Models\Academico\Curso;
use Livewire\Component;

class CursoEditar extends Component
{
    public $name = '';
    public $slug;
    public $tipo = '';
    public $duracion_horas='';
    public $duracion_meses='';
    public $id = '';
    public $elegido;
    public $correo;

    /**
     * Reglas de validación
     */
    protected $rules = [
        'name' => 'required|max:100',
        'slug' => 'required|max:100',
        'tipo'=>'required',
        'duracion_horas'=>'required|integer|min:1|max:1000',
        'duracion_meses'=>'required|integer|min:1|max:1000',
        'id'    => 'required',
        'correo'    =>'required'
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
        $this->tipo=$elegido['tipo'];
        $this->slug=$elegido['slug'];
        $this->duracion_horas=$elegido['duracion_horas'];
        $this->duracion_meses=$elegido['duracion_meses'];
        $this->id=$elegido['id'];
        $this->correo=$elegido['correo'];
    }

    //Actualizar
    public function edit()
    {
        // validate
        $this->validate();

        //Actualizar registros
        Curso::whereId($this->id)->update([
            'name'=>strtolower($this->name),
            'tipo'=>strtolower($this->tipo),
            'slug'=>$this->slug,
            'duracion_horas'=>strtolower($this->duracion_horas),
            'duracion_meses'=>strtolower($this->duracion_meses),
            'correo'        =>$this->correo
        ]);

        $this->dispatch('alerta', name:'Se ha modificado correctamente el curso: '.$this->name);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
    }

    public function render()
    {
        return view('livewire.academico.curso.curso-editar');
    }
}
