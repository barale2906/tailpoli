<?php

namespace App\Livewire\Academico\Nota;

use App\Models\Academico\Nota;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class NotasAlumno extends Component
{
    public $notas;
    public $notaenv;
    public $porcenv;
    public $actual;
    public $calificacion;


    public function mount($notaenv = null, $porcenv = null, $actual = null){

        $this->notaenv=$notaenv;
        $this->porcenv=$porcenv;
        $this->actual=$actual;

        $this->registroNotas();
    }

    public function registroNotas(){

        $this->notas=DB::table('notas_detalle')
                        ->where('nota_id', $this->actual->id)
                        ->orderBy('alumno')
                        ->get();
    }

    public function subir($id){
        if($this->calificacion===null){
            $this->dispatch('alerta', name:'Debe registrar nota.');
        }else{

        }
    }

    public function render()
    {
        return view('livewire.academico.nota.notas-alumno');
    }
}
