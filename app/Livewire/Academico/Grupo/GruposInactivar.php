<?php

namespace App\Livewire\Academico\Grupo;

use App\Models\Academico\Grupo;
use Livewire\Component;

class GruposInactivar extends Component
{
    public $name = '';
    public $id = '';
    public $elegido;
    public $status = true;


    public function mount($elegido = null)
    {
        $this->name=$elegido['name'];
        $this->id=$elegido['id'];
        if($elegido['status']===1){
            $this->status=true;
        }else{
            $this->status=false;
        }
    }

    //Inactivar Regimen de Salud
    public function inactivar()
    {

        //Actualizar registros
        Grupo::whereId($this->id)->update([
            'status'=>!$this->status
        ]);

        $this->dispatch('alerta', name:'Se cambio el estado de: '.$this->name);

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('Inactivando');
    }

    public function render()
    {
        return view('livewire.academico.grupo.grupos-inactivar');
    }
}
