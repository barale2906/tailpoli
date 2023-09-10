<?php

namespace App\Livewire\Configuracion\Sector;

use App\Models\Configuracion\Sector;
use Livewire\Component;

class SectorsCreate extends Component
{
    public $name = '';
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
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset('name');
    }

    // Crear Regimen de Salud
    public function new(){
        // validate
        $this->validate();

        //Verificar que no exista el registro en la base de datos
        $existe=Sector::Where('name', '=',strtolower($this->name))->count();

        if($existe>0){
            $this->dispatch('alerta', name:'Ya existe esta Población: '.$this->name);
        } else {

            //Crear registro
            Sector::create([
                'state_id'=>$this->idDep,
                'name'=>strtolower($this->name),
            ]);

            // Notificación
            $this->dispatch('alerta', name:'Se ha creado correctamente la población: '.$this->name);
            $this->resetFields();

            //refresh
            $this->dispatch('refresh');
            $this->dispatch('createdSubd');
        }
    }

    public function render()
    {
        return view('livewire.configuracion.sector.sectors-create');
    }
}
