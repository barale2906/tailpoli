<?php

namespace App\Livewire\Configuracion\User;

use App\Exports\ConfUserExport;
use App\Models\User;
use App\Traits\FiltroTrait;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class Users extends Component
{
    use WithPagination;
    use FiltroTrait;

    public $ordena='id';
    public $ordenado='ASC';
    public $pages = 20;

    public $is_modify = true;
    public $is_creating = false;
    public $is_editing = false;
    public $is_deleting = false;
    public $is_perfil=false;

    public $impresion=1;

    public $elegido;
    public $clase=0;
    public $perf=0;

    public $buscar='';
    public $buscamin='';
    public $filtrorol;

    protected $listeners = ['refresh' => '$refresh'];

    public function mount(){
        $this->claseFiltro(6);
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
        return new ConfUserExport($this->buscamin);
    }

    private function usuarios()
    {
        $consulta = User::query();

        if(!$this->filtrorol){
            if($this->buscamin){
                $consulta = $consulta->where('name', 'like', "%".$this->buscamin."%")
                ->orwhere('email', 'like', "%".$this->buscamin."%")
                ->orwhere('documento', 'like', "%".$this->buscamin."%");
            }

            return $consulta->orderBy($this->ordena, $this->ordenado)
                        ->paginate($this->pages);

        }else{
            return User::where('name', 'like', "%".$this->buscamin."%")
                        ->orWhere('documento', 'like', "%".$this->buscamin."%")
                        ->orwhere('email', 'like', "%".$this->buscamin."%")
                        ->orderBy($this->ordena, $this->ordenado)
                        ->with('roles')->get()->filter(
                            fn ($user) => $user->roles->where('name', $this->filtrorol)->toArray()
                        );
        }




    }

    private function roles(){
        return Role::all();
    }

    public function render()
    {
        return view('livewire.configuracion.user.users', [
            'usuarios'  => $this->usuarios(),
            'roles'     => $this->roles(),
        ]);
    }
}
