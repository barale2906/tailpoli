<?php

namespace App\Livewire\Configuracion\Sector;

use App\Models\Configuracion\Sector;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Sectors extends Component
{
    public $name = '';
    public $id = '';
    public $depto;

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

    public function mount($depto = null)
    {
        $this->name=$depto['name'];
        $this->id=$depto['id'];
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
    #[On('createdSubd')]
    //Mostrar formulario de creación
    public function updatedIsCreating()
    {
        $this->is_modify = !$this->is_modify;
        $this->is_creating = !$this->is_creating;
    }

    //Activar evento
    #[On('EditandoSubd')]
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
    #[On('InactivandoSubd')]
    //Mostrar formulario de inactivación
    public function updatedIsDeleting()
    {
        $this->is_modify = !$this->is_modify;
        $this->is_deleting = !$this->is_deleting;
    }

    private function sectors()
    {
        return Sector::where('state_id', $this->id)
                    ->orderBy($this->ordena, $this->ordenado)
                    ->paginate($this->pages);
    }

    public function render()
    {
        return view('livewire.configuracion.sector.sectors', [
            'sectors' => $this->sectors()
        ]);
    }
}
