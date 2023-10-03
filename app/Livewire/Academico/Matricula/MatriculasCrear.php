<?php

namespace App\Livewire\Academico\Matricula;

use App\Models\Academico\Curso;
use App\Models\Academico\Grupo;
use App\Models\Academico\Matricula;
use App\Models\Academico\Modulo;
use App\Models\Configuracion\Sede;
use App\Models\Financiera\Cartera;
use App\Models\Financiera\ConfiguracionPago;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class MatriculasCrear extends Component
{
    use WithPagination;

    public $medio = '';
    public $nivel = '';
    public $metodo;
    public $alumno_id='';
    public $alumnoName='';
    public $alumnodocumento='';
    public $comercial_id='';
    public $grupos=[]; //Grupos seleccionados
    public $seleccionado=false;

    public $sede_id;
    public $cursos;
    public $curso_id;
    public $cursoName;
    public $config_id;
    public $configElegida;
    public $configPago;
    public $modulos;

    public $valor_curso;
    public $valor_matricula;
    public $valor_cuota;
    public $valor_cuota_inicial;
    public $cuotas;

    public $grupocurso=[];


    public $buscar=null;
    public $buscaestudi='';

    public $buscamin='';
    public $matriculados;
    public $gruposAct=[];



    //Cursos por sede
    public function cursosede(){
        $this->reset('curso_id');
        $this->cursos=Curso::query()
                            ->with(['configpagos'])
                            ->when($this->sede_id, function($query){
                                return $query->where('status', true)
                                        ->WhereHas('configpagos', function($q){
                                            $q->where('sede_id', $this->sede_id);
                                        });
                                })
                            ->orderBy('name')
                            ->get();
    }

    //Configuraciones por curso
    public function buscaconfiguraciones(){
        $this->reset('config_id');
        $this->configPago=ConfiguracionPago::where('sede_id', $this->sede_id)
                                            ->where('curso_id', $this->curso_id)
                                            ->orderBy('descripcion')
                                            ->get();
    }

    //Buscar grupos aplicables al curso
    public function buscaModulos(){
        $this->reset(
            'modulos'
        );

        //Buscar modulos del curso

        $this->modulos=Modulo::where('curso_id', $this->curso_id)
                        ->where('status', true)
                        ->orderBy('name')
                        ->get();       
        

        $this->buscaGrupos();
    }

    public function buscaGrupos(){
        $this->reset(
            'valor_curso',
            'valor_matricula',
            'valor_cuota_inicial',
            'cuota',
            'valor_cuota',
            'grupocurso'
        );
        //Cargar datos de pago
        $pagos=ConfiguracionPago::find($this->config_id);

        $this->valor_curso=$pagos->valor_curso;
        $this->valor_matricula=$pagos->valor_matricula;
        $this->valor_cuota_inicial=$pagos->valor_cuota_inicial;
        $this->cuotas=$pagos->cuotas;
        $this->valor_cuota=$pagos->valor_cuota;

        foreach ($this->modulos as $value){
            $paquete=Grupo::where('status', true)
                            ->where('modulo_id', $value['id'])
                            ->where('sede_id', $this->sede_id)
                            ->orderBy('name')
                            ->get();

            if($paquete->count()){
                foreach ($paquete as $item) {
                    $nuevo=[
                        'id'=>$item['id'],
                        'name'=>$item['name'],
                        'profesor'=>$item->profesor['name'],
                        'modulo'=>$item->modulo['name']
                    ];
                    array_push($this->grupocurso,$nuevo);
                }
            }
        }
    }


    //Buscar Alumno
    public function buscAlumno(){
        $this->buscaestudi=strtolower($this->buscar);
    }

    //Limpiar variables
    public function limpiar(){
        $this->reset('buscar');
    }

    public function selAlumno($item){
        $this->alumno_id=$item['id'];
        $this->alumnoName=$item['name'];
        $this->alumnodocumento=$item['documento'];
        $this->matrActual();
    }
    //Determinar matriculas activas del estudiante
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

    //Cargar grupos a los que esta matriculado el estudiante
    public function grupoActual($id){
        $gr = Matricula::find($id);
        foreach($gr->grupos as $value){
            array_push($this->gruposAct, $value->id);
        }
    }

    //Determinar si el estudiante ya esta registrado en el grupo
    public function selGrupo($id){

        if(in_array($id, $this->gruposAct)){
            $this->dispatch('alerta', name:'Ya esta matriculado al grupo.');
        }else{
            foreach ($this->grupocurso as $value) {
                if($id===$value['id']){
                    $nuevo=[
                        'id'=>$id,
                        'name'=>$value['name']
                    ];

                    if(in_array($nuevo, $this->grupos)){

                    }else{
                        array_push($this->grupos,$nuevo);
                        $this->seleccionado=true;
                    }
                }
            }

        }
    }
    //Cargar al estudiante al grupo respectivo
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
        'valor_curso'=>'required',
        'valor_matricula'=>'required',
        'valor_cuota_inicial'=>'required',
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

        $curso=Curso::find($this->curso_id);
        $this->cursoName=$curso->name;

        $date = Carbon::now();
        //Crear registro
        $matricula = Matricula::create([
                                'medio'=>$this->medio,
                                'nivel'=>$this->nivel,
                                'valor'=>$this->valor_curso,
                                'metodo'=>$this->metodo,
                                'curso_id'=>$this->curso_id,
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

            //Sumar estudiante al grupo
            $inscrito=Grupo::where('id', $item['id'])
                            ->select('inscritos')
                            ->first();

            $ins=$inscrito->inscritos+1;

            Grupo::whereId($item['id'])->update([
                'inscritos'=>$ins
            ]);
        }
       

        //Inicial
        Cartera::create([
            'fecha_pago'=>now(),
            'valor'=>$this->valor_cuota_inicial,
            'saldo'=>$this->valor_cuota_inicial,
            'observaciones'=>'Curso: '.$this->cursoName.'. Cuota inicial de un total de: '.$this->valor_cuota_inicial,
            'matricula_id'=>$matricula->id,
            'responsable_id'=>$this->alumno_id,
            'estado_cartera_id'=>1
        ]);

        //matricula
        Cartera::create([
            'fecha_pago'=>now(),
            'valor'=>$this->valor_matricula,
            'saldo'=>$this->valor_matricula,
            'observaciones'=>'Curso: '.$this->cursoName.'. Cuota inicial de un total de: '.$this->valor_matricula,
            'matricula_id'=>$matricula->id,
            'responsable_id'=>$this->alumno_id,
            'estado_cartera_id'=>1
        ]);

        //Cuotas
        if($this->cuotas>0){
            $a=1;
            while ($a <= $this->cuotas) {
                $endDate = $date->addMonths();
                Cartera::create([
                    'fecha_pago'=>$endDate,
                    'valor'=>$this->valor_cuota,
                    'saldo'=>$this->valor_cuota,
                    'observaciones'=>'Curso: '.$this->cursoName.'. '.$a.'a. cuota mensual para un curso por valor de: '.$this->valor_curso,
                    'matricula_id'=>$matricula->id,
                    'responsable_id'=>$this->alumno_id,
                    'estado_cartera_id'=>1
                ]);
                $a++;
            }
        }       
        

        // Notificación
        $this->dispatch('alerta', name:'Se ha creado correctamente la matricula.');
        $this->resetFields();

        //refresh
        /* $this->dispatch('refresh');
        $this->dispatch('created'); */

        //Enviar a crear recibo
        $this->redirect('/financiera/recibopagos');

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

    private function sedes(){
        return Sede::where('status', true)
                    ->orderBy('name')
                    ->get();
    }

    public function render(){
        return view('livewire.academico.matricula.matriculas-crear', [
            'estudiantes'=>$this->estudiantes(),
            'noestudiantes'=>$this->noestudiantes(),
            'sedes'=>$this->sedes(),
        ]);
    }
}
