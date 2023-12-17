<?php

namespace App\Livewire\Cliente\Crm;

use App\Models\Clientes\Crm;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Crms extends Component
{
    use WithPagination;

    public $ordena='fecha';
    public $ordenado='ASC';
    public $pages = 15;

    public $elegido;

    public $is_modify = true;
    public $is_creating = false;
    public $is_editing=false;
    public $is_charge=false;

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
    #[On('cancelando')]
    //Mostrar formulario de creación
    public function cancela()
    {
        $this->reset(
                        'is_modify',
                        'is_creating',
                        'is_editing',
                        'is_charge',
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

    //Activar evento
    #[On('cargando')]
    //Mostrar formulario de inactivación
    public function updatedIsCharge()
    {
        $this->is_modify = !$this->is_modify;
        $this->is_charge = !$this->is_charge;
    }

    public function crms()
    {
        return Crm::query()
                        ->with(['sector', 'gestiona'])
                        ->when($this->buscamin, function($query){
                            return $query->where('fecha', 'like', "%".$this->buscamin."%")
                                    ->where('mes', 'like', "%".$this->buscamin."%")
                                    ->where('curso', 'like', "%".$this->buscamin."%")
                                    ->where('name', 'like', "%".$this->buscamin."%")
                                    ->where('historial', 'like', "%".$this->buscamin."%")
                                    ->orWhereHas('gestiona', function($q){
                                        $q->where('name', 'like', "%".$this->buscamin."%");
                                    })
                                    ->orWhereHas('sector', function($qu){
                                        $qu->where('name', 'like', "%".$this->buscamin."%");
                                    });
                        })
                        ->orderBy($this->ordena, $this->ordenado)
                        ->paginate($this->pages);
    }

    public function render()
    {
        return view('livewire.cliente.crm.crms',[
            'crms'=>$this->crms(),
        ]);
    }
}
