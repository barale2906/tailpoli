<?php

namespace App\Livewire\Inventario\Inventario;

use App\Exports\InvInventarioExport;
use App\Models\Inventario\Inventario;
use App\Models\Inventario\Almacen;
use App\Traits\CrtStatusTrait;
use App\Traits\FiltroTrait;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Inventarios extends Component
{
    use WithPagination;
    use FiltroTrait;
    use CrtStatusTrait;

    public $ordena='status';
    public $ordenado='DESC';
    public $pages = 10;

    public $is_modify = true;
    public $is_creating = false;
    public $is_editing = false;
    public $is_deleting = false;
    public $is_saldos = false;

    public $elegido;

    public $buscar='';
    public $buscamin='';
    public $filtroCreades;
    public $filtroCreahas;
    public $filtrocrea=[];
    public $filtrotipo;
    public $valorFiltrotipo;
    public $filtrosaldo=false;
    public $Saldofiltro;
    public $filtroalmacen;

    public $tipo=[];

    protected $listeners = ['refresh' => '$refresh'];

    public function mount(){
        $this->claseFiltro(5);
        $this->tipos();
    }

    public function tipos(){
        $this->tipo=[
            ["id"=>"1", "nombre"=>"Sálida"],
            ["id"=>"2", "nombre"=>"Entrada"],
            ["id"=>"3", "nombre"=>"Pendiente"]
        ];
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
                        'is_saldos'
                    );
    }

    public function updatedFiltrotipo(){
        switch ($this->filtrotipo) {
            case '1':
                $this->valorFiltrotipo=0;
                break;

            case '2':
                $this->valorFiltrotipo=1;
                break;

            case '3':
                $this->valorFiltrotipo=2;
                break;
        }
    }

    public function updatedSaldofiltro(){
        if($this->Saldofiltro==="si"){
            $this->filtrosaldo=true;
        }
        if($this->Saldofiltro==="no"){
            $this->filtrosaldo=false;
        }
    }

    // Mostrar Regimen de Salud
    public function show($esta, $act){

        $this->elegido=$esta;
        $this->is_modify = !$this->is_modify;

        if($act===0){
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

    public function exportar(){
        return new InvInventarioExport($this->buscamin,$this->filtrocrea,$this->valorFiltrotipo,$this->filtroalmacen,$this->filtrosaldo);
    }

    public function saldosTotales(){
        $this->cancela();
        $this->is_modify=false;
        $this->is_saldos=true;
    }

    private function inventarios()
    {
        return Inventario::buscar($this->buscamin)
                            ->crea($this->filtrocrea)
                            ->tipo($this->valorFiltrotipo)
                            ->almacen($this->filtroalmacen)
                            ->saldo($this->filtrosaldo)
                            ->orderBy($this->ordena, $this->ordenado)
                            ->orderBy('id', 'DESC')
                            ->paginate($this->pages);
    }

    private function almacenes(){
        $almac=Inventario::buscar($this->buscamin)
                                ->crea($this->filtrocrea)
                                ->tipo($this->valorFiltrotipo)
                                ->saldo($this->filtrosaldo)
                                ->select('almacen_id')
                                ->groupBy('almacen_id')
                                ->get();

        $ids=array();
        foreach ($almac as $value) {
            array_push($ids,$value->almacen_id);
        }

        return Almacen::whereIn('id',$ids)
                        ->orderBy('name', 'ASC')
                        ->get();
    }

    public function render()
    {
        return view('livewire.inventario.inventario.inventarios', [
            'inventarios'   => $this->inventarios(),
            'almacenes'     =>$this->almacenes(),
        ]);
    }
}
