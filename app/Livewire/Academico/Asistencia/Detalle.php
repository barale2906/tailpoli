<?php

namespace App\Livewire\Academico\Asistencia;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Detalle extends Component
{
    public $encabezados=[];
    public $asistencias;
    public $grupo;

    public function mount($asistencia,$grupo,$detalle){
        $this->grupo=$grupo;
        //Obtener las fechas de clase de cada grupo
        $this->encab($asistencia);

        //Obtener las asistencias por cada grupo
        $this->asist($detalle);
    }

    public function encab($asistencia){
        $asist=DB::table('asistencia_registro')
                    ->where('asistencia_id',$asistencia)
                    ->orderBy('fecha_clase','ASC')
                    ->get();

        foreach ($asist as $value) {
            array_push($this->encabezados,$value->fecha_clase);
        }
    }
    public function asist($detalle){

        $this->asistencias=DB::table('asistencia_detalle_registro')
                                ->where('asistencia_detalle_id',$detalle)
                                ->orderBy('fecha_asis','ASC')
                                ->get();

    }

    public function render()
    {
        return view('livewire.academico.asistencia.detalle');
    }
}
