<?php

namespace App\Livewire\Inventario\Inventario;

use App\Exports\InvInventarioExport;
use App\Models\Inventario\Inventario;
use App\Traits\FiltroTrait;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Inventarios extends Component
{
    use WithPagination;
    use FiltroTrait;

    public $ordena='status';
    public $ordenado='DESC';
    public $pages = 10;

    public $is_modify = true;
    public $is_creating = false;
    public $is_editing = false;
    public $is_deleting = false;

    public $elegido;

    public $buscar='';
    public $buscamin='';
    public $filtroCreades;
    public $filtroCreahas;
    public $filtrotipo;
    public $valorFiltrotipo;

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

    public function exportar(){
        return new InvInventarioExport($this->buscamin);
    }

    private function inventarios()
    {
        $consulta = Inventario::query();

        if($this->buscamin){
            $consulta = $consulta->where('descripcion', 'like', "%".$this->buscamin."%")
            ->orwhere('fecha_movimiento', 'like', "%".$this->buscamin."%")
            ->orWhereHas('producto', function($q){
                $q->where('name', 'like', "%".$this->buscamin."%");
            })
            ->orWhereHas('almacen', function($qu){
                $qu->where('name', 'like', "%".$this->buscamin."%");
            })
            ->orWhereHas('user', function($que){
                $que->where('name', 'like', "%".$this->buscamin."%");
            });
        }

        if($this->filtroCreades && $this->filtroCreahas){

            $consulta = $consulta->whereBetween('fecha_movimiento', [$this->filtroCreades , $this->filtroCreahas]);
        }

        if($this->filtrotipo){

            $consulta = $consulta->where('tipo', $this->valorFiltrotipo);
        }

        return $consulta->orderBy($this->ordena, $this->ordenado)
                        ->paginate($this->pages);
    }

    public function render()
    {
        return view('livewire.inventario.inventario.inventarios', [
            'inventarios' => $this->inventarios()
        ]);
    }
}
