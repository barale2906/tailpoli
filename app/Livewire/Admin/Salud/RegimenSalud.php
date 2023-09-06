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
    public $name = '';
    public $id = '';
    public $status = true;
    public $estado = false;
    public $regimenElegido;


    protected $listeners = ['refresh' => '$refresh'];

    /**
     * Reglas de validación
     */
    /* protected $rules = [
        'name' => 'required|max:100'
    ]; */

    /**
     * Reset de todos los campos
     * @return void
     */
    /* public function resetFields(){
        $this->reset('name');
    } */

    //Activar evento
    #[On('created-regimen')]
    //Mostrar formulario de creación
    public function updatedIsCreating()
    {
        $this->is_modify = !$this->is_modify;
        $this->is_creating = !$this->is_creating;
        //$this->resetFields();
    }

    //Activar evento
    #[On('Editando-regimen')]
    //Mostrar formulario de creación
    public function updatedIsEditing()
    {
        $this->is_modify = !$this->is_modify;
        $this->is_editing = !$this->is_editing;
    }
    //Mostrar formulario de inactivación
    public function updatedIsDeleting()
    {
        $this->is_modify = !$this->is_modify;
        //$this->resetFields();
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
        /* $this->name=$regimen['name'];
        $this->id=$regimen['id'];
        if($regimen['status']===1){
            $this->status=true;
        }else{
            $this->status=false;
        } */
    }

    //Actualizar Regimen de Salud
    /* public function editRegimen()
    {
        // validate
        $this->validate();

        //Actualizar registros
        AdminRegimenSalud::whereId($this->id)->update([
            'name'=>$this->name
        ]);

        $this->dispatch('alerta', name:'Se ha modificado correctamente el regímen de salud: '.$this->name);
        $this->resetFields();

        //refresh
        $this->is_editing = false;
        $this->is_modify = !$this->is_modify;
        $this->dispatch('refresh');
    } */

    //Inactivar Regimen de Salud
    public function inactivarRegimen()
    {

        //Actualizar registros
        AdminRegimenSalud::whereId($this->id)->update([
            'status'=>!$this->status
        ]);

        $this->dispatch('alerta', name:'Se cambio el estado del regímen de salud: '.$this->name);
        $this->resetFields();

        //refresh
        $this->is_deleting = false;
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
