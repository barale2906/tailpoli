<?php

namespace App\Livewire\Academico\Grupo;

use App\Models\Academico\Curso;
use App\Models\Academico\Grupo;
use App\Models\Academico\Horario;
use App\Models\Academico\Modulo;
use App\Models\Configuracion\Area;
use App\Models\Configuracion\Sede;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class GruposCrear extends Component
{
    public $name;
    //public $start_date;
    //public $finish_date;
    public $quantity_limit;
    public $sede_id;
    public $sede;
    public $ocupacion;
    public $funcionamiento;
    public $profesor_id;
    public $modulo_id;
    public $modulos;
    public $curso_id;

    public $seleccionados=[];
    public $area_id;
    public $area;
    public $intensidad;
    public $dia;
    public $hora;
    public $horas_semanales=0;
    public $contador=0;
    public $conteo=0;
    public $abre;
    public $cierra;
    public $numerar=1;


    public function updatedCursoId(){
        $this->modulos=Modulo::where('status', true)
                            ->where('curso_id', $this->curso_id)
                            ->orderBy('name', 'ASC')
                            ->get();
    }

    public function updatedSedeId(){

        $this->sede=Sede::find($this->sede_id);

        $this->funcionamiento=Horario::where('sede_id', $this->sede_id)
                                        ->where('tipo', true)
                                        ->where('status', true)
                                        ->get();

        $this->ocupacion=Horario::where('sede_id', $this->sede_id)
                                    ->where('tipo', false)
                                    ->where('status', true)
                                    ->orderBy('hora', 'ASC')
                                    ->get();

    }

    public function updatedAreaId(){
        $this->area=Area::find($this->area_id);
    }

    public function updatedDia(){
        foreach ($this->funcionamiento as $value) {
            if($value->periodo && $value->dia===$this->dia){
                $this->abre=$value->hora;
            }
            if(!$value->periodo && $value->dia===$this->dia){
                $this->cierra=$value->hora;
            }
        }
    }

    //Cargar datos de horario para el grupo
    public function cargar(){

        $abre = new Carbon($this->abre);
        $cierra = new Carbon($this->cierra);
        $hora = new Carbon($this->hora);
        $termina = new Carbon($this->hora);
        $finclase = $termina->addHours($this->intensidad);

        if($hora >= $abre && $finclase <= $cierra){

            for ($i=0; $i < $this->intensidad; $i++) {

                $horad = new Carbon($this->hora);
                $finev = $horad->addHours($i);
                $horafin=$finev->roundMinutes(60)->format('H:i:s');


                $esta=Horario::where('sede_id', $this->sede_id)
                            ->where('area_id', $this->area_id)
                            ->where('dia', $this->dia)
                            ->where('tipo', false)
                            ->where('hora', $horafin)
                            ->count();

                if($esta>0){
                    $this->conteo=$this->conteo+$esta;
                }
            }

            if($this->conteo>0){
                $this->dispatch('alerta', name:'Revise el horario, área e intensidad horaria, ya esta registrado el valor o se traslapa con otro'.$this->conteo);
                $this->reset('conteo');
            }else{
                $this->reset('conteo');
                $this->cargaSele();
            }
        }else{
            $this->dispatch('alerta', name:'Revise el horario, fuera de horario para el día');
        }



    }

    public function cargaSele(){

        for ($i=0; $i < $this->intensidad; $i++) {

            $hora = new Carbon($this->hora);
            $finev = $hora->addHours($i);
            $horafin=$finev->roundMinutes(60)->format('H:i:s');

            $nuevo=[
                'id'        =>$this->numerar,
                'dia'       =>$this->dia,
                'hora'      =>$horafin,
                'area_id'   =>$this->area_id,
                'area'      =>$this->area->name
            ];

            if(in_array($nuevo, $this->seleccionados)){

            }else{
                array_push($this->seleccionados, $nuevo);
                $this->horas_semanales=$this->horas_semanales+1;
                $this->numerar=$this->numerar+1;
            }
        }

        $this->reset('hora', 'area_id', 'dia', 'intensidad');

    }

    // Eliminar horario
    public function elimHora($id){
        foreach ($this->seleccionados as $value) {
            if($value['id']===$id){
                $nuevo=[
                    'id'        =>$value['id'],
                    'dia'       =>$value['dia'],
                    'hora'      =>$value['hora'],
                    'area_id'   =>$value['area_id'],
                    'area'      =>$value['area']
                ];
            }
        }
        $indice=array_search($nuevo,$this->seleccionados,true);
        unset($this->seleccionados[$indice]);
        $this->horas_semanales=$this->horas_semanales-1;
    }

    /**
     * Reglas de validación
     */
    protected $rules = [
        'name' => 'required|max:100',
        //'start_date'=>'required',
        //'finish_date'=>'required',
        'quantity_limit'=>'required|integer',
        'sede_id'=>'required|integer',
        'modulo_id'=>'required|integer',
        'profesor_id'=>'required|integer',
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
                        'name',
                        //'start_date',
                        //'finish_date',
                        'quantity_limit',
                        'modulo_id',
                        'sede_id',
                        'profesor_id',
                        'hora',
                        'area_id',
                        'dia',
                        'intensidad'
                    );
    }

    // Crear Regimen de Salud
    public function new(){
        // validate
        $this->validate();

       //Crear registro
        $grupo= Grupo::create([
            'name'=>strtolower($this->name),
            //'start_date'        =>$this->start_date,
            //'finish_date'       =>$this->finish_date,
            'quantity_limit'    =>$this->quantity_limit,
            'modulo_id'         =>$this->modulo_id,
            'sede_id'           =>$this->sede_id,
            'profesor_id'       =>$this->profesor_id
            ]);

        //Cargar horarios
        foreach ($this->seleccionados as $value) {
        Horario::create([
        'sede_id'       =>$this->sede_id,
        'area_id'       =>$value['area_id'],
        'grupo'         =>$this->name,
        'grupo_id'      =>$grupo->id,
        'tipo'          =>false,
        'periodo'       =>true,
        'dia'           =>$value['dia'],
        'hora'          =>$value['hora'],
        ]);
        }


        // Notificación
        $this->dispatch('alerta', name:'Se ha creado correctamente el grupo: '.$this->name);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('created');
    }

    private function cursos()
    {
        return Curso::where('status', '=', true)
                    ->orderBy('name')
                    ->get();
    }

    private function sedes(){
        return Sede::where('status', true)
                    ->orderBy('name')
                    ->get();
    }

    private function profesores(){
        return User::where('status', true)
                    ->orderBy('name')
                    ->with('roles')->get()->filter(
                        fn ($user) => $user->roles->where('name', 'Profesor')->toArray()
                    );
    }

    public function render()
    {
        return view('livewire.academico.grupo.grupos-crear', [
            'cursos'   => $this->cursos(),
            'sedes'      => $this->sedes(),
            'profesores'=> $this->profesores()
        ]);
    }
}
