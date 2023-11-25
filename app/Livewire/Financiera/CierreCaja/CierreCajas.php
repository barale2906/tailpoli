<?php

namespace App\Livewire\Financiera\CierreCaja;

use App\Exports\FinCierreCajaExport;
use App\Models\Financiera\CierreCaja;
use App\Traits\FiltroTrait;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class CierreCajas extends Component
{
    use WithPagination;
    use FiltroTrait;

    public $ordena='id';
    public $ordenado='ASC';
    public $pages = 10;

    public $is_modify = true;
    public $is_creating = false;
    public $is_deleting = false;
    public $is_watching = false;
    public $is_desbloqueo=false;

    public $elegido;
    public $accion;

    public $buscar='';
    public $buscamin='';
    public $filtroCreades;
    public $filtroCreahas;

    protected $listeners = ['refresh' => '$refresh'];

    public function mount(){
        $this->claseFiltro(4);
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

    //Activar evento
    #[On('cancelando')]
    //Mostrar formulario de creación
    public function cancela()
    {
        $this->reset(
                        'is_modify',
                        'is_creating',
                        'is_editing',
                        'is_deleting',
                        'is_watching',
                        'is_desbloqueo'
                    );
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

    //Activar evento
    #[On('desbloqueando')]
    //Mostrar pantalla de impresión
    public function updatedIsDesbloquear()
    {
        $this->is_modify = !$this->is_modify;
        $this->is_desbloqueo = !$this->is_desbloqueo;
    }

    public function exportar(){
        return new FinCierreCajaExport();
    }

    private function cierres()
    {
        $consulta = CierreCaja::query();

        if($this->buscamin){
            $consulta = $consulta->where('fecha', 'like', "%".$this->buscamin."%")
            ->orwhere('observaciones', 'like', "%".$this->buscamin."%")
            ->orWhereHas('cajero', function(Builder $q){
                $q->where('name', 'like', "%".$this->buscamin."%");
            })->orWhereHas('sede', function($qu){
                $qu->where('name', 'like', "%".$this->buscamin."%");
            });
        }

        if($this->filtroCreades && $this->filtroCreahas){

            $consulta = $consulta->whereBetween('fecha', [$this->filtroCreades , $this->filtroCreahas]);
        }

        return $consulta->orderBy($this->ordena, $this->ordenado)
                        ->paginate($this->pages);
    }

    public function render()
    {
        return view('livewire.financiera.cierre-caja.cierre-cajas', [
            'cierres'=>$this->cierres(),
        ]);
    }
}
