<?php

namespace App\Livewire\Admin\Salud;

use App\Models\Admin\RegimenSalud as AdminRegimenSalud;
use Livewire\Component;

class RegimenSalud extends Component
{
    public $is_modify = true;
    public $is_creating = false;
    public $name = '';
    public $crear = false;

    protected $listeners = ['refresh' => '$refresh'];

    //Mostrar formulario de creación
    public function updatedIsCreating()
    {
        $this->is_modify = !$this->is_modify;
        $this->name = '';
        $this->crear=!$this->crear;
    }

    // Crear Regimen de Salud
    public function newRegimen(){
        // validate
        $this->validate(['name' => 'required']);

        //Crear registro
        AdminRegimenSalud::create([
            'name'=>strtolower($this->name),
        ]);
        // Notificación

        session()->flash('Swal', [
            'position' => 'top-end',
            'icon' => 'success',
            'title' => 'Se creo correctamente el Régimen: '.$this->name,
            'showConfirmButton' => false,
            'timer' => 1500
        ]);

        //refresh
        $this->is_creating = false;
        $this->is_modify = !$this->is_modify;
        $this->dispatch('refresh');
    }

    public function render()
    {
        $regimenes = AdminRegimenSalud::all();

        return view('livewire.admin.salud.regimen-salud', [
            'regimenes' => $regimenes
        ]);
    }
}
