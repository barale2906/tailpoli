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
use App\Models\Academico\Planes;
use App\Models\Clientes\Pqrs;
use App\Models\Configuracion\Documento;
use App\Models\Configuracion\Sede;
use App\Models\Financiera\Cartera;
use App\Models\Financiera\ConceptoPago;
use App\Models\Financiera\ConfiguracionPago;
use App\Models\User;
use App\Models\Configuracion\Perfil;
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
    public $status_est;

    public $fechaRegistro;

    public $sede_id;
    public $sedeele;
    public $cursos;
    public $curso_id;
    public $cursoName;
    public $config_id;
    public $configElegida;
    public $configPago;
    public $configSeleccionada;
    public $modulos;

    public $valor_curso;
    public $valor_matricula;
    public $valor_cuota;
    public $cuotas;

    public $matricula;
    public $elegido;

    public $vista=true;
    public $genrecibo=true;
    public $finrecibo=true;

    public $ruta=1;
    public $url;

    public $is_comercial=false;
    public $is_document=false;
    public $is_incompleto=false;
    public $primerGrupo;


    public $buscar=null;
    public $buscaestudi='';

    public $buscamin='';

    public $ordena='name';
    public $ordenado='ASC';
    public $pages = 20;

    public $plan;

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
                                            ->where('status', true)
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

        $this->plan=Planes::where('status', true)
                            ->where('curso_id', $this->curso_id)
                            ->first();
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
        $this->configSeleccionada=ConfiguracionPago::find($this->config_id);

        $this->valor_curso=$this->configSeleccionada->valor_curso;
        $this->valor_matricula=$this->configSeleccionada->valor_matricula;
        $this->cuotas=$this->configSeleccionada->cuotas;
        $this->valor_cuota=$this->configSeleccionada->valor_cuota;

        if($this->configSeleccionada->incluye){
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
                            ->orderBy('name', 'ASC')
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

        //dd("sede: ",$this->sede_id," grupo: ",$this->primerGrupo->grupo_id," horarios: ",$this->horarios);
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
        $this->reset(
                'alumno_id',
                'alumnoName',
                'alumnodocumento',
        );
        $eleg=Perfil::where('user_id', $item['id'])->first();
        $cont=0;
        if(!$eleg->fecha_documento){
            $cont=$cont+1;
        }
        if(!$eleg->direccion){
            $cont=$cont+1;
        }
        if(!$eleg->fecha_nacimiento){
            $cont=$cont+1;
        }
        if(!$eleg->celular){
            $cont=$cont+1;
        }

        if($cont>0){
            $this->is_incompleto=true;
            $this->alumnoName=$item['name'];
        }else{
            $this->cargaEstudiante($item);
        }
    }

    public function cargaEstudiante($item){
        $this->reset('is_incompleto');
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

        $date = Carbon::parse($this->ciclosel->inicia);
        if($this->fecha_inicia>now()){
            $this->status_est=9;
        }else{
            $this->status_est=1;
        }

        //Crear registro
        $this->matricula = Matricula::create([
                                'medio'=>strtolower($this->medio),
                                'fecha_inicia'=>$this->fecha_inicia,
                                'nivel'=>$this->nivel,
                                'valor'=>$this->valor_curso,
                                'metodo'=>$this->metodo,
                                'sede_id'=>$this->sede_id,
                                'curso_id'=>$this->curso_id,
                                'alumno_id'=>$this->alumno_id,
                                'comercial_id'=>$this->comercial_id,
                                'creador_id'=>Auth::user()->id,
                                'configpago'=>$this->config_id,
                                'status_est'=>$this->status_est
                            ]);

        $this->elegido=$this->matricula->id;

        //cartera
        $concepto=ConceptoPago::where('name', 'Matricula')
                                ->where('status', true)
                                ->first();

        $sede=Sede::find($this->sede_id);

        Cartera::create([
            'fecha_pago'=>now(),
            'valor'=>$this->valor_matricula,
            'saldo'=>$this->valor_matricula,
            'observaciones'=>'Curso: '.$this->cursoName.'. Cuota inicial de un total de: '.$this->valor_matricula,
            'matricula_id'=>$this->matricula->id,
            'concepto_pago_id'=>$concepto->id,
            'concepto'=>$concepto->name,
            'responsable_id'=>$this->alumno_id,
            'estado_cartera_id'=>1,
            'sede_id'=>$sede->id,
            'sector_id'=>$sede->sector_id,
            'status_est'=>$this->status_est
        ]);

        //Cuotas
        $concepto=ConceptoPago::where('name', 'Mensualidad')
                                ->where('status', true)
                                ->first();
        if($this->cuotas>0){
            $a=1;
            while ($a <= $this->cuotas) {
                $endDate="";
                if($a===1){
                    $endDate=$date;
                }else{
                    $endDate = $date->addMonths();
                }

                Cartera::create([
                    'fecha_pago'=>$endDate,
                    'valor'=>$this->valor_cuota,
                    'saldo'=>$this->valor_cuota,
                    'observaciones'=>'Cuota N°: '.$a.' mensual. ----- Curso: '.$this->cursoName.'. Un curso por valor de: '.$this->valor_curso,
                    'matricula_id'=>$this->matricula->id,
                    'concepto_pago_id'=>$concepto->id,
                    'concepto'=>$concepto->name,
                    'responsable_id'=>$this->alumno_id,
                    'estado_cartera_id'=>1,
                    'sede_id'=>$sede->id,
                    'sector_id'=>$sede->sector_id,
                    'status_est'=>$this->status_est
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
                                ->whereIn('tipo', ['contrato','pagare','cartapagare','actaPago','comproCredito','comproEntrega','gastocertifinal','matricula'])
                                ->orderBy('titulo')
                                ->select('id')
                                ->get();

        //Asignar documentos base
        foreach ($documentos as $value) {
            DB::table('documento_matricula')
                    ->insert([
                        'documento_id'   => $value->id,
                        'matricula_id'     => $this->matricula->id,
                        'created_at'    =>now(),
                        'updated_at'    =>now()
                    ]);
        }

        //Generar historial
        Pqrs::create([
            'estudiante_id' =>$this->alumno_id,
            'gestion_id'    =>Auth::user()->id,
            'fecha'         =>now(),
            'tipo'          =>4,
            'observaciones' =>'ACÁDEMICO: Matriculado ----- ',
            'status'        =>4
        ]);

        Control::create([
            'inicia'        =>$this->ciclosel->inicia,
            //'observaciones' =>"Matriculado el día: ".$date,
            'matricula_id'  =>$this->matricula->id,
            'ciclo_id'      =>$this->ciclosel->id,
            'sede_id'       =>$this->sede_id,
            'estudiante_id' =>$this->alumno_id,
            'status_est'=>$this->status_est
        ]);

        //Asignar grupos
        $this->asignar();
    }

    //Activar documentos
    public function documentos(){
        $this->is_document=!$this->is_document;
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
        $this->vista=!$this->vista;

        $this->url='/pdfs/matricular/'.$this->matricula->id;
    }

    //Registrar Pago por transferencia
    public function transferencia(){
        Pqrs::create([
            'estudiante_id' =>$this->alumno_id,
            'gestion_id'    =>Auth::user()->id,
            'fecha'         =>now(),
            'tipo'          =>2,
            'observaciones' =>'PAGO: el estudiante realizará el pago por transferencia ----- ',
            'status'        =>4
        ]);
        $this->dispatch('alerta', name:'Se registro el no pago aún de la matricula.');
        //$this->resetFields();
        $this->finrecibo=!$this->finrecibo;
    }

    public function recibo(){
        $this->genrecibo=!$this->genrecibo;
    }



    private function estudiantes(){

        return User::buscar($this->buscaestudi)
                    ->orderBy($this->ordena, $this->ordenado)
                    ->paginate($this->pages);


        /* $consulta = User::query();

        if($this->buscaestudi){
            $consulta = $consulta->where('name', 'like', "%".$this->buscaestudi."%")
            ->orwhere('email', 'like', "%".$this->buscaestudi."%")
            ->orwhere('documento', 'like', "%".$this->buscaestudi."%");
        }

        return $consulta->orderBy($this->ordena, $this->ordenado)
                        ->paginate($this->pages); */
    }

    private function noestudiantes(){

        return User::where('status', true)
                    ->whereBetween('rol_id', [1,4])
                    ->orderBy('name', 'ASC')
                    ->get();
    }

    private function sedes(){
        return Sede::where('status', true)
                    ->orderBy('name')
                    ->get();
    }

    private function medios(){
        return DB::table('medios')
                    ->orderBy('name', 'ASC')
                    ->orderBy('status', 'DESC')
                    ->get();
    }

    public function render(){
        return view('livewire.academico.matricula.matriculas-crear', [
            'estudiantes'=>$this->estudiantes(),
            'noestudiantes'=>$this->noestudiantes(),
            'sedes'=>$this->sedes(),
            'medios'=>$this->medios()
        ]);
    }
}
