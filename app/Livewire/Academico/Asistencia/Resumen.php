<?php

namespace App\Livewire\Academico\Asistencia;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Resumen extends Component
{
    public $actual;

    public function mount($id){

        //Obtener los grupos a los cuales esta registrado
        $this->actual=DB::table('asistencia_detalle')
                            ->where('alumno_id',$id)
                            ->orderBy('grupo','ASC')
                            ->get();
    }

    public function render()
    {
        return view('livewire.academico.asistencia.resumen');
    }
}
