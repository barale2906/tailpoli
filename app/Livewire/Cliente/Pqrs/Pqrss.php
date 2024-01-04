<?php

namespace App\Livewire\Cliente\Pqrs;

use App\Models\Clientes\Pqrs;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Pqrss extends Component
{
    use WithPagination;

    public $ordena='status';
    public $ordenado='ASC';
    public $pages = 15;

    public $is_modify = true;
    public $is_creating = false;
    public $is_editing=false;

    public $buscar='';
    public $buscamin='';
    public $todo=false;

    public $elegido;
    public $origen=1;

    public function mount($origen=null){

        if($origen){
            $this->origen=$origen;
        }
    }

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
    #[On('cancelando')]
    //Mostrar formulario de creación
    public function cancela()
    {
        $this->reset(
                        'is_modify',
                        'is_creating',
                        'is_editing',
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
    public function show($esta){

        $this->elegido=$esta;
        $this->is_modify = !$this->is_modify;
        $this->is_editing = !$this->is_editing;

    }

    private function registros(){
        if($this->origen===3){
            return Pqrs::where('estudiante_id', Auth::user()->id)
                        ->where('opcion', '>', 1)
                        ->orderBy($this->ordena, $this->ordenado)
                        ->paginate($this->pages);
        }else{
            return Pqrs::query()
                        ->with(['estudiante','gestion'])
                        ->when($this->buscamin, function($query){
                            return $query->where('fecha', 'like', "%".$this->buscamin."%")
                                    ->orWhere('observaciones', 'like', "%".$this->buscamin."%")
                                    ->orWhereHas('estudiante', function($qu){
                                        $qu->where('name', 'like', "%".$this->buscamin."%");
                                    })
                                    ->orWhereHas('gestion', function($qu){
                                        $qu->where('name', 'like', "%".$this->buscamin."%");
                                    });
                        })
                        ->orderBy($this->ordena, $this->ordenado)
                        ->paginate($this->pages);
        }

    }

    public function render()
    {
        return view('livewire.cliente.pqrs.pqrss',[
            'registros'=>$this->registros(),
        ]);
    }
}
