<?php

namespace App\Livewire\Academico\Nota;

use App\Models\Academico\Nota;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Notas extends Component
{
    use WithPagination;

    public $ordena='id';
    public $ordenado='DESC';
    public $pages = 10;

    public $is_modify = true;
    public $is_creating = false;
    public $is_editing = false;
    public $is_asistencia = false;
    public $act;

    public $filtroprofesor;
    public $filtrojornada;


    public $elegido;

    public $buscar='';
    public $buscamin='';

    protected $listeners = ['refresh' => '$refresh'];

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
    }

    //Activar evento
    #[On('Editando')]
    //Mostrar formulario de creación
    public function updatedIsEditing()
    {
        $this->is_modify = !$this->is_modify;
        $this->is_editing = !$this->is_editing;
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
                        //'is_deleting',
                        'is_asistencia'
                    );
    }


    //Activar evento
    #[On('Asistiendo')]
    //Mostrar formulario de creación
    public function updatedIsAsistencia()
    {
        $this->is_modify = !$this->is_modify;
        $this->is_asistencia = !$this->is_asistencia;
    }

    // Mostrar
    public function show($esta){

        $this->elegido=$esta;
        $this->is_modify = !$this->is_modify;
        $this->is_editing=!$this->is_editing;
    }

    // Mostrar
    public function asistencia($esta){

        $this->elegido=$esta;
        $this->is_modify = !$this->is_modify;
        $this->is_asistencia=!$this->is_asistencia;
    }

    private function notas()
    {
        return Nota::buscar($this->buscamin)
                        ->profesor(intval($this->filtroprofesor))
                        ->jornada(intval($this->filtrojornada))
                        ->orderBy($this->ordena, $this->ordenado)
                        ->paginate($this->pages);
    }

    private function profesores(){
        return User::where('rol_id',5)
                    ->orderBy('name','ASC')
                    ->get();
    }

    public function render()
    {
        return view('livewire.academico.nota.notas',[
            'notas'=>$this->notas(),
            'profesores'=>$this->profesores()
        ]);
    }
}
