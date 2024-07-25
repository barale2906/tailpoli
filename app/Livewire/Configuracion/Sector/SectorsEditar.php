<?php

namespace App\Livewire\Configuracion\Sector;

use App\Models\Configuracion\Sector;
use Livewire\Component;
use Illuminate\Support\Str;

class SectorsEditar extends Component
{
    public $name = '';
    public $slug='';
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
        $this->reset('name', 'id', 'slug');
    }

    public function mount($elegido = null)
    {
        $this->name=$elegido['name'];
        $this->slug=$elegido['slug'];
        $this->id=$elegido['id'];
    }

    //Actualizar Regimen de Salud
    public function edit()
    {
        $this->slug = Str::slug($this->name);
        // validate
        $this->validate();

        //Actualizar registros
        Sector::whereId($this->id)->update([
            'name'=>strtolower($this->name),
            'slug'=>strtolower($this->slug),
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
