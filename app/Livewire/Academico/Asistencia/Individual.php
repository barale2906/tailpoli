<?php

namespace App\Livewire\Academico\Asistencia;

use App\Models\Academico\Asistencia;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Individual extends Component
{
    public $actual;
    public $grupo_id;
    public $profesor_id;
    public $alumno;
    public $fecha;
    public $contador;
    public $asistencias;
    public $xls=[];
    public $encabezado=[];
    public $crt=true;

    public function mount($elegido = null, $alumno_id=null, $crt=null){

        if($crt){
            $this->crt=!$this->crt;
        }
        $this->fecha=now();
        $this->fecha=date('Y-m-d');
        $this->alumno=User::find($alumno_id);
        $this->actual=Asistencia::whereId($elegido)->first();

        /* $this->grupo_id=$elegido['grupo_id'];
        $this->profesor_id=$elegido['profesor_id']; */
        $this->formaencabezado();

    }

    public function formaencabezado(){

        if($this->actual){

            $this->registroAsistencias();

            $this->reset('xls', 'orden');
            array_push($this->xls, "grupo");
            array_push($this->xls, "profesor");
            array_push($this->xls, "alumno");

            if($this->actual->registros>0){

                $a=$this->actual->registros;

                for ($i=1; $i <= $this->actual->registros; $i++){

                    $fecha="fecha".$a;
                    $fechaxls="fecha".$i;
                    $a--;
                    array_push($this->xls, $this->actual->$fechaxls);
                    array_push($this->encabezado, $fecha);
                }

            }
        }
    }

    public function registroAsistencias(){

        $this->asistencias=DB::table('asistencia_detalle')
                        ->where('asistencia_id', $this->actual->id)
                        ->where('alumno_id', $this->alumno->id)
                        ->get();
    }

    /* public function registrAsitencia(){
        if($this->actual){
            //Recorrer el array y obtener la clave de la fecha
            $indice=array_search($this->fecha,$this->encabezado,true);
            //unset($this->encabezado[$indice]);
        }
    } */

    public function render()
    {
        return view('livewire.academico.asistencia.individual');
    }
}
