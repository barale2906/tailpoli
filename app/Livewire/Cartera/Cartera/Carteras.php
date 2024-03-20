<?php

namespace App\Livewire\Cartera\Cartera;

use App\Exports\CarCarteraExport;
use App\Models\Financiera\Cartera;
use App\Traits\FiltroTrait;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Carteras extends Component
{
    use WithPagination;
    use FiltroTrait;

    public $ordena='responsable_id';
    public $ordenado='DESC';
    public $pages = 10;

    public $alumno;

    public $is_modify = true;
    public $is_creating = false;
    public $is_cartera=false;

    public $buscar='';
    public $buscamin='';

    public $filtroVendes;
    public $filtroVenhas;
    public $filtroven=[];

    protected $listeners = ['refresh' => '$refresh'];

    public function mount(){
        $this->claseFiltro(9);
    }

    public function updatedFiltroVenhas(){
        if($this->filtroVendes<=$this->filtroVenhas){
            $crea=array();
            array_push($crea, $this->filtroVendes);
            array_push($crea, $this->filtroVenhas);
            $this->filtroven=$crea;
        }else{
            $this->reset('filtroVendes','filtroVenhas');
        }
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
    public function cancela(){

        $this->reset(
                        'is_modify',
                        'is_creating',
                        'is_cartera',
                        'alumno'
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

    public function exportar(){
        return new CarCarteraExport($this->buscamin);
    }

    public function show($alumno,$est){
        $this->alumno=$alumno;
        $this->is_modify=!$this->is_modify;
        switch ($est) {
            case 0:
                $this->is_cartera=!$this->is_cartera;
                break;

            case 1:
                $this->is_creating = !$this->is_creating;
                break;
        }

    }

    private function carteras(){

        return Cartera::where('status',true)
                        ->selectRaw('sum(saldo) as saldo, matricula_id, responsable_id')
                        ->groupBy('matricula_id','responsable_id')
                        ->buscar($this->buscamin)
                        ->vencido($this->filtroven)
                        ->orderBy($this->ordena, $this->ordenado)
                        ->paginate($this->pages);

    }

    private function total(){
        return Cartera::where('status', true)
                        ->buscar($this->buscamin)
                        ->vencido($this->filtroven)
                        ->sum('saldo');

    }

    public function render()
    {
        return view('livewire.cartera.cartera.carteras', [
            'carteras'  =>$this->carteras(),
            'total'     =>$this->total()
        ]);
    }
}
