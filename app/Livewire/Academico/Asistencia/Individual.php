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
    public $estudiante;
    public $fecha;
    public $contador;
    public $asistencias;
    public $xls=[];
    public $encabezado=[];

    public function mount($elegido = null, $estudiante_id=null){

        $this->fecha=now();
        $this->fecha=date('Y-m-d');
        $this->estudiante=User::find($estudiante_id);
        $this->actual=Asistencia::where('grupo_id', $elegido['grupo_id'])
                                    ->where('profesor_id', $elegido['profesor_id'])
                                    ->first();

        $this->grupo_id=$elegido['grupo_id'];
        $this->profesor_id=$elegido['profesor_id'];
        $this->formaencabezado();

    }

    public function formaencabezado(){

        if($this->actual){

            $this->contador=$this->actual->registros;
            $this->registroAsistencias();

            $this->reset('xls', 'orden');
            array_push($this->xls, "grupo");
            array_push($this->xls, "profesor");
            array_push($this->xls, "alumno");

            if($this->contador>0){
                $a=$this->contador;
                for ($i=1; $i <= $this->contador; $i++) {

                    $fecha="fecha".$a;
                    $fechaxls="fecha".$i;
                    $a--;
                    array_push($this->xls, $this->actual->$fechaxls);
                    array_push($this->encabezado, $fecha);
                }
            }

            $this->cargarEstudiantes();
        }
    }

    public function cargarEstudiantes(){

        if($this->actual->grupo->inscritos!==$this->asistencias->count()){
            $alumnos=User::query()
                            ->with(['alumnosGrupo'])
                            ->when($this->grupo_id, function($qu){
                                return $qu->where('status', true)
                                        ->whereHas('alumnosGrupo', function($q){
                                            $q->where('grupo_id', $this->grupo_id);
                                        });
                            })
                            ->select('id', 'name')
                            ->orderBy('name')
                            ->get();

            foreach ($alumnos as $value) {
                $esta=DB::table('asistencia_detalle')
                            ->where('asistencia_id', $this->actual->id)
                            ->where('alumno_id', $value->id)
                            ->count();

                if($esta===0){
                    $this->cargaEstudiante($value);
                }
            }
        }


        $this->registroAsistencias();
    }

    public function registroAsistencias(){

        $this->contador=$this->actual->registros;

        $this->asistencias=DB::table('asistencia_detalle')
                        ->where('asistencia_id', $this->actual->id)
                        ->orderBy('alumno')
                        ->get();
    }

    public function registrAsitencia(){
        if($this->actual){
            //Recorrer el array y obtener la clave de la fecha
            $indice=array_search($this->fecha,$this->encabezado,true);
            //unset($this->encabezado[$indice]);
        }
    }

    public function render()
    {
        return view('livewire.academico.asistencia.individual');
    }
}
