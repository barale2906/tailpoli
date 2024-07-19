<?php

namespace App\Livewire\Academico\Ciclo;

use App\Exports\AcaCicloExport;
use App\Models\Academico\Ciclo;
use App\Models\Academico\Curso;
use App\Traits\FiltroTrait;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Ciclos extends Component
{
    use WithPagination;
    use FiltroTrait;

    public $ordena='inicia';
    public $ordenado='DESC';
    public $pages = 15;

    public $is_modify = true;
    public $is_creating = false;
    public $is_editing = false;
    public $is_deleting = false;
    public $is_asistencias = false;
    public $is_vergrupo=false;
    public $crtid;

    public $elegido;
    public $cicloele;
    public $cursos;

    public $buscar='';
    public $buscamin='';
    public $filtrocurso;
    public $filtroSede;
    public $filtroInides;
    public $filtroInihas;
    public $filtroinicia=[];
    public $filtrojornada;
    public $is_estudiantes=false;
    public $crt;


    protected $listeners = ['refresh' => '$refresh'];

    public function mount(){
        $this->claseFiltro(10);
        $this->cursillos();
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
                        'is_asistencias'
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

        if($act===0){
            $this->is_editing=!$this->is_editing;
        }else{
            $this->is_deleting=!$this->is_deleting;
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

    public function exportar(){
        return new AcaCicloExport(
                                    $this->buscamin,
                                    $this->filtroSede,
                                    $this->filtrocurso,
                                    $this->filtroinicia,
                                    $this->filtrojornada
                                );
    }

    public function verestudiantes($id){
        $this->reset('crt');
        $this->is_estudiantes=!$this->is_estudiantes;
        $this->crt=$id;
    }

    public function updatedFiltroInihas(){

        if($this->filtroInides<=$this->filtroInihas){

            $crea=array();
            array_push($crea, $this->filtroInides);
            array_push($crea, $this->filtroInihas);

            $this->filtroinicia=$crea;
        }else{
            $this->reset('filtroInides','filtroInihas');
        }
    }

    public function asistencia($cicloe,$grupo){
        $this->reset('ciclo','elegido');
        $this->cicloele=$cicloe;
        $this->elegido=$grupo;
        $this->is_asistencias=!$this->is_asistencias;
        $this->is_modify = !$this->is_modify;

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

    private function ciclos()
    {
        return Ciclo::buscar($this->buscamin)
                        ->sede($this->filtroSede)
                        ->curso($this->filtrocurso)
                        ->inicia($this->filtroinicia)
                        ->jornada($this->filtrojornada)
                        ->orderBy($this->ordena, $this->ordenado)
                        ->paginate($this->pages);

    }

    private function sedes(){
        return Ciclo::select('sede_id')
                        ->groupBy('sede_id')
                        ->get();
    }

    private function cursillos(){
        $registros = Ciclo::select('curso_id')
                            ->groupBy('curso_id')
                            ->get();

        $array=array();

        foreach ($registros as $value) {
            array_push($array,$value->curso_id);
        }

        $this->carga($array);


    }

    public function carga($array){
        $this->cursos=Curso::whereIn('id',$array)
                            ->orderBy('name')
                            ->get();
    }

    public function render()
    {
        return view('livewire.academico.ciclo.ciclos', [
            'ciclos'=> $this->ciclos(),
            'sedes'=>$this->sedes(),
        ]);
    }
}
