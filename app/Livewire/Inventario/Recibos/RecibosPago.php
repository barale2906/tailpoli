<?php

namespace App\Livewire\Inventario\Recibos;

use App\Models\Financiera\ReciboPago;
use App\Traits\FiltroTrait;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

class RecibosPago extends Component
{
    use WithPagination;
    use FiltroTrait;

    public $ordena='id';
    public $ordenado='DESC';
    public $pages = 10;

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

    private function recibos()
    {
        $consulta = ReciboPago::query()->where('origen', 0);

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
        return view('livewire.inventario.recibos.recibos-pago',[
            'recibos'=>$this->recibos()
        ]);
    }
}
