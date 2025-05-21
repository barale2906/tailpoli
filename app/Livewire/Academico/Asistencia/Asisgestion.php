<?php

namespace App\Livewire\Academico\Asistencia;

use App\Exports\AcaAsistenciaExport;
use App\Models\Academico\Asistencia;
use App\Models\Academico\Control;
use App\Models\Academico\Grupo;
use App\Models\Clientes\Pqrs;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Asisgestion extends Component
{
    public $grupo_id;
    public $grupo;
    public $ciclo;
    public $estudiante;
    public $fecha;
    public $actual;
    public $clases;
    public $asist=array();
    public $asistencias;
    public $encabezado=[];
    public $encabid=[];
    public $xls=[];
    public $hoy;
    public $margen;

    public function mount($ciclo, $elegido=null, $estudiante_id=null){

        $this->ciclo=$ciclo;
        $this->grupo_id=$elegido;
        $this->hoy=Carbon::today();
        $margen=config('instituto.desertado_fin'); //Control de deserción
        $this->margen=Carbon::today()->subDays($margen); //tIEMPO DE ASISTENCIA
        $this->grupo=Grupo::find($elegido);
        if($estudiante_id){
            $this->estudiante=User::find($estudiante_id);
        }
        $this->cargarActual();
    }

    public function cargarActual(){

        $this->reset('asist');

        $esta=Asistencia::where('profesor_id', $this->grupo->profesor_id)
                        ->where('grupo_id', $this->grupo->id)
                        //->where('ciclo_id', $this->ciclo)
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
            'ciclo_id'      => $this->ciclo,
            'registros'     => 0
        ]);

        $this->cargarEstudiantes();
    }

    public function cargarEstudiantes(){

        $alumnos = User::query()
            ->select('id', 'name')
            ->when($this->grupo_id, function($query) {
                return $query->where('status', true)
                    ->whereHas('alumnosGrupo', function($q) {
                        $q->where('grupo_id', $this->grupo_id)
                            ->select('grupo_id', 'user_id');
                    });
            })
            ->with(['alumnosGrupo' => function($query) {
                $query->where('grupo_id', $this->grupo_id)
                        ->select('grupo_id', 'user_id');
            }])
            ->orderBy('name')
            ->get();

        foreach ($alumnos as $value) {
            $esta=DB::table('asistencia_detalle')
                        //->where('asistencia_id', $this->actual->id)
                        ->where('grupo_id', $this->actual->grupo_id)
                        ->where('alumno_id', $value->id)
                        ->count();

            if($esta===0){
                $this->cargaEstudiante($value);
            }
        }



        $this->registroAsistencias();
    }

    public function cargaEstudiante($estu){

        $esciclo=Control::where('estudiante_id', $estu->id)
                            ->where('ciclo_id', $this->ciclo)
                            ->count();
        if($esciclo>0){
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

    }

    public function registroAsistencias(){

        $this->reset('asistencias', 'encabezado', 'xls','encabid');

        if($this->estudiante){
            $this->asistencias=DB::table('asistencia_detalle')
                                    //->where('status', true)
                                    ->where('asistencia_id', $this->actual->id)
                                    ->where('alumno_id', $this->estudiante->id)
                                    ->orderBy('alumno')
                                    ->first();
        }else{
            $this->asistencias=DB::table('asistencia_detalle')
                                    //->where('status', true)
                                    //->where('asistencia_id', $this->actual->id)
                                    ->where('grupo_id', $this->actual->grupo_id)
                                    ->orderBy('alumno')
                                    ->get();
        }


        $this->formaencabezado();
    }

    public function formaencabezado(){

        $this->reset('xls');
        array_push($this->xls, "Alumno");

        if($this->actual->registros>0){

            $this->clases=DB::table('asistencia_registro')
                        ->where('asistencia_id', $this->actual->id)
                        ->orderBy('fecha_clase', 'DESC')
                        ->get();

            foreach ($this->clases as $value) {
                array_push($this->encabezado, $value->fecha_clase);
                array_push($this->xls, $value->fecha_clase);
                array_push($this->encabid, $value->id);
            }
        }

        $this->lista();

    }

    public function lista(){

        if($this->estudiante){
            $this->genera($this->asistencias);
        }else{
            foreach ($this->asistencias as $value) {
                $this->genera($value);
            }
        }
    }

    public function genera($asistencia){

        // Primero verificamos si el alumno ya existe en $this->asist
        foreach ($this->asist as $registro) {
            if ($registro[1] === $asistencia->alumno_id) { // El índice 1 contiene el alumno_id
                return; // Si ya existe, salimos de la función
            }
        }

    // Si no existe, continuamos con el código original
        $as=array();

        array_push($as, $asistencia->id);
        array_push($as, $asistencia->alumno_id);
        array_push($as, $asistencia->alumno);

        $a=0;
        while ($a < count($this->encabid)) {
            array_push($as, $this->encabid[$a]);
            $a++;
        }

        $asistio=DB::table('asistencia_detalle_registro')
                    ->where('asistencia_detalle_id', $asistencia->id)
                    ->orderBy('registro_asistencia_id', 'DESC')
                    ->get();

        if($asistio){
            foreach ($asistio as $value) {
                $ubica=array_search($value->registro_asistencia_id, $as);
                $reemplazo=array($ubica => "X");
                $as=array_replace($as,$reemplazo);
            }
        }
        array_push($this->asist,$as);
    }

    public function registro(){

        $this->cargarActual();
        $esta=DB::table('asistencia_registro')
                    ->where('asistencia_id', $this->actual->id)
                    ->where('fecha_clase', $this->fecha)
                    ->count();

        if($esta>0){
            $this->dispatch('alerta', name:'La fecha ya esta cargada, incluya asistencias');
        }else{
            $this->asistenciaEncabezado();
        }
    }

    public function asistenciaEncabezado(){

        $this->actual->update([
            'registros'     =>$this->actual->registros+1
        ]);

        //Crgar fecha
        DB::table('asistencia_registro')
            ->insert([
                'asistencia_id' => $this->actual->id,
                'fecha_clase'   => $this->fecha,
                'created_at'    => now(),
                'updated_at'    => now()
            ]);

        $this->cargarActual();
        $this->reset('fecha');
        $this->dispatch('alerta', name:'La fecha ha sido cargada, incluya asistencias');

    }


    public function cargaAsistencia($detalle,$alumno_id,$registroasiste=null){

        $registro=DB::table('asistencia_registro')
                    ->where('id',$registroasiste)
                    ->orderBy('fecha_clase','DESC')
                    ->first();

        if($detalle){
            $idcontrol=$detalle;
        }else{
            $existe=DB::table('asistencia_detalle')
                        ->where('alumno_id',$alumno_id)
                        ->where('grupo_id',$this->actual->grupo_id)
                        ->first();
            $idcontrol=$existe->id;
        }

        //Verificar la carga
        $esta=DB::table('asistencia_detalle_registro')
                    ->where('asistencia_detalle_id',$idcontrol)
                    ->where('registro_asistencia_id',$registro->id)
                    ->where('fecha_asis',$registro->fecha_clase)
                    ->count('id');

        if($esta===0){
            DB::table('asistencia_detalle_registro')
            ->insert([
                'asistencia_detalle_id'     => $idcontrol,
                'fecha_asis'                => $registro->fecha_clase,
                'registro_asistencia_id'    => $registro->id,
                'created_at'                => now(),
                'updated_at'                => now()
            ]);

            //Registrar control
            $crt=Control::where('estudiante_id', $alumno_id)
                            ->where('status', true)
                            ->where('ciclo_id', $this->ciclo)
                            ->first();

            //Verificar si la fecha es menor a la ya registrada
            if($crt && $crt->ultima_asistencia !== null){
                if($crt->ultima_asistencia < $registro->fecha_clase){
                    $crt->update([
                        'ultima_asistencia'=>$registro->fecha_clase,
                    ]);
                }
            }else{
                if($crt){
                    $crt->update([
                        'ultima_asistencia'=>$registro->fecha_clase,
                    ]);
                }else{
                    $this->dispatch('alerta', name:'Estudiante antiguo, no tiene Control');
                }
            }

            if($crt && $registro->fecha_clase>=$this->margen){

                if($crt->status_est===7 || $crt->status_est===9){
                    $crt->update([
                        'status_est'=>1
                    ]);
                }

                if($crt->status_est===3){
                    $crt->update([
                        'status_est'=>7
                    ]);
                }

            }

            Pqrs::create([
                'estudiante_id' =>$alumno_id,
                'gestion_id'    =>Auth::user()->id,
                'fecha'         =>now(),
                'tipo'          =>1,
                'observaciones' =>'GESTIÓN: Se carga Asistencia del: '.$registro->fecha_clase.' ----- ',
                'status'        =>4
            ]);

            $this->cargarActual();
        }

    }

    public function exportar(){
        return new AcaAsistenciaExport($this->actual->id, $this->xls,$this->asist,$this->grupo->name);
    }

    public function render()
    {
        return view('livewire.academico.asistencia.asisgestion');
    }
}
