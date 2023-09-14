<?php

namespace App\Livewire\Academico\Modulo;

use App\Models\Academico\Curso;
use App\Models\Academico\Modulo;
use Livewire\Component;

class ModulosEditar extends Component
{
    public $name = '';
    public $curso_id = '';
    public $id = '';
    public $elegido;

    /**
     * Reglas de validación
     */
    protected $rules = [
        'name' => 'required|max:100',
        'id'    => 'required',
        'curso_id'=>'required'
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
        $this->curso_id=$elegido['curso_id'];
        $this->id=$elegido['id'];
    }

    public function curso($item){
        $this->curso_id=$item;
    }

    //Actualizar Regimen de Salud
    public function edit()
    {
        // validate
        $this->validate();

        //Actualizar registros
        Modulo::whereId($this->id)->update([
            'name'=>strtolower($this->name),
            'curso_id'=>$this->curso_id
        ]);

        $this->dispatch('alerta', name:'Se ha modificado correctamente el modulo: '.$this->name);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('Editando');
    }

    private function cursos()
    {
        return Curso::where('status', '=', true)
                    ->orderBy('name')
                    ->get();
    }

    public function render()
    {
        return view('livewire.academico.modulo.modulos-editar', [
            'cursos' => $this->cursos()
        ]);
    }
}
