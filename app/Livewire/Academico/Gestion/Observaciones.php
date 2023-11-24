<?php

namespace App\Livewire\Academico\Gestion;

use App\Models\Academico\Control;
use App\Models\Financiera\Cartera;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Observaciones extends Component
{
    public $elegido;
    public $comentarios;
    public $fecha;
    public $ruta;
    public $alumno;

    public function mount($elegido=null, $ruta=null){
        $this->ruta=$ruta;
        $this->elegido=Control::find($elegido);
        $this->fecha=now();
        $this->alumn();
    }

    public function alumn(){
        $this->alumno=$this->elegido->estudiante_id;
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

    private function cartera(){
        return Cartera::where('responsable_id', $this->elegido->estudiante_id)
                        ->where('status', true)
                        ->get();
    }

    public function render()
    {
        return view('livewire.academico.gestion.observaciones',[
            'cartera'=>$this->cartera(),
        ]);
    }
}
