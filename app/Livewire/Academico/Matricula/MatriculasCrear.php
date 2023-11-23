<?php

namespace App\Livewire\Academico\Matricula;

use App\Models\Academico\Ciclo;
use App\Models\Academico\Ciclogrupo;
use App\Models\Academico\Control;
use App\Models\Academico\Curso;
use App\Models\Academico\Grupo;
use App\Models\Academico\Horario;
use App\Models\Academico\Matricula;
use App\Models\Academico\Modulo;
use App\Models\Configuracion\Documento;
use App\Models\Configuracion\Sede;
use App\Models\Financiera\Cartera;
use App\Models\Financiera\ConceptoPago;
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
    public $ciclos;
    public $ciclo_id;
    public $ciclosel;
    public $horarios;
    public $fecha_inicia;

    public $fechaRegistro;

    public $sede_id;
    public $sedeele;
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
    public $cuotas;

    public $matricula;

    public $vista=true;

    public $ruta=1;

    public $is_comercial=false;
    public $primerGrupo;


    public $buscar=null;
    public $buscaestudi='';

    public $buscamin='';

    public function mount($ruta=null){
        $this->ruta=$ruta;
        $this->fechaRegistro=Carbon::now()->subDays(8);
    }



    //Cursos por sede
    public function updatedSedeId(){

        $this->reset('curso_id','sedeele', 'config_id', 'ciclo_id', 'ciclosel', 'horarios');

        $this->sedeele=Sede::find($this->sede_id);

        $this->cursos=Curso::query()
                            ->with(['configpagos'])
                            ->when($this->sedeele->sector->id, function($query){
                                return $query->where('status', true)
                                        ->WhereHas('configpagos', function($q){
                                            $q->where('sector_id', $this->sedeele->sector->id);
                                        });
                                })
                            ->orderBy('name')
                            ->get();
    }

    //Configuraciones por curso
    public function updatedCursoId(){
        $this->reset('config_id', 'ciclo_id', 'ciclosel', 'horarios');
        $this->configPago=ConfiguracionPago::where('sector_id', $this->sedeele->sector->id)
                                            ->where('curso_id', $this->curso_id)
                                            ->orderBy('descripcion')
                                            ->get();

        $this->matrCurso();
    }

    //Determinar Si el estudiante ya esta matriculado a este curso
    public function matrCurso(){
        $matriculados = Matricula::where('status', true)
                                        ->where('alumno_id', $this->alumno_id)
                                        ->where('curso_id', $this->curso_id)
                                        ->count();

        if($matriculados>0){
            $this->dispatch('alerta', name:'El estudiante tiene una matricula activa a este curso.');
            $this->reset('curso_id', 'config_id', 'modulos');
        }
    }


    //Buscar modulos
    public function updatedConfigId(){
        $this->reset(
            'modulos',
            'ciclo_id',
            'ciclosel',
            'horarios'
        );

        //Cargar datos de pago
        $pagos=ConfiguracionPago::find($this->config_id);

        $this->valor_curso=$pagos->valor_curso;
        $this->valor_matricula=$pagos->valor_matricula;
        $this->cuotas=$pagos->cuotas;
        $this->valor_cuota=$pagos->valor_cuota;

        if($pagos->incluye){
            $this->modulos=Modulo::where('curso_id', $this->curso_id)
                                    ->where('status', true)
                                    ->orderBy('name')
                                    ->get();
        }else{
            $this->modulos=DB::table('configpago_modulo')
                                ->where('config_id', $this->config_id)
                                ->get();

        }

        $this->obtieneciclos();
    }

    public function obtieneciclos(){
        $this->ciclos=Ciclo::where('sede_id', $this->sede_id)
                            ->where('curso_id', $this->curso_id)
                            ->where('inicia', '>=', $this->fechaRegistro)
                            ->where('status', true)
                            ->orderBy('inicia', 'ASC')
                            ->get();
    }

    public function updatedCicloId(){
        $this->reset('fecha_inicia', 'ciclosel');
        $this->ciclosel=Ciclo::find($this->ciclo_id);
        $this->fecha_inicia=$this->ciclosel->inicia;

        $this->obteHorarios();
    }

    public function obteHorarios(){

        $this->primerGrupo=Ciclogrupo::where('ciclo_id', $this->ciclo_id)->orderBy('fecha_inicio', 'ASC')->first();

        $this->horarios=Horario::where('sede_id', $this->sede_id)
                                ->where('grupo_id', $this->primerGrupo->grupo_id)
                                ->orderBy('hora', 'ASC')
                                ->get();
    }

    //Buscar Alumno
    public function buscAlumno(){
        $this->buscaestudi=strtolower($this->buscar);
    }

    //Limpiar variables
    public function limpiar(){
        $this->reset('buscar');
    }

    //Selecciona Comercial
    public function updatedComercialId(){
        $comer=intval($this->comercial_id);
        if($comer===Auth::user()->id){
            $this->is_comercial=!$this->is_comercial;
        }
    }

    public function selAlumno($item){
        $this->alumno_id=$item['id'];
        $this->alumnoName=$item['name'];
        $this->alumnodocumento=$item['documento'];
        $this->limpiar();
    }

    /**
     * Reglas de validación
     */
    protected $rules = [
        'medio' => 'required',
        'fecha_inicia' => 'required',
        'nivel'=>'required',
        'valor_curso'=>'required',
        'valor_matricula'=>'required',
        //'metodo'=>'required',
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
                        'fecha_inicia',
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
        $this->matricula = Matricula::create([
                                'medio'=>$this->medio,
                                'fecha_inicia'=>$this->fecha_inicia,
                                'nivel'=>$this->nivel,
                                'valor'=>$this->valor_curso,
                                'metodo'=>$this->metodo,
                                'sede_id'=>$this->sede_id,
                                'curso_id'=>$this->curso_id,
                                'alumno_id'=>$this->alumno_id,
                                'comercial_id'=>$this->comercial_id,
                                'creador_id'=>Auth::user()->id,
                                'configpago'=>$this->config_id
                            ]);


        //matricula
        $concepto=ConceptoPago::where('name', 'Matricula')
                                ->where('status', true)
                                ->first();

        Cartera::create([
            'fecha_pago'=>now(),
            'valor'=>$this->valor_matricula,
            'saldo'=>$this->valor_matricula,
            'observaciones'=>'Curso: '.$this->cursoName.'. Cuota inicial de un total de: '.$this->valor_matricula,
            'matricula_id'=>$this->matricula->id,
            'concepto_pago_id'=>$concepto->id,
            'concepto'=>$concepto->name,
            'responsable_id'=>$this->alumno_id,
            'estado_cartera_id'=>1
        ]);

        //Cuotas
        $concepto=ConceptoPago::where('name', 'Mensualidad')
                                ->where('status', true)
                                ->first();
        if($this->cuotas>0){
            $a=1;
            while ($a <= $this->cuotas) {
                $endDate = $date->addMonths();
                Cartera::create([
                    'fecha_pago'=>$endDate,
                    'valor'=>$this->valor_cuota,
                    'saldo'=>$this->valor_cuota,
                    'observaciones'=>'Curso: '.$this->cursoName.'. '.$a.'a. cuota mensual para un curso por valor de: '.$this->valor_curso,
                    'matricula_id'=>$this->matricula->id,
                    'concepto_pago_id'=>$concepto->id,
                    'concepto'=>$concepto->name,
                    'responsable_id'=>$this->alumno_id,
                    'estado_cartera_id'=>1
                ]);
                $a++;
            }
        }

        // Cargar modulos
        foreach ($this->modulos as $value) {
            DB::table('matricula_modulos_aprobacion')
                ->insert([
                    'matricula_id'  =>$this->matricula->id,
                    'alumno_id'     =>$this->alumno_id,
                    'modulo_id'     =>$value->id,
                    'name'          =>$value->name,
                    'dependencia'   =>$value->dependencia,
                    'observaciones' =>now()." ".Auth::user()->name." Genera el registro.",
                    'created_at'    =>now(),
                    'updated_at'    =>now(),
                ]);
        }

        //Cargar documentos base
        $documentos=Documento::where('status', 3)
                                ->whereIn('tipo', ['pagare', 'contrato'])
                                ->orderBy('titulo')
                                ->select('id')
                                ->get();

        //Asignar documentos base
        foreach ($documentos as $value) {
            DB::table('documentos_matriculas')
                    ->insert([
                        'documento_id'   => $value->id,
                        'matricula_id'     => $this->matricula->id,
                        'created_at'    =>now(),
                        'updated_at'    =>now()
                    ]);
        }

        //Generar control

        Control::create([
            'inicia'        =>$this->ciclosel->inicia,
            'observaciones' =>"Matriculado el día: ".$date,
            'matricula_id'  =>$this->matricula->id,
            'ciclo_id'      =>$this->ciclosel->id,
            'estudiante_id' =>$this->alumno_id
        ]);

        //Asignar grupos
        $this->asignar();
    }

    //Asignar grupos al estudiante
    public function asignar(){

        foreach ($this->ciclosel->ciclogrupos as $value) {

            DB::table('grupo_matricula')
            ->insert([
                'grupo_id'      =>$value->grupo_id,
                'matricula_id'  =>$this->matricula->id,
                'created_at'    =>now(),
                'updated_at'    =>now(),
            ]);

            //Cargar estudiante al grupo
            DB::table('grupo_user')
                ->insert([
                    'grupo_id'      =>$value->grupo_id,
                    'user_id'       =>$this->matricula->alumno->id,
                    'created_at'    =>now(),
                    'updated_at'    =>now(),
                ]);



            //Sumar usuario al grupo
            $inscritos=Grupo::find($value->grupo_id);

            $tot=$inscritos->inscritos+1;

            $inscritos->update([
                'inscritos'=>$tot
            ]);

        }

        //Sumar usuario al ciclo
        $tota=$this->ciclosel->registrados+1;

        $this->ciclosel->update([
            'registrados'=>$tota
        ]);


        // Notificación
        $this->dispatch('alerta', name:'Se ha creado correctamente la matricula.');
        $this->resetFields();
        $this->vista=!$this->vista;
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
