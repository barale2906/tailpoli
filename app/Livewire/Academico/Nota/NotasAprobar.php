<?php

namespace App\Livewire\Academico\Nota;

use App\Models\Academico\Grupo;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class NotasAprobar extends Component
{
    public $actual;
    public $aprueba=0;
    public $idcierra;
    public $encabezado=[];
    public $datoEstudiante;
    public $grupo;

    public function mount($actual = null, $idcierra=null){
        $this->actual=$actual;
        $this->idcierra=$idcierra;
        $this->grupo=Grupo::whereId($this->actual->grupo_id)
                            ->select('modulo_id')
                            ->first();

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
