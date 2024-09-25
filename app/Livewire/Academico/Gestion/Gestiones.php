<?php

namespace App\Livewire\Academico\Gestion;

use App\Models\Academico\Ciclo;
use App\Models\Academico\Control;
use App\Models\Academico\Nota;
use App\Models\Academico\Curso;
use App\Models\Academico\Grupo;
use App\Models\Configuracion\Sede;
use App\Models\Configuracion\Estado;
use App\Models\User;
use App\Traits\FiltroTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Gestiones extends Component
{

    use WithPagination;
    use FiltroTrait;

    public $ordena='estado_cartera';
    public $ordenado='DESC';
    public $pages = 3;

    public $is_modify = true;
    public $is_creating = false;
    public $is_editing = false;
    public $is_deleting = false;
    public $is_grupos=false;
    public $is_change=false;
    public $is_inventario=false;
    public $is_observaciones=false;
    public $is_asistencias=false;
    public $is_notas=false;
    public $is_transacciones=false;
    public $is_gestransaccion=false;
    public $is_document=false;
    public $is_especiales=false;
    public $is_vergrupo=false;
    public $is_activar=false;
    public $crtid;

    public $sedes=[];

    public $estudiante_id;

    public $ruta=2;

    public $elegido;
    public $ciclo;
    public $hoy;

    public $buscar='';
    public $buscamin='';
    public $filtroSede;
    public $filtrocurso;
    public $filtroInides;
    public $filtroInihas;
    public $filtroinicia=[];
    public $estado_estudiante=[];
    public $filtrociclo;
    public $filtroprofesor;

    protected $listeners = ['refresh' => '$refresh'];

    public function mount(){

        $this->claseFiltro(11);

        $this->hoy=now();

        foreach (Auth::user()->sedes as $value) {
            if(in_array($value->id, $this->sedes )){

            }else{
                array_push($this->sedes, $value->id);
            }
        }
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

    //Activar evento
    #[On('cancelando')]
    //Mostrar formulario de creación
    public function cancela()
    {
        $this->reset(
                        'is_modify',
                        'is_creating',
                        'is_editing',
                        'is_deleting',
                        'is_change',
                        'is_grupos',
                        'is_inventario',
                        'is_observaciones',
                        'is_asistencias',
                        'is_notas',
                        'is_transacciones',
                        'is_gestransaccion',
                        'is_document',
                        'is_especiales',
                        'is_activar'
                    );
    }

    //Activar evento
    #[On('created')]
    //Mostrar formulario de creación
    public function updatedIsCreating()
    {
        $this->is_modify = !$this->is_modify;
        $this->is_creating = !$this->is_creating;
    }

    //Activar evento
    #[On('inventario')]
    //Mostrar formulario de creación
    public function updatedIsInventario()
    {
        $this->is_modify = !$this->is_modify;
        $this->is_inventario = !$this->is_inventario;
    }

    public function updatedEstadoEstudiante(){
        $this->controles();
    }

    //Activar evento
    #[On('Editando')]
    //Mostrar formulario de creación
    public function updatedIsEditing()
    {
        $this->is_modify = !$this->is_modify;
        $this->is_editing = !$this->is_editing;
    }

    // Mostrar
    public function show($esta, $act, $est=null){

        $this->elegido=$esta;
        $this->is_modify = !$this->is_modify;
        $this->estudiante_id=$est;

        switch ($act) {
            case 0:
                $this->is_observaciones=!$this->is_observaciones;
                break;

            case 1:
                $this->is_asistencias=!$this->is_asistencias;
                break;

            case 2:
                $this->is_notas=!$this->is_notas;
                break;

            case 3:
                $this->is_transacciones=!$this->is_transacciones;
                break;

            case 4:
                $this->is_gestransaccion=!$this->is_gestransaccion;
                break;

            case 5:
                $this->is_document=!$this->is_document;
                break;

            case 6:
                $this->is_activar=!$this->is_activar;
                break;

        }
    }

    public function muestragrupo($id,$mus){
        if($mus===1){
            $this->is_vergrupo=!$this->is_vergrupo;
            $this->crtid=$id;
        }
        if($mus===2){
            $this->reset(
                'is_vergrupo',
                'crtid'
            );
        }

    }

    //Activar evento
    #[On('Inactivando')]
    //Mostrar formulario de inactivación
    public function updatedIsDeleting()
    {
        $this->is_modify = !$this->is_modify;
        $this->is_deleting = !$this->is_deleting;
    }

    //Activar evento
    #[On('grupos')]
    //Mostrar formulario de inactivación
    public function updatedIsGrupos()
    {
        $this->is_modify = !$this->is_modify;
        $this->is_grupos = !$this->is_grupos;
    }

    //Activar evento
    #[On('estudiantes')]
    //Mostrar formulario de inactivación
    public function updatedIsChange()
    {
        $this->is_modify = !$this->is_modify;
        $this->is_change = !$this->is_change;
    }

    //Activar evento
    #[On('especia')]
    //Mostrar formulario de creación
    public function updatedIsEspeciales()
    {
        $this->is_modify = !$this->is_modify;
        $this->is_especiales = !$this->is_especiales;
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

    public function notas($item, $id){

        $notas=Nota::where('grupo_id', $item)->first();

        if($notas){
            $this->show($notas->id,2);

        }else{
            $this->dispatch('alerta', name:'No se han sacado notas para este grupo');
        }
    }

    public function asistencia($ciclo, $item, $id){

        $this->reset('ciclo');
        $this->ciclo=$ciclo;
        $this->show($item, 1, $id); //envío id del grupo

    }

    private function controles()
    {
        $controles = Control::where('status', true)
                        ->whereIn('sede_id', $this->sedes)
                        ->buscar($this->buscamin)
                        ->sede($this->filtroSede)
                        ->curso($this->filtrocurso)
                        ->inicia($this->filtroinicia)
                        ->status($this->estado_estudiante)
                        ->ciclo($this->filtrociclo)
                        ->profesor($this->filtroprofesor)
                        ->orderBy($this->ordena, $this->ordenado)
                        ->paginate($this->pages);

        $this->ciclos();

        return $controles;
    }

    private function ciclos(){
        $crt=Control::where('status', true)
                    ->whereIn('sede_id', $this->sedes)
                    ->buscar($this->buscamin)
                    ->sede($this->filtroSede)
                    ->curso($this->filtrocurso)
                    ->inicia($this->filtroinicia)
                    ->status($this->estado_estudiante)
                    ->profesor($this->filtroprofesor)
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

    private function estados(){
        return Estado::where('status', true)
                        ->orderBy('name', 'ASC')
                        ->get();

    }

    private function sedeasignadas(){

        return Sede::whereIn('id',$this->sedes)
                    ->orderBy('name', 'asc')
                    ->get();
    }

    private function cursos(){
        return Curso::where('status', true)
                        ->orderBy('name', 'ASC')
                        ->get();
    }

    private function status_estu(){
        return DB::table('estados')
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
        return view('livewire.academico.gestion.gestiones',[
            'controles'     =>$this->controles(),
            'estados'       =>$this->estados(),
            'asignadas'     =>$this->sedeasignadas(),
            'cursos'        =>$this->cursos(),
            'status_estu'   =>$this->status_estu(),
            'ciclos'        =>$this->ciclos(),
            'profesores'    =>$this->profesores(),
        ]);
    }
}
