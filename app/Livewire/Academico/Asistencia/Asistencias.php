<?php

namespace App\Livewire\Academico\Asistencia;

use App\Models\Academico\Asistencia;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Asistencias extends Component
{
    public $actual;
    public $asistencias;
    public $grupo_id;
    public $profesor_id;
    public $encabezado=[];
    public $contador=0;


    public function mount($elegido = null){
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

            if($this->contador>0){
                for ($i=1; $i <= $this->contador; $i++) {

                    $nota="fecha".$i;

                    array_push($this->encabezado, $nota);
                }
            }

            $this->cargarEstudiantes();
        }else{
            $this->dispatch('alerta', name:'Debe Crear Primer Fecha de Registro');
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
                            ->where('asistencia_id', $this->id)
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
                        ->where('nota_id', $this->id)
                        ->orderBy('alumno')
                        ->get();
    }

    public function cargaEstudiante($estu){
        DB::table('asistencia_detalle')
            ->insert([
                'asistencia_id' =>$this->actual->id,
                'alumno_id'     =>$estu->id,
                'alumno'        =>$estu->name,
                'profesor_id'   =>$this->actual->profesor_id,
                'profesor'      =>$this->actual->profesor->name,
                'grupo_id'      =>$this->actual->grupo_id,
                'grupo'         =>$this->actual->grupo->name,
                'created_at'    =>now(),
                'updated_at'    =>now()
            ]);
    }


    public function render()
    {
        return view('livewire.academico.asistencia.asistencias');
    }
}
