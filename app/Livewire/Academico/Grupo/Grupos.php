<?php

namespace App\Livewire\Academico\Grupo;

use App\Exports\AcaGrupoExport;
use App\Models\Academico\Curso;
use App\Models\Academico\Grupo;
use App\Models\Academico\Modulo;
use App\Traits\FiltroTrait;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Grupos extends Component
{
    use WithPagination;
    use FiltroTrait;

    public $ordena='id';
    public $ordenado='DESC';
    public $pages = 10;

    public $is_modify = true;
    public $is_creating = false;
    public $is_editing = false;
    public $is_deleting = false;

    public $elegido;

    public $buscar='';
    public $buscamin='';
    public $filtrocurso;

    public $idsCurso=[];
    public $idsModulo=[];
    public $cursos;

    protected $listeners = ['refresh' => '$refresh'];

    public function mount(){
        $this->claseFiltro(2);

        $modulos=Grupo::select('modulo_id')
                        ->groupBy('modulo_id')
                        ->get();


        foreach ($modulos as $value) {

            $curso=Modulo::find($value->modulo_id);

            if(in_array($curso->curso->id, $this->idsCurso)){

            }else{
                array_push($this->idsCurso, $curso->curso->id);
            }
        }

        $this->cursoObten();
    }

    public function cursoObten(){
        $this->cursos=Curso::whereIn('id', $this->idsCurso)
                            ->orderBY('name', 'ASC')
                            ->get();
    }

    public function updatedFiltrocurso(){
        $curso=Curso::find($this->filtrocurso);

        foreach ($curso->modulos as $value) {
            if(in_array($value->id, $this->idsModulo)){

            }else{
                array_push($this->idsModulo, $value->id);
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
    #[On('created')]
    //Mostrar formulario de creación
    public function updatedIsCreating()
    {
        $this->is_modify = !$this->is_modify;
        $this->is_creating = !$this->is_creating;
        $this->mount();
    }

    //Activar evento
    #[On('Editando')]
    //Mostrar formulario de creación
    public function updatedIsEditing()
    {
        $this->is_modify = !$this->is_modify;
        $this->is_editing = !$this->is_editing;
    }

    // Mostrar Regimen de Salud
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
        return new AcaGrupoExport($this->buscamin);
    }

    private function grupos()
    {
        $consulta = Grupo::query();

        if($this->buscamin){
            $consulta = $consulta->orWhereHas('modulo', function(Builder $q){
                $q->where('name', 'like', "%".$this->buscamin."%");
            })
            ->orWhereHas('profesor', function($qu){
                $qu->where('name', 'like', "%".$this->buscamin."%");
            })
            ->orWhereHas('sede', function($que){
                $que->where('name', 'like', "%".$this->buscamin."%");
            });
        }

        if($this->filtrocurso){
            $consulta=$consulta->whereIn('modulo_id', $this->idsModulo);
        }

        return $consulta->orderBy($this->ordena, $this->ordenado)
                        ->paginate($this->pages);

    }

    public function render()
    {
        return view('livewire.academico.grupo.grupos', [
            'grupos'=> $this->grupos(),
        ]);
    }
}



