<?php

namespace App\Livewire\Financiera\ReciboPago;

use App\Exports\FinReciboExport;
use App\Models\Financiera\ReciboPago;
use App\Traits\FiltroTrait;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class RecibosPago extends Component
{
    use WithPagination;
    use FiltroTrait;

    public $ordena='id';
    public $ordenado='DESC';
    public $pages = 10;

    public $is_modify = true;
    public $is_creating = false;
    public $is_editing = false;
    public $is_deleting = false;

    public $accion;

    public $elegido;

    public $buscar='';
    public $buscamin='';
    public $filtroCreades;
    public $filtroCreahas;

    protected $listeners = ['refresh' => '$refresh'];

    public function mount(){
        $this->claseFiltro(3);
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
    #[On('cancelando')]
    //Mostrar formulario de creación
    public function cancela()
    {
        $this->reset(
                        'is_modify',
                        'is_creating',
                        'is_editing',
                        'is_deleting'
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

    // Mostrar Regimen de Salud
    public function show($esta, $act){

        $this->elegido=$esta;
        $this->is_modify = !$this->is_modify;

        $this->accion=$act;

        if($act===0 || $act===2){
            $this->is_editing=!$this->is_editing;
        }else{
            $this->is_deleting=!$this->is_deleting;
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
        return new FinReciboExport($this->buscamin);
    }

    private function recibos()
    {
        $consulta = ReciboPago::query()->where('origen', 1);

        if($this->buscamin){
            $consulta = $consulta->where('fecha', 'like', "%".$this->buscamin."%")
            ->orwhere('medio', 'like', "%".$this->buscamin."%")
            ->orwhere('observaciones', 'like', "%".$this->buscamin."%")
            ->orWhereHas('creador', function(Builder $q){
                $q->where('name', 'like', "%".$this->buscamin."%");
            })->orWhereHas('paga', function($qu){
                $qu->where('name', 'like', "%".$this->buscamin."%");
            })
            ->orWhereHas('conceptos', function($que){
                $que->where('name', 'like', "%".$this->buscamin."%");
            })
            ->orWhereHas('sede', function($que){
                $que->where('name', 'like', "%".$this->buscamin."%");
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
        return view('livewire.financiera.recibo-pago.recibos-pago', [
            'recibos'=>$this->recibos(),
        ]);
    }
}


