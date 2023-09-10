<?php

namespace App\Livewire\Configuracion\Country;

use App\Models\Configuracion\Country;
use Livewire\Attributes\On;
use Livewire\Component;

class CountryEditar extends Component
{
    public $name = '';
    public $id = '';
    public $elegido;

    public $is_state = false;
    public $is_sector = true;

    /**
     * Reglas de validación
     */
    protected $rules = [
        'name'  => 'required|max:100',
        'id'    => 'required'
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset('name', 'id');
    }

    public function mount($elegido = null)
    {
        $this->name=$elegido['name'];
        $this->id=$elegido['id'];
    }

    //Activar evento encabezado
    #[On('verSector')]
    //Mostrar o no encabezado
    public function sectorVer(){
        $this->is_sector=!$this->is_sector;
    }

    //Actualizar Regimen de Salud
    public function edit()
    {
        // validate
        $this->validate();

        //Actualizar registros
        Country::whereId($this->id)->update([
            'name'=>strtolower($this->name)
        ]);

        $this->dispatch('alerta', name:'Se ha modificado correctamente el país: '.$this->name);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('Editando');
    }

    //Mostrar departamentos
    public function mostrar(){
        $this->is_state = !$this->is_state;
    }

    public function render()
    {
        return view('livewire.configuracion.country.country-editar');
    }
}
