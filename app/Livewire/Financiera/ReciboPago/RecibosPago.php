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
    public $is_reporte=true;

    public $accion;

    public $elegido;

    public $buscar='';
    public $buscamin='';
    public $filtroCreades;
    public $filtroCreahas;
    public $filtroSede;
    public $filtrocrea=[];

    protected $listeners = ['refresh' => '$refresh'];

    public function mount($reporte=null){
        $this->claseFiltro(3);
        if($reporte){
            $this->is_reporte=false;
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
        return ReciboPago::where('origen', 1)
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

    public function render()
    {
        return view('livewire.financiera.recibo-pago.recibos-pago', [
            'recibos'=>$this->recibos(),
            'sedes'=>$this->sedes(),
        ]);
    }
}


