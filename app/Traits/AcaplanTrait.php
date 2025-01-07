<?php

namespace App\Traits;

use App\Models\Academico\Acaplan;
use App\Models\Academico\Cronodeta;
use App\Models\Academico\Cronograma;
use App\Models\Academico\Unidade;
use App\Models\Academico\Unidtema;
use App\Models\Academico\Acaplandeta;

trait AcaplanTrait
{
    public $plan;

    public function plancrea($ciclo,$grupo){
        $crono=Cronograma::where('ciclo_id',$ciclo)
                            ->where('grupo_id',$grupo)
                            ->select('id')
                            ->first();

        $fechas = Cronodeta::where('cronograma_id', $crono->id)
                            ->selectRaw('MAX(fecha_programada) as fin, MIN(fecha_programada) as inicio')
                            ->first();

        if($fechas){
            $this->plan=Acaplan::create([
                'ciclo_id'  => $ciclo,
                'grupo_id'  => $grupo,
                'fecha_inicio'  => $fechas->inicio,
                'fecha_fin' => $fechas->fin,
            ]);
        }else{
            $this->plan=Acaplan::create([
                'ciclo_id'  => $ciclo,
                'grupo_id'  => $grupo,
                'fecha_inicio'  => $crono->fecha_final,
                'fecha_fin' => $crono->fecha_final,
            ]);
        }


        $this->cargadetalles();
    }

    public function cargadetalles(){

        $modulo=$this->plan->grupo->modulo_id;
        $unidades=Unidade::where('modulo_id',$modulo)
                        ->select('id')
                        ->get();

        if($unidades){
            foreach ($unidades as $value) {
                $this->temas($value->id);
            }
        }

    }

    public function temas($id){
        $temas=Unidtema::where('unidade_id',$id)
                        ->select('id','duracion')
                        ->get();

        foreach ($temas as $value) {
            Acaplandeta::create([
                            'acaplan_id' => $this->plan->id,
                            'unidtema_id' => $value->id,
                            'horas_teoricas' => $value->duracion,
                            'horas_practicas' => $value->duracion,
                        ]);
        }

    }
}
