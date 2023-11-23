<?php

namespace App\Livewire\Academico\Ciclo;

use App\Models\Academico\Ciclo;
use App\Models\Academico\Curso;
use App\Models\Academico\Grupo;
use App\Models\Configuracion\Sede;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CiclosCrear extends Component
{
    public $sede_id;
    public $curso_id;
    public $curso;
    public $grupos=[];
    public $seleccionados=[];
    public $name;
    public $inicia;
    public $finaliza;
    public $finalizaej;
    public $jornada;
    public $desertado;
    public $contar=0;
    public $maximo;

    public $fechaRegistro;

    public function mount(){
        $this->fechaRegistro=Carbon::now()->subDays(3);
    }


    public function updatedCursoId(){

        $this->reset('grupos', 'seleccionados', 'curso', 'contar', 'jornada');

        $this->curso=Curso::find($this->curso_id);

        $this->maximo=$this->curso->modulos->count();

        foreach ($this->curso->modulos as $value) {

            $grupo=Grupo::where('modulo_id', $value->id)
                        ->where('sede_id', $this->sede_id)
                        ->where('status', true)
                        ->get();

            if($grupo->count()>0){

                foreach ($grupo as $value) {
                    $nuevo=[
                        'id'            =>$value->id,
                        'name'          =>$value->name,
                        'profesor_id'   =>$value->profesor_id,
                        'profesor'      =>$value->profesor->name,
                        'inscritos'     =>$value->inscritos,
                        'limit'         =>$value->quantity_limit
                    ];

                    if(in_array($nuevo, $this->grupos)){

                    }else{
                        array_push($this->grupos, $nuevo);
                    }
                }

            }else{
                $this->contar=$this->contar+1;
            }


        }

        if($this->contar>0){
            $this->dispatch('alerta', name:'No hay grupos para el curso: '.$this->curso->name.', generelos antes.');
        }

    }

    public function updatedInicia(){

        $ini=new Carbon($this->inicia);
        $fin=$ini->addMonths($this->curso->duracion_meses);
        $fin->format('Y-m-d');
        $this->finalizaej=$fin;
    }

    public function updatedJornada(){
        if($this->jornada<4){
            $this->desertado=config('instituto.desertado_entresemana');
        }else{
            $this->desertado=config('instituto.desertado_fin');
        }
    }

    public function selGrupo($id){

        if(count($this->seleccionados) < $this->maximo){
            foreach ($this->grupos as $grupo) {
                if($grupo['id']===$id){
                    $nuevo=[
                        'id'            =>$grupo['id'],
                        'name'          =>$grupo['name'],
                        'profesor_id'   =>$grupo['profesor_id'],
                        'profesor'      =>$grupo['profesor'],
                        'inscritos'     =>$grupo['inscritos'],
                        'limit'         =>$grupo['limit']
                    ];

                    if(in_array($nuevo, $this->seleccionados)){

                    }else{
                        array_push($this->seleccionados, $nuevo);
                    }
                }
            }
        }else{
            $this->dispatch('alerta', name:'Recuerde que se registra un grupo por Modulo');
        }


    }

    public function elimGrupo($id){
        foreach ($this->seleccionados as $grupo) {
            if($grupo['id']===$id){

                $nuevo=[
                    'id'            =>$grupo['id'],
                    'name'          =>$grupo['name'],
                    'profesor_id'   =>$grupo['profesor_id'],
                    'profesor'      =>$grupo['profesor'],
                    'inscritos'     =>$grupo['inscritos'],
                    'limit'         =>$grupo['limit']
                ];

                $indice=array_search($nuevo,$this->seleccionados,true);
                unset($this->seleccionados[$indice]);
            }
        }
    }

    /**
     * Reglas de validación
     */
    protected $rules = [
        'sede_id'=>'required|integer',
        'curso_id'=>'required|integer',
        'name' => 'required|max:100',
        'inicia'=>'required|date|after:fechaRegistro',
        'finaliza'=>'required|date',
        'jornada'=>'required|integer',
        'desertado'=>'required'
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
                        'sede_id',
                        'curso_id',
                        'name',
                        'inicia',
                        'finaliza',
                        'jornada',
                        'desertado'
                    );
    }

    // Crear
    public function new(){

        // validate
        $this->validate();

        if($this->inicia<$this->finaliza){
            //Crear ciclo
            $ciclo=Ciclo::create([
                'sede_id'       =>$this->sede_id,
                'curso_id'      =>$this->curso_id,
                'name'          =>$this->name,
                'inicia'        =>$this->inicia,
                'finaliza'      =>$this->finaliza,
                'jornada'       =>$this->jornada,
                'desertado'     =>$this->desertado
            ]);

            foreach ($this->seleccionados as $value) {
                DB::table('ciclo_grupo')
                    ->insert([
                        'ciclo_id'       =>$ciclo->id,
                        'grupo_id'       =>$value['id'],
                        'created_at'     =>now(),
                        'updated_at'     =>now(),
                    ]);
            }

            // Notificación
            $this->dispatch('alerta', name:'Se ha creado correctamente el ciclo: '.$this->name);
            $this->resetFields();

            //refresh
            $this->dispatch('refresh');
            $this->dispatch('created');
        }else{
            $this->dispatch('alerta', name:'La fecha de inicio debe ser inferior a la de finalización');
        }




    }

    private function cursos()
    {
        return Curso::where('status', true)
                    ->orderBy('name')
                    ->get();
    }

    private function sedes(){
        return Sede::where('status', true)
                    ->orderBy('name')
                    ->get();
    }

    public function render()
    {
        return view('livewire.academico.ciclo.ciclos-crear',[
            'cursos'=>$this->cursos(),
            'sedes'=>$this->sedes(),
        ]);
    }
}
