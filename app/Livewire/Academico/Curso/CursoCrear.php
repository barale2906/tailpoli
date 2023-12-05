<?php

namespace App\Livewire\Academico\Curso;

use App\Models\Academico\Curso;
use Livewire\Component;

class CursoCrear extends Component
{
    public $name = '';
    public $slug;
    public $tipo = '';
    public $duracion_horas='';
    public $duracion_meses='';
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
        'correo'    =>'required'
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset('name', 'tipo', 'duracion_horas', 'duracion_meses');
    }

    // Crear Regimen de Salud
    public function new(){
        // validate
        $this->validate();

        //Verificar que no exista el registro en la base de datos
        $existe=Curso::Where('name', '=',strtolower($this->name))
                        ->orWhere('slug', '=',$this->slug)
                        ->count();

        if($existe>0){
            $this->dispatch('alerta', name:'Ya existe este nombre o abreviación de curso: '.$this->name);
        } else {
            //Crear registro
            Curso::create([
                'name'=>strtolower($this->name),
                'slug'=>$this->slug,
                'tipo'=>strtolower($this->tipo),
                'duracion_horas'=>strtolower($this->duracion_horas),
                'duracion_meses'=>strtolower($this->duracion_meses),
                'correo'        =>$this->correo
            ]);

            // Notificación
            $this->dispatch('alerta', name:'Se ha creado correctamente el curso: '.$this->name);
            $this->resetFields();

            //refresh
            $this->dispatch('refresh');
            $this->dispatch('created');
        }
    }

    public function render()
    {
        return view('livewire.academico.curso.curso-crear');
    }
}
