<?php

namespace App\Livewire\Academico\Matricula;

use App\Exports\AcaMatriculaExport;
use App\Models\Academico\Matricula;
use App\Models\User;
use App\Traits\FiltroTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
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
                        'is_document'
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
            $this->filtroestatumatri=true;
        }else if($crt===0){
            $this->filtroestatumatri=false;
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
        return new AcaMatriculaExport($this->buscamin);
    }

    public function mount(){
        $this->claseFiltro(1);

        $creadores=Matricula::select('creador_id')
                                    ->groupBy('creador_id')
                                    ->get();
        foreach ($creadores as $value) {
            array_push($this->matriculo, $value->creador_id);
        }

        $this->genComerci();
    }

    public function genComerci(){
        $comerciales=Matricula::select('comercial_id')
        ->groupBy('comercial_id')
        ->get();

            foreach ($comerciales as $value) {
            array_push($this->comercial, $value->comercial_id);
            }
    }

    private function matriculas()
    {
        $consulta = Matricula::query();

        if($this->buscamin){
            $consulta = $consulta->orWhereHas('alumno', function(Builder $q){
                $q->where('name', 'like', "%".$this->buscamin."%")
                    ->orWhere('documento', 'like', "%".$this->buscamin."%");
            })
            ->orWhereHas('grupos', function($qu){
                $qu->where('name', 'like', "%".$this->buscamin."%");
            })
            ->orWhereHas('curso', function($que){
                $que->where('name', 'like', "%".$this->buscamin."%");
            })
            ->orWhereHas('sede', function($quer){
                $quer->where('name', 'like', "%".$this->buscamin."%");
            });
        }

        if($this->filtromatri){
            $consulta = $consulta->where('creador_id', $this->filtromatri);
        }

        if($this->filtrocom){
            $consulta = $consulta->where('comercial_id', $this->filtrocom);
        }

        if($this->filtroestatumatri){

            $consulta = $consulta->where('status', $this->filtroestatumatri);
        }

        if($this->filtroCreades && $this->filtroCreahas){
            $fecha1=Carbon::parse($this->filtroCreades);
            $fecha2=Carbon::parse($this->filtroCreahas);
            $fecha2->addSeconds(86399);
            $consulta = $consulta->whereBetween('created_at', [$fecha1 , $fecha2]);
        }

        if($this->filtroInides && $this->filtroInihas){
            $consulta = $consulta->whereBetween('fecha_inicia', [$this->filtroInides , $this->filtroInihas]);
        }

        return $consulta->orderBy($this->ordena, $this->ordenado)
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

    public function render()
    {
        return view('livewire.academico.matricula.matriculas', [
            'matriculas'        => $this->matriculas(),
            'usuMatriculo'      => $this->usuMatriculo(),
            'usuComercial'      => $this->usuComercial(),
        ]);
    }
}
