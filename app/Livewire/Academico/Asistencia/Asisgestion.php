<?php

namespace App\Livewire\Academico\Asistencia;

use App\Exports\AcaAsistenciaExport;
use App\Models\Academico\Asistencia;
use App\Models\Academico\Control;
use App\Models\Academico\Grupo;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Asisgestion extends Component
{
    public $grupo_id;
    public $grupo;
    public $estudiante;
    public $fecha;
    public $actual;
    public $asistencias;
    public $encabezado=[];
    public $xls=[];

    public function mount($elegido=null, $estudiante_id=null){

        $this->grupo_id=$elegido;
        $this->grupo=Grupo::find($elegido);
        if($estudiante_id){
            $this->estudiante=User::find($estudiante_id);
        }
        $this->cargarActual();
    }

    public function cargarActual(){

        $esta=Asistencia::where('profesor_id', $this->grupo->profesor_id)
                        ->where('grupo_id', $this->grupo->id)
                        ->first();

        if($esta){
            $this->actual=$esta;
            $this->cargarEstudiantes();
        }else{
            $this->nuevo();
        }
    }

    public function nuevo(){
        $this->actual=Asistencia::create([
            'profesor_id'   => $this->grupo->profesor_id,
            'grupo_id'      => $this->grupo->id,
            'registros'     => 0
        ]);

        $this->cargarEstudiantes();
    }

    public function cargarEstudiantes(){

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



        $this->registroAsistencias();
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

    public function registroAsistencias(){

        $this->reset('asistencias', 'encabezado', 'xls');

        if($this->estudiante){
            $this->asistencias=DB::table('asistencia_detalle')
                                    ->where('status', true)
                                    ->where('asistencia_id', $this->actual->id)
                                    ->where('alumno_id', $this->estudiante->id)
                                    ->orderBy('alumno')
                                    ->first();
        }else{
            $this->asistencias=DB::table('asistencia_detalle')
                                    ->where('status', true)
                                    ->where('asistencia_id', $this->actual->id)
                                    ->orderBy('alumno')
                                    ->get();
        }


        $this->formaencabezado();
    }

    public function formaencabezado(){

            $this->reset('xls');
            array_push($this->xls, "grupo");
            array_push($this->xls, "profesor");
            array_push($this->xls, "alumno");

            if($this->actual->registros>0){
                $a=$this->actual->registros;
                for ($i=1; $i <= $this->actual->registros; $i++) {

                    $fecha="fecha".$a;
                    $fechaxls="fecha".$i;
                    $a--;
                    array_push($this->xls, $this->actual->$fechaxls);
                    array_push($this->encabezado, $fecha);
                }
            }
    }

    public function registro(){

        $this->cargarActual();

        //Verifica existencia de la fecha
        $esta=0;

        foreach ($this->encabezado as $value) {
            if($this->actual->$value===$this->fecha){
                $esta=1;
            }
        }

        if($esta>0){
            $this->dispatch('alerta', name:'La fecha ya esta cargada, incluya asistencias');
        }else{
            $this->asistenciaEncabezado();
        }
    }

    public function asistenciaEncabezado(){

        $titulo="fecha".$this->actual->registros+1;
        Asistencia::whereId($this->actual->id)
                    ->update([
                        $titulo         =>$this->fecha,
                        'registros'     =>$this->actual->registros+1
                    ]);

        if($this->estudiante){
            $this->cargaAsistencia($this->asistencias->id, $titulo);
        }else{
            $this->cargarActual();
            $this->dispatch('alerta', name:'La fecha ha sido cargada, incluya asistencias');
        }

    }



    public function cargaAsistencia($asis=null,$campo=null,$alumno=null){

        DB::table('asistencia_detalle')
            ->where('id', $asis)
            ->update([
                $campo          =>"X",
                'updated_at'    =>now()
            ]);

        $this->cargarActual();


        $fecha=$this->actual->$campo;

        //Registrar control
        Control::where('estudiante_id', $alumno)
                ->where('status', true)
                ->update([
                    'ultima_asistencia'=>$fecha,
                ]);
    }

    public function exportar(){
        return new AcaAsistenciaExport($this->actual->id, $this->xls);
    }

    public function render()
    {
        return view('livewire.academico.asistencia.asisgestion');
    }
}
