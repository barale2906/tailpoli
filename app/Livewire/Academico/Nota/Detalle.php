<?php

namespace App\Livewire\Academico\Nota;

use App\Models\Academico\Nota;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Detalle extends Component
{
    public $encabezado=[];
    public $nots;
    public $notas;


    public function mount($nota){
        $this->notas=DB::table('notas_detalle')
                        ->where('id',$nota)
                        ->first();

        $this->formaencabezado($nota);
    }

    public function formaencabezado($nota){
        $this->nots=Nota::find($this->notas->nota_id);
        $contador=$this->nots->registros;

        for ($i=1; $i <= $contador; $i++) {

            $nota="nota".$i;
            $porce="porcen".$i;

            array_push($this->encabezado, $nota);
            array_push($this->encabezado, $porce);
        }
    }

    public function render()
    {
        return view('livewire.academico.nota.detalle');
    }
}
