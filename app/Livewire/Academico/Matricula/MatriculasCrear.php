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


    public $buscar=null;
    public $buscaestudi='';

    public $buscamin='';



    //Cursos por sede
    public function updatedSedeId(){
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
    public function updatedCursoId(){
        $this->reset('config_id');
        $this->configPago=ConfiguracionPago::where('sede_id', $this->sede_id)
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
        }
    }


    //Buscar modulos
    public function updatedConfigId(){
        $this->reset(
            'modulos'
        );

        //Cargar datos de pago
        $pagos=ConfiguracionPago::find($this->config_id);

        $this->valor_curso=$pagos->valor_curso;
        $this->valor_matricula=$pagos->valor_matricula;
        $this->valor_cuota_inicial=$pagos->valor_cuota_inicial;
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
        $this->limpiar();
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
