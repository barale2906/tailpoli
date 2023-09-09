<?php

namespace App\Livewire\Configuracion\State;

use App\Models\Configuracion\State;
use Livewire\Component;

class StatesCreate extends Component
{
    public $name = '';
    public $codeZip = '';
    public $idDep = '';
    public $elegido = '';

    public function mount($elegido = null)
    {
        $this->idDep=$elegido['id'];
    }

    /**
     * Reglas de validación
     */
    protected $rules = [
        'name' => 'required|max:100',
        'codeZip'=>'required|integer|min:1'
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset('name', 'codeZip');
    }

    // Crear Regimen de Salud
    public function new(){
        // validate
        $this->validate();

        //Verificar que no exista el registro en la base de datos
        $existe=State::Where('name', '=',strtolower($this->name))->count();

        if($existe>0){
            $this->dispatch('alerta', name:'Ya existe este Departamento: '.$this->name);
        } else {

            //Crear registro
            State::create([
                'country_id'=>$this->idDep,
                'codeZip'=>$this->codeZip,
                'name'=>strtolower($this->name),
            ]);

            // Notificación
            $this->dispatch('alerta', name:'Se ha creado correctamente el Departamento: '.$this->name);
            $this->resetFields();

            //refresh
            $this->dispatch('refresh');
            $this->dispatch('createdSub');
        }
    }

    public function render()
    {
        return view('livewire.configuracion.state.states-create');
    }
}
