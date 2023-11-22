<?php

namespace App\Livewire\Academico\Nota;

use App\Models\Academico\Nota;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Individual extends Component
{
    public $alumno_id;
    public $actual;
    public $notas;
    public $encabezado=[];
    public $mapaencabe=[];

    public function mount($nota, $alumno_id){

        $this->alumno_id=$alumno_id;
        $this->actual=Nota::whereId($nota)->first();
        $this->notasdetalle();
    }

    public function notasdetalle(){
        $this->notas=DB::table('notas_detalle')
                        ->where('nota_id', $this->actual->id)
                        ->where('alumno_id', $this->alumno_id)
                        ->orderBy('alumno')
                        ->get();

        $this->formaencabezado();
    }

    public function formaencabezado(){

        for ($i=1; $i <= $this->actual->registros; $i++) {

            $nota="nota".$i;
            $porce="porcen".$i;

            array_push($this->encabezado, $nota);
            array_push($this->encabezado, $porce);

            $nuevo=[
                'id'    =>$i,
                'nota'  =>$nota,
                'porcen'=>$porce
            ];

            array_push($this->mapaencabe, $nuevo);
        }
    }

    public function render()
    {
        return view('livewire.academico.nota.individual');
    }
}
