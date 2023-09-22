<?php

namespace App\Livewire\Academico\Matricula;

use App\Models\Academico\Matricula;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MatriculasCrear extends Component
{
    public $medio = '';
    public $nivel = '';
    public $valor='';
    public $metodo='';
    public $alumno_id='';
    public $alumnoName='';
    public $alumnodocumento='';
    public $comercial_id='';

    public $buscar=null;
    public $buscaestudi='';

    public $buscaGrupo=null;
    public $busgrupito='';

    //Buscar Alumno
    public function buscAlumno(){
        $this->buscaestudi=strtolower($this->buscar);
    }

    //Buscar Alumno
    public function buscGrupo(){
        $this->busgrupito=strtolower($this->buscaGrupo);
    }

    //Limpiar variables
    public function limpiar(){
        $this->reset('buscaGrupo', 'buscar');
    }

    public function selAlumno($item){
        $this->alumno_id=$item['id'];
        $this->alumnoName=$item['name'];
        $this->alumnodocumento=$item['documento'];
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

        //Verificar que no exista el registro en la base de datos
        $existe=Matricula::Where('alumno_id', '=', $this->alumno_id)->count();

        if($existe>0){
            $this->dispatch('alerta', name:'Ya está matriculado a este curso: '.$this->name);
        } else {
            //Crear registro
            Matricula::create([
                'medio'=>$this->medio,
                'nivel'=>$this->nivel,
                'valor'=>$this->valor,
                'metodo'=>$this->metodo,
                'alumno_id'=>$this->alumno_id,
                'comercial_id'=>$this->comercial_id,
                'creador_id'=>Auth::user()->id
            ]);

            // Notificación
            $this->dispatch('alerta', name:'Se ha creado correctamente la matricula.');
            $this->resetFields();

            //refresh
            $this->dispatch('refresh');
            $this->dispatch('created');
        }
    }

    private function estudiantes(){
        return User::where('status', true)
                        ->where('name', 'like', "%".$this->buscaestudi."%")
                        ->orWhere('name', 'like', "%".$this->buscaestudi."%")
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

    public function render()
    {
        return view('livewire.academico.matricula.matriculas-crear', [
            'estudiantes'=>$this->estudiantes(),
            'noestudiantes'=>$this->noestudiantes(),
        ]);
    }
}
