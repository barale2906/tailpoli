<?php

namespace App\Livewire\Academico\Matricula;

use App\Models\Academico\Curso;
use App\Models\Academico\Grupo;
use App\Models\Academico\Matricula;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class MatriculasAsigna extends Component
{
    public $matricula;
    public $curso;
    public $disponibles=[];
    public $grupos=[];
    public $modulos=[];
    public $id;

    public function mount($elegido = null)
    {
        $this->id=$elegido['id'];
        $this->matricula=Matricula::find($elegido['id']);
        $this->curso=Curso::find($elegido['curso_id']);
        $this->modulos=DB::table('matricula_modulos_aprobacion')
                            ->where('matricula_id', $elegido['id'])
                            ->where('alumno_id', $elegido['alumno_id'])
                            ->get();

        $this->buscaGrupos();
    }

    //obtener grupos para la matricula según modulos
    public function buscaGrupos(){

        $hoy=now();
        foreach ($this->modulos as $value) {

            $grupos=Grupo::where('status', true)
                                    ->where('sede_id', $this->matricula->sede_id)
                                    ->where('modulo_id', $value->modulo_id)
                                    ->where('finish_date', '>=', $hoy)
                                    ->orderBy('name')
                                    ->get();


            if($grupos->count()>0){
                foreach ($grupos as $value) {
                    $nuevo=[
                        'id'            =>$value->id,
                        'name'          =>$value->name,
                        'modulo'        =>$value->modulo->name,
                        'modulo_id'     =>$value->modulo->id,
                        'dependencia'   =>$value->modulo->dependencia,
                        'finish_date'   =>$value->finish_date,
                        'inscritos'     =>$value->inscritos
                    ];

                    if(in_array($nuevo, $this->disponibles)){

                    }else{
                        array_push($this->disponibles, $nuevo);
                    }
                }
            }
        }

        $this->yaMatriculado();
    }

    //eliminar grupos a donde este matriculado ya
    public function yaMatriculado(){
        foreach ($this->disponibles as $value) {
            $esta=DB::table('grupo_matricula')
                    ->where('grupo_id', $value['id'])
                    ->where('matricula_id', $this->matricula->id,)
                    ->count();

            if($esta>0){
                $nuevo=[
                    'id'            =>$value['id'],
                    'name'          =>$value['name'],
                    'modulo'        =>$value['modulo'],
                    'modulo_id'     =>$value['modulo_id'],
                    'dependencia'   =>$value['dependencia'],
                    'finish_date'   =>$value['finish_date'],
                    'inscritos'     =>$value['inscritos']
                ];

                if(in_array($nuevo, $this->disponibles)){
                    $indice=array_search($nuevo,$this->disponibles,true);
                    unset($this->disponibles[$indice]);
                }
            }
        }

        $this->dependencias();
    }

    // Definir restricciones de dependencia
    public function dependencias(){

        foreach ($this->disponibles as $value){

            /* $aprobo=DB::table('matricula_modulos_aprobacion')
                        ->where('modulo_id', $value['modulo_id'])
                        ->where('matricula_id', $this->matricula->id)
                        ->first(); */

            if(!$value['dependencia']){

            }else{
                $this->cumple($value);
            }
        }

    }

    //Verifica cumplimiento de dependencias
    public function cumple($item){

        $registros=DB::table('modulos_dependencias')
                        ->join('matricula_modulos_aprobacion', 'modulos_dependencias.modulodep_id', '=', 'matricula_modulos_aprobacion.modulo_id')
                        ->where('modulos_dependencias.modulo_id', $item['modulo_id'])
                        ->get();


        foreach ($registros as $value) {

            if(!$value->aprobo){
                $nuevo=[
                    'id'            =>$item['id'],
                    'name'          =>$item['name'],
                    'modulo'        =>$item['modulo'],
                    'modulo_id'     =>$item['modulo_id'],
                    'dependencia'   =>$item['dependencia'],
                    'finish_date'   =>$item['finish_date'],
                    'inscritos'     =>$item['inscritos']
                ];

                if(in_array($nuevo, $this->disponibles)){
                    $indice=array_search($nuevo,$this->disponibles,true);
                    unset($this->disponibles[$indice]);
                }
            }
        }
    }




    //Elegir los modulos incluidos
    public function selGrupo($id){

        foreach ($this->disponibles as $value) {

            if($value['id']===$id){
                $nuevo=[
                    'id'=>$id,
                    'name'=>$value['name'],
                    'inscritos'=>$value['inscritos']
                ];

                if(in_array($nuevo, $this->grupos)){

                }else{
                    array_push($this->grupos, $nuevo);
                }

            };

        }
    }

    // Eliminar modulo elegido
    public function elimGrupo($id){
        foreach ($this->grupos as $value) {
            if($value['id']===$id){
                $nuevo=[
                    'id'=>$id,
                    'name'=>$value['name'],
                    'inscritos'=>$value['inscritos']
                ];
            }
        }
        $indice=array_search($nuevo,$this->grupos,true);
        unset($this->grupos[$indice]);
    }

    //Asignar grupos al estudiante
    public function asignar(){

        foreach ($this->grupos as $value) {
            $ya=DB::table('grupo_matricula')
                    ->where('grupo_id', $value['id'])
                    ->where('matricula_id', $this->matricula->id)
                    ->first();

            if(empty($ya)){

                DB::table('grupo_matricula')
                    ->insert([
                        'grupo_id'      =>$value['id'],
                        'matricula_id'  =>$this->matricula->id,
                        'created_at'    =>now(),
                        'updated_at'    =>now(),
                    ]);

                //Sumar usuario
                $inscritos=Grupo::find($value['id']);

                $tot=$inscritos->inscritos+1;

                $inscritos->update([
                    'inscritos'=>$tot
                ]);
            }
        }



        $this->dispatch('alerta', name:'Se han asignado los grupos correctamente.');

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('grupos');
    }

    public function render()
    {
        return view('livewire.academico.matricula.matriculas-asigna');
    }
}
