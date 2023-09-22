<?php

namespace App\Livewire\Academico\Matricula;

use App\Models\Academico\Grupo;
use App\Models\Academico\Matricula;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class MatriculasCrear extends Component
{
    use WithPagination;

    public $medio = '';
    public $nivel = '';
    public $valor='';
    public $metodo='';
    public $alumno_id='';
    public $alumnoName='';
    public $alumnodocumento='';
    public $comercial_id='';
    public $grupos=[];
    public $grupoNombre=[];
    public $seleccionado=false;

    public $buscar=null;
    public $buscaestudi='';

    public $buscaGrupo=null;
    public $buscamin='';
    public $matriculados;
    public $gruposAct=[];


    //Buscar Alumno
    public function buscAlumno(){
        $this->buscaestudi=strtolower($this->buscar);
    }

    //Buscar Alumno
    public function buscGrupo(){
        $this->buscamin=strtolower($this->buscaGrupo);
    }

    //Limpiar variables
    public function limpiar(){
        $this->reset('buscaGrupo', 'buscar');
    }

    public function selAlumno($item){
        $this->alumno_id=$item['id'];
        $this->alumnoName=$item['name'];
        $this->alumnodocumento=$item['documento'];
        $this->matrActual();
    }

    public function matrActual(){
        $this->matriculados = Matricula::where('status', true)
                                        ->where('alumno_id', $this->alumno_id)
                                        ->get();

        if($this->matriculados->count()){
            foreach ($this->matriculados as $value) {
                $this->grupoActual($value->id);
            }
        }
    }

    public function grupoActual($id){
        $gr = Matricula::find($id);
        foreach($gr->grupos as $value){
            array_push($this->gruposAct, $value->id);
        }
    }

    public function selGrupo($item){
        if(in_array($item['id'], $this->gruposAct)){
            $this->dispatch('alerta', name:'Ya esta matriculado al grupo: '.$item['name']);
        }else{
            $this->asigGrupo($item);
        }
    }

    public function asigGrupo($item){
        if(now()<$item['finish_date']){
            if(in_array([
                'id'=>$item['id'],
                'name'=>$item['name']
            ], $this->grupos))
            {

            }else{
                $nuevo=[
                    'id'=>$item['id'],
                    'name'=>$item['name']
                ];
                array_push($this->grupos,$nuevo);

                $this->seleccionado=true;
            }
        } else{
            $this->dispatch('alerta', name:'El grupo: '.$item['name'].' ya finalizó.');
        }
    }

    /**
     * Reglas de validación
     */
    protected $rules = [
        'medio' => 'required',
        'nivel'=>'required',
        'valor'=>'required',
        'metodo'=>'required',
        'alumno_id'=>'required|integer',
        'comercial_id'=>'required|integer',
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
                        'medio',
                        'nivel',
                        'valor',
                        'metodo',
                        'alumno_id',
                        'comercial_id'
                    );
    }

    // Crear Regimen de Salud
    public function new(){
        // validate
        $this->validate();

        //Crear registro
        $matricula = Matricula::create([
                                'medio'=>$this->medio,
                                'nivel'=>$this->nivel,
                                'valor'=>$this->valor,
                                'metodo'=>$this->metodo,
                                'alumno_id'=>$this->alumno_id,
                                'comercial_id'=>$this->comercial_id,
                                'creador_id'=>Auth::user()->id
                            ]);

        //Asignar Grupos
        foreach($this->grupos as $item){
            DB::table('grupo_matricula')
            ->insert([
                'grupo_id'=>$item['id'],
                'matricula_id'=>$matricula->id,
                'created_at'=>now(),
                'updated_at'=>now(),
            ]);
        }

        // Notificación
        $this->dispatch('alerta', name:'Se ha creado correctamente la matricula.');
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('created');

    }

    private function estudiantes(){
        return User::where('status', true)
                        ->where('name', 'like', "%".$this->buscaestudi."%")
                        ->orWhere('documento', 'like', "%".$this->buscaestudi."%")
                        ->orderBy('name')
                        ->with('roles')->get()->filter(
                            fn ($user) => $user->roles->where('name', 'Estudiante')->toArray()
                        );
    }

    private function noestudiantes(){
        return User::where('status', true)
                        ->orderBy('name')
                        ->with('roles')->get()->filter(
                            fn ($user) => $user->roles->where('name', '!=', 'Estudiante')->toArray()
                        );
    }

    private function grupost()
    {
        return Grupo::query()
                        ->with(['modulo', 'profesor'])
                        ->when($this->buscamin, function($query){
                            return $query->where('status', true)
                                    ->where('name', 'like', "%".$this->buscamin."%")
                                    ->orWhereHas('modulo', function($q){
                                        $q->where('name', 'like', "%".$this->buscamin."%");
                                    })
                                    ->orWhereHas('profesor', function($qu){
                                        $qu->where('name', 'like', "%".$this->buscamin."%");
                                    });
                        })
                        ->orderBy('id', 'DESC')
                        ->paginate(3);
    }

    public function render()
    {
        return view('livewire.academico.matricula.matriculas-crear', [
            'estudiantes'=>$this->estudiantes(),
            'noestudiantes'=>$this->noestudiantes(),
            'grupost'=> $this->grupost(),
        ]);
    }
}
