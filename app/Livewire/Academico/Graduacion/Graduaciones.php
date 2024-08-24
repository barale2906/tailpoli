<?php

namespace App\Livewire\Academico\Graduacion;

use App\Models\Academico\Control;
use App\Models\Academico\Curso;
use App\Models\Configuracion\Estado;
use App\Models\Configuracion\Sede;
use App\Traits\FiltroTrait;
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
    public $crtid;

    public $buscar='';
    public $buscamin='';
    public $filtroSede;
    public $filtrocurso;
    public $filtroInides;
    public $filtroInihas;
    public $filtroinicia=[];

    public $sedesids=[];
    public $cursosids=[];

    protected $listeners = ['refresh' => '$refresh'];

    public function mount(){
        $this->claseFiltro(13);
        $this->obtenerids();
    }

    public function obtenerids(){
        $sedes=Control::whereNotIn('status_est',[2,4,9,11])
                        ->select('sede_id')
                        ->groupBy('sede_id')
                        ->get();

        foreach ($sedes as $value) {
            array_push($this->sedesids,$value->sede_id);
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
                    );
    }

    private function singrados(){
        return Control::whereNotIn('status_est',[2,4,9,11])
                        ->buscar($this->buscamin)
                        ->sede($this->filtroSede)
                        ->curso($this->filtrocurso)
                        ->inicia($this->filtroinicia)
                        ->orderBy($this->ordena, $this->ordenado)
                        ->paginate($this->pages);
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

    public function render()
    {
        return view('livewire.academico.graduacion.graduaciones',[
            'singrados' => $this->singrados(),
            'estados'   => $this->estados(),
            'cursos'    => $this->cursos(),
            'asignadas' => $this->asignadas(),
        ]);
    }
}
