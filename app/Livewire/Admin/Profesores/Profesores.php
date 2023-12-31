<?php

namespace App\Livewire\Admin\Profesores;

use App\Exports\AdmProfesorExport;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Profesores extends Component
{
    use WithPagination;

    public $ordena='name';
    public $ordenado='ASC';
    public $pages = 20;

    public $is_modify = true;
    public $is_creating = false;
    public $is_editing = false;
    public $is_deleting = false;

    public $elegido;
    public $clase=2;

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
        return new AdmProfesorExport($this->buscamin);
    }

    private function usuarios()
    {
        $consulta = User::query();

        if($this->buscamin){
            $consulta = $consulta->where('name', 'like', "%".$this->buscamin."%")
            ->orwhere('email', 'like', "%".$this->buscamin."%")
            ->orwhere('documento', 'like', "%".$this->buscamin."%");
        }

        return $consulta->orderBy($this->ordena, $this->ordenado)
                        ->paginate($this->pages);

        /* return User::where('name', 'like', "%".$this->buscamin."%")
                        ->orWhere('documento', 'like', "%".$this->buscamin."%")
                        ->orwhere('email', 'like', "%".$this->buscamin."%")
                        ->orderBy($this->ordena, $this->ordenado)
                        ->with('roles')->get()->filter(
                            fn ($user) => $user->roles->where('name', 'Profesor')->toArray()
                        ); */
                        //->paginate($this->pages);
    }

    public function render()
    {
        return view('livewire.admin.profesores.profesores', [
            'usuarios' => $this->usuarios()
        ]);
    }
}
