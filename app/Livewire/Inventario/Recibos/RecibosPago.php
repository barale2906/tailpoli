<?php

namespace App\Livewire\Inventario\Recibos;

/* use App\Models\Financiera\ReciboPago;
use App\Traits\FiltroTrait;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder; */
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use App\Traits\ReciboCajaTrait;

class RecibosPago extends Component
{
    use ReciboCajaTrait;

    public function mount($reporte=null){
        $this->empresa();
        $this->claseFiltro(3);
        if($reporte){
            $this->is_reporte=false;
        }
    }


    /*
    use WithPagination;
    use FiltroTrait;

    public $ordena='id';
    public $ordenado='DESC';
    public $pages = 10;

    public $buscar='';
    public $buscamin='';
    public $filtroCreades;
    public $filtroCreahas;
    public $filtroSede;
    public $filtrocrea=[];
    public $is_poliandino=false;

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

    public function updatedFiltroCreahas(){
        if($this->filtroCreades<=$this->filtroCreahas){
            $crea=array();
            array_push($crea, $this->filtroCreades);
            array_push($crea, $this->filtroCreahas);
            $this->filtrocrea=$crea;
        }else{
            $this->reset('filtroCreades','filtroCreahas');
        }
    }

    private function recibos()
    {
        return ReciboPago::where('origen', $this->is_poliandino)
                            ->buscar($this->buscamin)
                            ->sede($this->filtroSede)
                            ->crea($this->filtrocrea)
                            ->orderBy($this->ordena, $this->ordenado)
                            ->paginate($this->pages);

    }

    private function sedes(){
        return ReciboPago::select('sede_id')
                        ->groupBy('sede_id')
                        ->get();
    }
 */
    public function render()
    {
        return view('livewire.inventario.recibos.recibos-pago',[
            'recibos'=>$this->recibos(),
            'sedes'=>$this->sedes(),
            'recibosTotal'=>$this->recibosTotal(),
            'cajeros'=>$this->cajeros(),
        ]);
    }
}
