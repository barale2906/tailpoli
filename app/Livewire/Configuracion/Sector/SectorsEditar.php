<?php

namespace App\Livewire\Configuracion\Sector;

use App\Models\Configuracion\Sector;
use Livewire\Component;

class SectorsEditar extends Component
{
    public $name = '';
    public $id = '';
    public $elegido;

    /**
     * Reglas de validación
     */
    protected $rules = [
        'name' => 'required|max:100',
        'id'    => 'required'
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
        $this->id=$elegido['id'];
    }

    //Actualizar Regimen de Salud
    public function edit()
    {
        // validate
        $this->validate();

        //Actualizar registros
        Sector::whereId($this->id)->update([
            'name'=>strtolower($this->name),
        ]);

        $this->dispatch('alerta', name:'Se ha modificado correctamente el departamento: '.$this->name);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('EditandoSubd');
    }

    public function render()
    {
        return view('livewire.configuracion.sector.sectors-editar');
    }
}
