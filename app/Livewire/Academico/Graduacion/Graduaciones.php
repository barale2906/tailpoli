<?php

namespace App\Livewire\Academico\Graduacion;

use App\Exports\GraduacionExport;
use App\Models\Academico\Ciclo;
use App\Models\Academico\Control;
use App\Models\Academico\Curso;
use App\Models\Academico\Grupo;
use App\Models\Academico\Matricula;
use App\Models\Clientes\Pqrs;
use App\Models\Configuracion\Estado;
use App\Models\Configuracion\Sede;
use App\Models\Financiera\Cartera;
use App\Models\User;
use App\Traits\FiltroTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Graduaciones extends Component
{
    use WithPagination;
    use FiltroTrait;

    public $ordena='estado_cartera';
    public $ordenado='DESC';
    public $pages = 3;

    public $is_modify = true;
    public $is_vernotas=false;
    public $is_verasistencia=false;
    public $is_observaciones=false;
    public $is_document=false;
    public $is_gradua=false;
    public $is_status=false;
    public $crtid;
    public $elegido;
    public $ruta=2;

    public $buscar='';
    public $buscamin='';
    public $filtroSede;
    public $filtrocurso;
    public $filtroInides;
    public $filtroInihas;
    public $filtroinicia=[];
    public $filtroInigra;
    public $filtroFingra;
    public $filtrogrado=[];
    public $observaciones;
    public $fecha_grado;
    public $nuevoestado;
    public $filtrodeser;
    public $estado_estudiante=[];
    public $filtrociclo;
    public $filtroprofesor;

    public $sedesids=[];
    public $cursosids=[];

    protected $listeners = ['refresh' => '$refresh'];

    public function mount(){
        $this->claseFiltro(13);
        $this->obtenerids();
    }

    public function obtenerids(){
        $sedes=Control:://whereNotIn('status_est',[2,4,9,11])
                        select('sede_id')
                        ->groupBy('sede_id')
                        ->get();

        foreach ($sedes as $value) {
            array_push($this->sedesids,$value->sede_id);
        }
    }

    //Obtener desertados hoy
    public function deserhoy(){
        $margen=config('instituto.desertado_fin')+1; //Control de deserción
        $fecha=Carbon::today()->subDays($margen); //tIEMPO DE ASISTENCIA
        $this->filtrodeser=$fecha;
    }

    //Cargar variable
    public function buscaText(){
        $this->resetPage();
        $this->buscamin=strtolower($this->buscar);
    }

    //Limpiar variables
    public function limpiar(){
        $this->reset('buscamin', 'buscar');
        $this->resetPage();
        $this->controles();
    }

    // Ordenar Registros
    public function organizar($campo)
    {
        if($this->ordenado === 'ASC')
        {
            $this->ordenado = 'DESC';
        }else{
            $this->ordenado = 'ASC';
        }
        return $this->ordena = $campo;
    }

    //Numero de registros
    public function paginas($valor)
    {
        $this->resetPage();
        $this->pages=$valor;
    }

    public function updatedFiltroFingra(){
        if($this->filtroInigra<=$this->filtroFingra){
            $crea=array();
            array_push($crea, $this->filtroInigra);
            array_push($crea, $this->filtroFingra);
            $this->filtrogrado=$crea;
        }else{
            $this->dispatch('alerta', name:'Fecha de inicio debe ser menor a fecha fin');
        }
    }

    public function updatedFiltroInihas(){
        if($this->filtroInides<=$this->filtroInihas){
            $crea=array();
            array_push($crea, $this->filtroInides);
            array_push($crea, $this->filtroInihas);
            $this->filtroinicia=$crea;
        }else{
            $this->dispatch('alerta', name:'Fecha de inicio debe ser menor a fecha fin');
        }
    }

    public function updatedEstadoEstudiante(){
        $this->singrados();
    }

    public function muestrasitencia($id,$mus){

        $this->reset('is_verasistencia','crtid');

        if($mus===1){
            $this->is_verasistencia=true;
            $this->crtid=$id;
        }
        if($mus===2){
            $this->reset(
                'is_verasistencia',
                'crtid'
            );
        }

    }

    public function muestranota($id,$mus){

        $this->reset('is_vernotas','crtid');

        if($mus===1){
            $this->is_vernotas=true;
            $this->crtid=$id;
        }
        if($mus===2){
            $this->reset(
                'is_vernotas',
                'crtid'
            );
        }

    }

    //Activar evento
    #[On('cancelando')]
    //Mostrar formulario de creación
    public function cancela()
    {
        $this->reset(
                        'is_modify',
                        'is_observaciones',
                        'is_document',
                        'is_gradua',
                        'is_status',
                        'observaciones',
                        'nuevoestado'
                    );
    }

    // Mostrar
    public function show($esta, $act, $est=null){

        $this->elegido=$esta;
        $this->is_modify = !$this->is_modify;

        switch ($act) {
            case 0:
                $this->is_observaciones=!$this->is_observaciones;
                break;

            case 1:
                $this->is_document=!$this->is_document;
                break;

        }
    }

    public function exportar(){
        return new GraduacionExport(
                                        $this->buscamin,
                                        $this->filtroSede,
                                        $this->filtrocurso,
                                        $this->filtroinicia,
                                        $this->filtrogrado,
                                        $this->estado_estudiante,
                                        $this->filtrociclo,
                                        $this->filtroprofesor,
                                        $this->filtrodeser
                                    );
    }

    public function graduafun($id){
        $this->is_gradua=!$this->is_gradua;
        $this->elegido=Control::find($id);
        $this->crtid=$id;
    }

    public function statuscambiar($id){
        $this->is_status=!$this->is_status;
        $this->elegido=Control::find($id);
        $this->crtid=$id;
    }

    public function statusactualiza(){
        Cartera::where('responsable_id',$this->elegido->estudiante_id)
                                    ->update([
                                        'status_est'    =>$this->nuevoestado,
                                    ]);

        Matricula::where('alumno_id', $this->elegido->estudiante_id)
                        ->update([
                            'status_est'    =>$this->nuevoestado
                        ]);

        $this->elegido->update([
                        'status_est'    =>$this->nuevoestado,
                    ]);

        Pqrs::create([
            'estudiante_id' =>$this->elegido->estudiante_id,
            'gestion_id'    =>Auth::user()->id,
            'fecha'         =>now(),
            'tipo'          =>1,
            'observaciones' =>'ACÁDEMICO: '.Auth::user()->name." escribio: ".$this->observaciones.". CAMBIO DE ESTADO. ----- ",
            'status'        =>4
        ]);

        $this->dispatch('alerta', name:'Estudiante CAMBIO DE ESTADO.');

        //refresh
        $this->dispatch('cancelando');
    }

    public function graduaprueba(){
        Cartera::where('matricula_id',$this->elegido->matricula_id)
                                    ->update([
                                        'status_est'    =>4,
                                        'estado_cartera_id'=>6,
                                        'status'=>6
                                    ]);

        Matricula::where('id', $this->elegido->matricula_id)
                        ->update([
                            'status_est'    =>4
                        ]);

        $this->elegido->update([
                        'status_est'    =>4,
                        'fecha_grado'   =>$this->fecha_grado,
                    ]);

        Pqrs::create([
            'estudiante_id' =>$this->elegido->estudiante_id,
            'gestion_id'    =>Auth::user()->id,
            'fecha'         =>now(),
            'tipo'          =>1,
            'observaciones' =>'ACÁDEMICO: '.Auth::user()->name." escribio: ".$this->observaciones.". GRADUADO(A) ----- ",
            'status'        =>4
        ]);

        $this->dispatch('alerta', name:'Estudiante registrado como GRADUADO(A)');

        //refresh
        $this->dispatch('cancelando');
    }

    private function singrados(){
        $sing=Control::whereNotIn('status_est',[11])
                        ->selectRaw('controls.*, DATEDIFF(CURDATE(), ultima_asistencia) as dias_pasados')
                        ->buscar($this->buscamin)
                        ->desert($this->filtrodeser)
                        ->sede($this->filtroSede)
                        ->curso($this->filtrocurso)
                        ->inicia($this->filtroinicia)
                        ->grado($this->filtrogrado)
                        ->status($this->estado_estudiante)
                        ->ciclo($this->filtrociclo)
                        ->profesor($this->filtroprofesor)
                        ->orderBy($this->ordena, $this->ordenado)
                        ->paginate($this->pages);

        $this->ciclos();

        return $sing;
    }

    private function ciclos(){
        $crt=Control::whereNotIn('status_est',[11])
                    ->buscar($this->buscamin)
                    ->sede($this->filtroSede)
                    ->desert($this->filtrodeser)
                    ->curso($this->filtrocurso)
                    ->inicia($this->filtroinicia)
                    ->grado($this->filtrogrado)
                    ->status($this->estado_estudiante)
                    ->select('ciclo_id')
                    ->groupBy('ciclo_id')
                    ->get();

        $ids=array();

        foreach ($crt as $value) {
            array_push($ids,$value->ciclo_id);
        }

        return Ciclo::whereIn('id',$ids)
                        ->select('id','name','inicia')
                        ->orderBy('inicia','DESC')
                        ->get();
    }

    private function cursos(){
        return Curso::where('status', true)
                        ->orderBy('name', 'ASC')
                        ->get();
    }

    private function estados(){

        return Estado::where('status', true)
                        ->orderBy('name', 'ASC')
                        ->get();

    }

    private function asignadas(){
        return Sede::whereIn('id',$this->sedesids)
                    ->where('status',true)
                    ->orderBy('name','ASC')
                    ->get();
    }

    private function status_estu(){
        return DB::table('estados')
                    //->whereNotIn('id',[2,11])
                    ->orderBy('name')
                    ->get();

    }

    private function profesores(){
        $profe=Grupo::where('status',true)
                    ->select('profesor_id')
                    ->groupBy('profesor_id')
                    ->get();

        $ids=array();
        foreach ($profe as $value) {
            array_push($ids,$value->profesor_id);
        }

        return User::whereIn('id',$ids)
                    ->select('id','name')
                    ->orderBy('name', 'ASC')
                    ->get();
    }

    public function render()
    {
        return view('livewire.academico.graduacion.graduaciones',[
            'singrados' => $this->singrados(),
            'estados'   => $this->estados(),
            'cursos'    => $this->cursos(),
            'asignadas' => $this->asignadas(),
            'status_estu'=>$this->status_estu(),
            'ciclos'        =>$this->ciclos(),
            'profesores'=>$this->profesores()
        ]);
    }
}
