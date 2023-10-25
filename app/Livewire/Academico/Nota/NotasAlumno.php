<?php

namespace App\Livewire\Academico\Nota;

use App\Models\Academico\Nota;
use App\Models\User;
use Livewire\Component;

class NotasAlumno extends Component
{
    public $grupo_id;
    public $profesor_id;
    public $encabezado=[];
    public $contador;
    public $alumnos;
    public $actual;

    public function mount($actual = null, $contador = null){

        $this->grupo_id=$actual['grupo_id'];
        $this->profesor_id=$actual['profesor_id'];
        $this->actual=Nota::find($actual['id']);
        $this->contador=$contador;

        $this->estudiantes();
        $this->creaEncabezado();

    }

    public function estudiantes(){
        $this->alumnos=User::query()
                            ->with(['alumnosGrupo'])
                            ->when($this->grupo_id, function($qu){
                                return $qu->where('status', true)
                                        ->whereHas('alumnosGrupo', function($q){
                                            $q->where('grupo_id', $this->grupo_id);
                                        });
                            })
                            ->orderBy('name')
                            ->get();
    }

    public function creaEncabezado(){

        $i=1;

        for ($i=1; $i <= $this->contador; $i++) {

            $nota="nota".$i;
            $porce="porcen".$i;

            $nuevo=[
                'id'=>$i,
                $nota=>$this->actual->$nota,
                $porce=>$this->actual->$porce,
            ];

            array_push($this->encabezado, $nuevo);

        }

    }


    public function render()
    {
        return view('livewire.academico.nota.notas-alumno');
    }
}
