<?php

namespace App\Livewire\Admin\Salud;

use App\Models\Admin\RegimenSalud as AdminRegimenSalud;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class RegimenSalud extends Component
{
    public $is_modify = true;
    public $is_creating = false;
    public $is_editing = false;
    public $is_deleting = false;

    public $regimenElegido;
    public $buscar='';
    public $buscamin='';

    public $ordena='id';
    public $ordenado='ASC';
    public $pages = 10;

    use WithPagination;

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

    // Muestra los regimenes activos
    private function regimenes()
    {
        return AdminRegimenSalud::where('name', 'like', "%".$this->buscamin."%")
                                ->orderBy($this->ordena, $this->ordenado)
                                ->paginate($this->pages);
    }

    //Numero de registros
    public function paginas($valor)
    {
        $this->resetPage();
        $this->pages=$valor;
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

    //Activar evento
    #[On('created-regimen')]
    //Mostrar formulario de creación
    public function updatedIsCreating()
    {
        $this->is_modify = !$this->is_modify;
        $this->is_creating = !$this->is_creating;
    }

    //Activar evento
    #[On('Editando-regimen')]
    //Mostrar formulario de creación
    public function updatedIsEditing()
    {
        $this->is_modify = !$this->is_modify;
        $this->is_editing = !$this->is_editing;
    }

    //Activar evento
    #[On('Inactivando-regimen')]
    //Mostrar formulario de inactivación
    public function updatedIsDeleting()
    {
        $this->is_modify = !$this->is_modify;
        $this->is_deleting = !$this->is_deleting;
    }

    // Mostrar Regimen de Salud
    public function showRegimen($regimen, $act){

        $this->regimenElegido=$regimen;
        $this->is_modify = !$this->is_modify;

        if($act===0){
            $this->is_editing=!$this->is_editing;
        }else{
            $this->is_deleting=!$this->is_deleting;
        }
    }

    public function render()
    {
        return view('livewire.admin.salud.regimen-salud', [
            'regimenes' => $this->regimenes()
        ]);
    }
}
