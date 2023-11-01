<?php

namespace App\Livewire\Academico\Estudiante;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Estudiantes extends Component
{
    use WithPagination;

    public $ordena='name';
    public $ordenado='ASC';
    public $pages = 15;

    public $is_modify = true;
    public $is_creating = false;
    public $is_editing = false;
    public $is_deleting = false;
    public $is_perfil=false;

    public $elegido;
    public $clase=1;
    public $perf=0;

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
    #[On('Perfilando')]
    //Mostrar formulario de creación
    public function updatedIsPerfil()
    {
        $this->is_modify = !$this->is_modify;
        $this->is_perfil = !$this->is_perfil;
    }

    // Mostrar Regimen de Salud
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
                $this->is_perfil=!$this->is_perfil;
                break;

            case 3:
                $this->is_perfil=true;
                $this->is_modify = false;
                $this->reset('is_editing', 'is_deleting','is_creating');
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

    private function usuarios()
    {
        return User::where('name', 'like', "%".$this->buscamin."%")
                        ->orWhere('documento', 'like', "%".$this->buscamin."%")
                        ->orwhere('email', 'like', "%".$this->buscamin."%")
                        ->orderBy($this->ordena, $this->ordenado)
                        ->with('roles')->get()->filter(
                            fn ($user) => $user->roles->where('name', 'Estudiante')->toArray()
                        );
                        //->paginate($this->pages);
    }

    public function render()
    {
        return view('livewire.academico.estudiante.estudiantes', [
            'usuarios' => $this->usuarios()
        ]);
    }
}
