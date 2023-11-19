<?php

namespace App\Livewire\Academico\Gestion;

use App\Models\Academico\Control;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Observaciones extends Component
{
    public $elegido;
    public $comentarios;

    public function mount($elegido=null){

        $this->elegido=Control::find($elegido);

    }

    public function guardar(){

        $comen=now()." ".Auth::user()->name." escribio: ".$this->comentarios." ----- ".$this->elegido->observaciones;

        $this->elegido->update([
            'observaciones'=>$comen
        ]);

        $this->dispatch('alerta', name:'Comentario guardado satisfactoriamente');

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');
    }

    public function render()
    {
        return view('livewire.academico.gestion.observaciones');
    }
}
