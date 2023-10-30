<?php

namespace App\Livewire\Academico\Asistencia;

use App\Models\Academico\Nota;
use Livewire\Component;

class Asistencias extends Component
{
    public $id;
    public $actual;
    public $asistencias;


    public function mount($elegido = null){
        $this->id=$elegido['id'];
        $this->actual=Nota::whereId($elegido['id'])->first();
    }


    public function render()
    {
        return view('livewire.academico.asistencia.asistencias');
    }
}
