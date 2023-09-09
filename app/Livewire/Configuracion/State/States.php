<?php

namespace App\Livewire\Configuracion\State;

use App\Models\Configuracion\State;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class States extends Component
{
    public $name = '';
    public $id = '';
    public $country;

    public $ordena='id';
    public $ordenado='ASC';
    public $pages = 10;

    public $is_modify = true;
    public $is_creating = false;
    public $is_editing = false;
    public $is_deleting = false;

    public $elegido;

    use WithPagination;

    protected $listeners = ['refresh' => '$refresh'];

    public function mount($country = null)
    {
        $this->name=$country['name'];
        $this->id=$country['id'];
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
    #[On('createdSub')]
    //Mostrar formulario de creación
    public function updatedIsCreating()
    {
        $this->is_modify = !$this->is_modify;
        $this->is_creating = !$this->is_creating;
    }

    //Activar evento
    #[On('EditandoSub')]
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
    #[On('InactivandoSub')]
    //Mostrar formulario de inactivación
    public function updatedIsDeleting()
    {
        $this->is_modify = !$this->is_modify;
        $this->is_deleting = !$this->is_deleting;
    }

    private function states()
    {
        return State::where('country_id', $this->id)
                    ->orderBy($this->ordena, $this->ordenado)
                    ->paginate($this->pages);
    }



    public function render()
    {
        return view('livewire.configuracion.state.states', [
            'states' => $this->states()
        ]);
    }
}
