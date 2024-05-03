<?php

namespace App\Livewire\Financiera\Transaccion;

use App\Models\Financiera\Transaccion;
use App\Traits\FiltroTrait;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

class Transacciones extends Component
{
    use WithPagination;
    use FiltroTrait;

    public $ordena='status';
    public $ordenado='ASC';
    public $pages = 15;

    public $is_modify = true;
    public $is_editing = false;

    public $elegido;

    public $buscar='';
    public $buscamin='';
    public $estado;
    public $id_estado;

    protected $listeners = ['refresh' => '$refresh'];

    public function mount(){
        $this->claseFiltro(7);
    }

    //Buscar por estado
    public function updatedEstado(){
        $this->reset('id_estado');
        $this->id_estado=intval($this->estado);
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
                        'is_editing'
                    );
    }

    //Activar evento
    #[On('Editando')]
    //Mostrar formulario de creación
    public function updatedIsEditing()
    {
        $this->is_modify = !$this->is_modify;
        $this->is_editing = !$this->is_editing;
    }

    // Gestionar
    public function show($esta){

        $this->elegido=$esta;
        $this->is_modify = !$this->is_modify;
        $this->is_editing=!$this->is_editing;

    }

    private function transacciones()
    {
        $consulta = Transaccion::query();

        if($this->buscamin){
            $consulta = $consulta->where('fecha', 'like', "%".$this->buscamin."%")
            ->orwhere('observaciones', 'like', "%".$this->buscamin."%")

            ->orWhereHas('creador', function(Builder $q){
                $q->where('name', 'like', "%".$this->buscamin."%");
            })
            ->orWhereHas('gestionador', function(Builder $q){
                $q->where('name', 'like', "%".$this->buscamin."%");
            })
            ->orWhereHas('alumno', function($qu){
                $qu->where('name', 'like', "%".$this->buscamin."%");
            })
            ->orWhereHas('sede', function($que){
                $que->where('name', 'like', "%".$this->buscamin."%");
            });
        }

        if($this->id_estado){
            $consulta=$consulta->where('status', $this->id_estado);
        }

        return $consulta->orderBy($this->ordena, $this->ordenado)
                        ->paginate($this->pages);

    }

    public function render()
    {
        return view('livewire.financiera.transaccion.transacciones',[
            'transacciones' => $this->transacciones()
        ]);
    }
}
