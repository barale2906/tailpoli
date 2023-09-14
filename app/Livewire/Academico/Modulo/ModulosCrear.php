<?php

namespace App\Livewire\Academico\Modulo;

use App\Models\Academico\Curso;
use App\Models\Academico\Modulo;
use Livewire\Component;

class ModulosCrear extends Component
{
    public $name = '';
    public $curso_id = '';
    public $mostrar=false;

    public function curso($item){
        $this->curso_id=$item;
        $this->mostrar=true;
    }

    /**
     * Reglas de validación
     */
    protected $rules = [
        'name' => 'required|max:100',
        'curso_id'=>'required'
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset('name', 'curso_id');
    }

    // Crear Regimen de Salud
    public function new(){
        // validate
        $this->validate();

        //Verificar que no exista el registro en la base de datos
        $existe=Modulo::Where('name', '=',strtolower($this->name))->count();

        if($existe>0){
            $this->dispatch('alerta', name:'Ya existe este modulo: '.$this->name);
        } else {
            //Crear registro
            Modulo::create([
                'name'=>strtolower($this->name),
                'curso_id'=>strtolower($this->curso_id)
            ]);

            // Notificación
            $this->dispatch('alerta', name:'Se ha creado correctamente el modulo: '.$this->name);
            $this->resetFields();

            //refresh
            $this->dispatch('refresh');
            $this->dispatch('created');
        }
    }

    private function cursos()
    {
        return Curso::where('status', '=', true)
                    ->orderBy('name')
                    ->get();
    }

    public function render()
    {
        return view('livewire.academico.modulo.modulos-crear', [
            'cursos' => $this->cursos()
        ]);
    }
}
