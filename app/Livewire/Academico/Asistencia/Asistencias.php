<?php

namespace App\Livewire\Academico\Asistencia;

use App\Exports\AcaAsistenciaExport;
use App\Models\Academico\Asistencia;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Asistencias extends Component
{
    public $actual;
    public $fecha;
    public $fechap;
    public $asistencias;
    public $grupo_id;
    public $profesor_id;
    public $encabezado=[];
    public $xls=[];
    public $alumnosPrime;
    public $llegaron=[];
    public $contador=0;
    public $dia=false;
    public $titulo;

    public function primerAlumno($item){
        $nuevo=[
            'id' => $item['id'],
            'name'=>$item['name']
        ];

        if(in_array($nuevo, $this->llegaron)){
            $this->dispatch('alerta', name:'Ya esta cargado');
        }else{
            array_push($this->llegaron, $nuevo);
            $this->dispatch('alerta', name:'Asisitio');
        }

    }

    public function updatedFechap(){
        $esta=0;

        foreach ($this->encabezado as $value) {
            if($this->actual->$value===$this->fechap){
                $esta=1;
            }
        }

        if($esta>0){
            $this->dispatch('alerta', name:'Ya cargo esta fecha');
        }else{
            $this->contador=$this->contador+1;
            $this->asistenciaEncabezado();
        }
    }

    public function asistenciaEncabezado(){

        $this->titulo="fecha".$this->contador;
        Asistencia::whereId($this->actual->id)
                    ->update([
                        $this->titulo   =>$this->fechap,
                        'registros'     =>$this->contador
                    ]);

        $this->dia=!$this->dia;
    }

    public function AsistenciaCorriente($item){

        DB::table('asistencia_detalle')
                ->where('id', $item)
                ->update([
                    $this->titulo   =>"X",
                    'updated_at'    =>now()
                ]);

        $this->reset('encabezado');

        if($this->contador>0){
            $a=$this->contador;
            for ($i=1; $i <= $this->contador; $i++) {

                $fecha="fecha".$a;
                $a--;

                array_push($this->encabezado, $fecha);
            }
        }

        $this->registroAsistencias();
    }

    public function primero(){

        $this->actual=Asistencia::create([
            'profesor_id'       => $this->profesor_id,
            'grupo_id'          => $this->grupo_id,
            'registros'         => 1,
            'fecha1'            => $this->fecha,
        ]);

        $this->cargaPrimero();
    }

    public function cargaPrimero(){
        foreach ($this->llegaron as $value) {
            DB::table('asistencia_detalle')
            ->insert([
                'asistencia_id' =>$this->actual->id,
                'alumno_id'     =>$value['id'],
                'alumno'        =>$value['name'],
                'profesor_id'   =>$this->profesor_id,
                'profesor'      =>$this->actual->profesor->name,
                'grupo_id'      =>$this->grupo_id,
                'grupo'         =>$this->actual->grupo->name,
                'fecha1'        =>"X",
                'created_at'    =>now(),
                'updated_at'    =>now()
            ]);
        }

        $this->reset('fecha', 'llegaron');

        $this->formaencabezado();
    }


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
                $a=$this->contador;
                for ($i=1; $i <= $this->contador; $i++) {

                    $fecha="fecha".$a;
                    $a--;

                    array_push($this->encabezado, $fecha);
                }
            }

            $this->cargarEstudiantes();
        }else{
            $this->dispatch('alerta', name:'Debe Crear Primer Fecha de Registro');
            $this->alumnosPrime=User::query()
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
        }

        $this->encabezadoExcel();
    }

    public function encabezadoExcel(){
        $this->reset('xls');
        array_push($this->xls, "grupo");
        array_push($this->xls, "profesor");
        array_push($this->xls, "alumno");

        foreach ($this->encabezado as $value) {
            $item = $this->actual->$value;
            array_push($this->xls, $item);
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

    public function exportar(){
        return new AcaAsistenciaExport($this->actual->id, $this->xls);
    }

    public function registroAsistencias(){

        $this->contador=$this->actual->registros;

        $this->asistencias=DB::table('asistencia_detalle')
                        ->where('asistencia_id', $this->actual->id)
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
