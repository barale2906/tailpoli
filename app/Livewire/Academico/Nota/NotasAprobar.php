<?php

namespace App\Livewire\Academico\Nota;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class NotasAprobar extends Component
{
    public $actual;
    public $aprueba;
    public $idcierra;
    public $observaciones;
    public $encabezado=[];
    public $datoEstudiante;

    public function mount($actual = null, $idcierra=null){
        $this->actual=$actual;
        $this->idcierra=$idcierra;

        $this->notaestu();
    }

    public function notaestu(){
        $this->datoEstudiante=DB::table('notas_detalle')
                                ->where('id', $this->idcierra)
                                ->first();

        $this->calculaencabezado();
    }

    public function calculaencabezado(){
        for ($i=1; $i <= $this->actual->registros; $i++) {
            $nota="nota".$i;
            $pocen="porcen".$i;

            $nuevo=[
                'id'            =>$i,
                'califica'      =>$this->actual->$nota,
                'porcentaje'    =>$this->actual->$pocen,
                'obtenidoNota'  =>$this->datoEstudiante->$nota,
                'acumnota'      =>$this->datoEstudiante->$pocen
            ];

            array_push($this->encabezado, $nuevo);
        }
    }



    public function render()
    {
        return view('livewire.academico.nota.notas-aprobar');
    }
}
