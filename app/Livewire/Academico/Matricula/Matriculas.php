<?php

namespace App\Livewire\Academico\Matricula;

use App\Exports\AcaMatriculaExport;
use App\Models\Academico\Curso;
use App\Models\Academico\Matricula;
use App\Models\Configuracion\Estado;
use App\Models\User;
use App\Traits\FiltroTrait;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Matriculas extends Component
{

    use WithPagination;
    use FiltroTrait;

    public $ordena='id';
    public $ordenado='DESC';
    public $pages = 3;

    public $is_modify = true;
    public $is_creating = false;
    public $is_editing = false;
    public $is_deleting = false;
    public $is_grupos=false;
    public $is_change=false;
    public $is_document=false;
    public $is_especiales=false;
    public $is_vergrupo=false;
    public $is_activar=false;
    public $crtid;
    public $reportes=true;

    public $ruta=0;

    public $elegido;

    //Filtrado

    public $buscar='';
    public $buscamin='';

    public $filtroCreades;
    public $filtroCreahas;

    public $filtroInides;
    public $filtroInihas;

    public $filtromatri;
    public $filtrocom;

    public $filtroestatumatri;
    public $estadoMatricula;
    public $filtroestatualum;
    public $estado_estudiante=[];
    public $filtrocrea=[];
    public $filtroinicia=[];
    public $filtroSede;
    public $filtrosedecurso;
    public $filtrocurso;
    public $matriculo=[];
    public $comercial=[];

    protected $listeners = ['refresh' => '$refresh'];

    //Cargar variable
    public function buscaText(){
        $this->resetPage();
        $this->buscamin=strtolower($this->buscar);
    }

    //Limpiar variables
    public function limpiar(){
        $this->reset(
            'buscamin',
            'buscar',
            'filtroCreades',
            'filtroCreahas',
            'filtroInides',
            'filtroInihas',
            'filtromatri',
            'filtrocom',
            'filtroestatumatri',
            'filtroestatualum',
            'filtrocurso',
            'filtrosede',
            'filtrosedecurso',
            'is_activar'
        );
        $this->resetPage();
        $this->matriculas();
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
                        'is_document',
                        'is_especiales',
                        'is_activar'
                    );
    }
    //Activar evento
    #[On('especia')]
    //Mostrar formulario de creación
    public function updatedIsEspeciales()
    {
        $this->is_modify = !$this->is_modify;
        $this->is_especiales = !$this->is_especiales;
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
    #[On('Editando')]
    //Mostrar formulario de creación
    public function updatedIsEditing()
    {
        $this->is_modify = !$this->is_modify;
        $this->is_editing = !$this->is_editing;
    }

    // Mostrar
    public function show($esta, $act){

        $this->elegido=$esta;
        $this->is_modify = !$this->is_modify;

        switch ($act) {
            case 0:
                $this->is_editing=!$this->is_editing;
                break;

            case 1:
                $this->is_deleting=!$this->is_deleting;
                break;

            case 2:
                $this->is_modify = false;
                $this->reset('is_editing', 'is_deleting','is_creating');
                $this->is_grupos=true;
                break;

            case 3:
                $this->is_change=!$this->is_change;
                break;

            case 4:
                $this->is_document=!$this->is_document;
                break;

            case 5:
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

    public function updatedEstadoMatricula(){
        $crt=intval($this->estadoMatricula);
        if($crt===1){
            $this->filtroestatumatri=3; //Activa
        }else if($crt===0){
            $this->filtroestatumatri=2; //Inactiva
        }
    }

    //Activar evento
    #[On('cambiagrupo')]
    //Mostrar formulario de inactivación
    public function updatedIsChange()
    {
        $this->is_modify = !$this->is_modify;
        $this->is_change = !$this->is_change;
    }

    public function exportar(){
        return new AcaMatriculaExport(
                                        $this->buscamin,
                                        $this->filtroSede,
                                        $this->filtrosedecurso,
                                        $this->filtrocurso,
                                        $this->filtromatri,
                                        $this->filtrocom,
                                        $this->filtroestatumatri,
                                        $this->filtrocrea,
                                        $this->filtroinicia,
                                        $this->estado_estudiante,
                                    );
    }

    public function mount($crt=null){

        if($crt){
            $this->reportes=false;
        }
        $this->claseFiltro(1);

        //$this->estado_estudiante=[1,2,3,4,5,6,7,8,9,10,11,12];

        $creadores=Matricula::select('creador_id')
                                    ->groupBy('creador_id')
                                    ->get();
        foreach ($creadores as $value) {
            array_push($this->matriculo, $value->creador_id);
        }

        $this->genComerci();
        $this->estado();
    }

    public function estado(){
        $est=Estado::select('id')->orderBy('id','ASC')->get();

        foreach ($est as $value) {
            array_push($this->estado_estudiante,$value->id);
        }
    }

    public function genComerci(){
        $comerciales=Matricula::select('comercial_id')
        ->groupBy('comercial_id')
        ->get();

            foreach ($comerciales as $value) {
            array_push($this->comercial, $value->comercial_id);
            }
    }

    public function updatedFiltroCreahas(){
        if($this->filtroCreades<=$this->filtroCreahas){
            $crea=array();
            array_push($crea, $this->filtroCreades);
            array_push($crea, $this->filtroCreahas);
            $this->filtrocrea=$crea;
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

    }

    private function matriculas()
    {
        return Matricula::buscar($this->buscamin)
                            ->sede($this->filtroSede) // Sede en que se matriculo
                            ->sedecurso($this->filtrosedecurso)
                            ->curso($this->filtrocurso)
                            ->creador($this->filtromatri)
                            ->comercial($this->filtrocom)
                            ->status($this->filtroestatumatri)
                            ->statusest($this->estado_estudiante)
                            ->crea($this->filtrocrea)
                            ->inicia($this->filtroinicia)
                            ->orderBy($this->ordena, $this->ordenado)
                            ->paginate($this->pages);

    }

    private function usuMatriculo(){
        //dd($this->matriculo);
        return User::whereIn('id', $this->matriculo)
                    ->orderBy('name', 'ASC')
                    ->get();
    }

    private function usuComercial(){

        return User::whereIn('id', $this->comercial)
                    ->orderBy('name', 'ASC')
                    ->get();
    }

    private function sedes(){
        return Matricula::select('sede_id')
                        ->groupBy('sede_id')
                        ->get();
    }

    private function cursos(){
        return Curso::orderBy('name', 'ASC')
                    ->get();
    }

    private function status_estu(){
        return DB::table('estados')
                    ->orderBy('name')
                    ->get();
    }


    public function render()
    {
        return view('livewire.academico.matricula.matriculas', [
            'matriculas'        => $this->matriculas(),
            'usuMatriculo'      => $this->usuMatriculo(),
            'usuComercial'      => $this->usuComercial(),
            'sedes'             => $this->sedes(),
            'cursos'            => $this->cursos(),
            'status_estu'       =>$this->status_estu(),
        ]);
    }
}
