<?php

namespace App\Livewire\Admin\Salud;

use App\Models\Admin\RegimenSalud as AdminRegimenSalud;
use Livewire\Attributes\On;
use Livewire\Component;

class RegimenSalud extends Component
{
    public $is_modify = true;
    public $is_creating = false;
    public $is_editing = false;
    public $is_deleting = false;
    public $regimenElegido;


    protected $listeners = ['refresh' => '$refresh'];

    //Activar evento
    #[On('created-regimen')]
    //Mostrar formulario de creación
    public function updatedIsCreating()
    {
        $this->is_modify = !$this->is_modify;
        $this->is_creating = !$this->is_creating;
    }

    //Activar evento
    #[On('Editando-regimen')]
    //Mostrar formulario de creación
    public function updatedIsEditing()
    {
        $this->is_modify = !$this->is_modify;
        $this->is_editing = !$this->is_editing;
    }

    //Activar evento
    #[On('Inactivando-regimen')]
    //Mostrar formulario de inactivación
    public function updatedIsDeleting()
    {
        $this->is_modify = !$this->is_modify;
        $this->is_deleting = !$this->is_deleting;
    }

    // Mostrar Regimen de Salud
    public function showRegimen($regimen, $act){

        $this->regimenElegido=$regimen;
        $this->is_modify = !$this->is_modify;

        if($act===0){
            $this->is_editing=!$this->is_editing;
        }else{
            $this->is_deleting=!$this->is_deleting;
        }
    }

    public function render()
    {
        $regimenes = AdminRegimenSalud::all();

        return view('livewire.admin.salud.regimen-salud', [
            'regimenes' => $regimenes
        ]);
    }
}
