<?php

namespace App\Livewire\Academico\Matricula;

use App\Models\Academico\Matricula;
use App\Models\User;
use Livewire\Component;

class Comerciales extends Component
{
    public $actual;
    public $comercial;
    public $creador;

    public function mount($elegido){
        $this->actual=Matricula::find($elegido);
        $this->asignar();
    }

    public function asignar(){
        $this->comercial=$this->actual->comercial_id;
        $this->creador=$this->actual->creador_id;
    }

    public function actualizar(){
        $this->actual->update([
            'comercial_id'  =>$this->comercial,
            'creador_id'    =>$this->creador,
        ]);

        // Notificación
        $this->dispatch('alerta', name:'Actualizó el asesor comercial y / o el creador de la matricula');
        $this->dispatch('cancelando');
    }

    private function trabajadores(){
        return User::where('rol_id', '<',6)
                    //->where('status', true)
                    ->orderBy('name', 'ASC')
                    ->get();
    }


    public function render()
    {
        return view('livewire.academico.matricula.comerciales',[
            'trabajadores'  => $this->trabajadores(),
        ]);
    }
}
