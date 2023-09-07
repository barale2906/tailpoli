<?php

namespace App\Livewire\Admin\Multi;

use App\Models\Admin\PersonaMulticultural;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Personamulti extends Component
{
    use WithPagination;

    public $ordena='id';
    public $ordenado='ASC';
    public $pages = 10;

    public $is_modify = true;
    public $is_creating = false;
    public $is_editing = false;
    public $is_deleting = false;

    protected $listeners = ['refresh' => '$refresh'];

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
    #[On('created-multi')]
    //Mostrar formulario de creación
    public function updatedIsCreating()
    {
        $this->is_modify = !$this->is_modify;
        $this->is_creating = !$this->is_creating;
    }

    private function personMultis()
    {
        return PersonaMulticultural::orderBy($this->ordena, $this->ordenado)
                                    ->paginate($this->pages);
    }
    public function render()
    {
        return view('livewire.admin.multi.personamulti', [
            'personMultis' => $this->personMultis()
        ]);
    }
}
