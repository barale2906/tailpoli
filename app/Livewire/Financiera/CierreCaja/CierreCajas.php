<?php

namespace App\Livewire\Financiera\CierreCaja;

use App\Models\Financiera\CierreCaja;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class CierreCajas extends Component
{
    use WithPagination;

    public $ordena='id';
    public $ordenado='ASC';
    public $pages = 10;

    public $is_modify = true;
    public $is_creating = false;
    public $is_deleting = false;
    public $is_watching = false;

    public $elegido;
    public $accion;

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
    #[On('created')]
    //Mostrar formulario de creación
    public function updatedIsCreating()
    {
        $this->is_modify = !$this->is_modify;
        $this->is_creating = !$this->is_creating;
    }

    // Mostrar Regimen de Salud
    public function show($esta, $act){

        $this->elegido=$esta;
        $this->is_modify = !$this->is_modify;
        $this->accion=$act;

        switch ($act){
            case 0:
                $this->is_deleting=!$this->is_deleting;
                break;

            case 1:
                $this->is_watching=!$this->is_watching;
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

    //Activar evento
    #[On('watched')]
    //Mostrar pantalla de impresión
    public function updatedIsWatching()
    {
        $this->is_modify = !$this->is_modify;
        $this->is_watching = !$this->is_watching;
    }

    private function cierres()
    {
        return CierreCaja::orderBy($this->ordena, $this->ordenado)
                    ->paginate($this->pages);
    }

    public function render()
    {
        return view('livewire.financiera.cierre-caja.cierre-cajas', [
            'cierres'=>$this->cierres(),
        ]);
    }
}
