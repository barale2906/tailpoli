<?php

namespace App\Traits;
use App\Exports\FinReciboExport;
use App\Models\Financiera\ReciboPago;
use App\Models\User;
use App\Traits\FiltroTrait;
use Illuminate\Support\Facades\DB;
/* use Illuminate\Database\Eloquent\Builder; */
use Livewire\Attributes\On;
/* use Livewire\Component; */
use Livewire\WithPagination;


trait ReciboCajaTrait
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
    public $is_poliandino=true;
    public $is_logo='img/logo.jpeg';

    public $accion;

    public $elegido;

    public $buscar='';
    public $buscamin='';
    public $filtroCreades;
    public $filtroCreahas;
    public $filtroSede;
    public $filtrocrea=[];
    public $filtroTransdes;
    public $filtroTranshas;
    public $filtrotrans=[];
    public $filtromedio;
    public $filtrocajero;

    //protected $listeners = ['refresh' => '$refresh'];

    public function eligeempresa(){

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
        return new FinReciboExport($this->buscamin, $this->filtroSede, $this->filtrocrea,$this->is_poliandino,$this->is_logo,$this->filtrotrans,$this->filtromedio,$this->filtrocajero);
    }

    public function empresa(){
        $this->is_poliandino=!$this->is_poliandino;
        $this->logos();
    }

    public function logos(){
        if($this->is_poliandino){
            $this->is_logo='img/logo.jpeg';
        }else{
            $this->is_logo='img/logopol.jpg';
        }
    }

    public function updatedFiltroCreahas(){
        if($this->filtroCreades<=$this->filtroCreahas){
            $crea=array();
            array_push($crea, $this->filtroCreades);
            array_push($crea, $this->filtroCreahas);
            $this->filtrocrea=$crea;
        }else{
            $this->dispatch('alerta', name:'Fecha de inicio debe ser menor a fecha fin');
        }
    }

    public function updatedFiltroTranshas(){
        if($this->filtroTransdes<=$this->filtroTranshas){
            $tra=array();
            array_push($tra, $this->filtroTransdes);
            array_push($tra, $this->filtroTranshas);
            $this->filtrotrans=$tra;
        }else{
            $this->dispatch('alerta', name:'Fecha de inicio debe ser menor a fecha fin');
        }
    }

    private function recibos()
    {
        return ReciboPago::where('origen', $this->is_poliandino)
                            ->buscar($this->buscamin)
                            ->sede($this->filtroSede)
                            ->crea($this->filtrocrea)
                            ->transaccion($this->filtrotrans)
                            ->medio($this->filtromedio)
                            ->cajero($this->filtrocajero)
                            ->orderBy($this->ordena, $this->ordenado)
                            ->paginate($this->pages);

    }

    private function recibosTotal(){

        return ReciboPago::where('origen', $this->is_poliandino)
                            //->where('status', '!=', 2)
                            ->buscar($this->buscamin)
                            ->sede($this->filtroSede)
                            ->crea($this->filtrocrea)
                            ->transaccion($this->filtrotrans)
                            ->medio($this->filtromedio)
                            ->cajero($this->filtrocajero)
                            ->select(
                                DB::raw('SUM(valor_total) as total_valor_total'),
                                DB::raw('SUM(descuento) as total_descuento')
                            )
                            ->first();

        $valorTotal = $total->total_valor_total ?? 0;
        $descuentoTotal = $total->total_descuento ?? 0;

        return [
            'total_valor_total' => $valorTotal,
            'total_descuento' => $descuentoTotal,
        ];
    }

    private function cajeros(){
        $cajeros=ReciboPago::select('creador_id')
                            ->groupBy('creador_id')
                            ->get();
        $ids=array();
        foreach ($cajeros as $value) {
            array_push($ids,$value->creador_id);
        }

        return User::whereIn('id',$ids)
                    ->orderBy('name', 'ASC')
                    ->get();
    }

    private function sedes(){
        return ReciboPago::select('sede_id')
                        ->groupBy('sede_id')
                        ->get();
    }

}
