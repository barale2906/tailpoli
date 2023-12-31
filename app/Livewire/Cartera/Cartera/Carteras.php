<?php

namespace App\Livewire\Cartera\Cartera;

use App\Exports\CarCarteraExport;
use App\Models\Financiera\Cartera;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Carteras extends Component
{
    use WithPagination;

    public $ordena='id';
    public $ordenado='DESC';
    public $pages = 10;

    public $is_modify = true;
    public $is_creating = false;

    public $buscar='';
    public $buscamin='';

    protected $listeners = ['refresh' => '$refresh'];

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
    #[On('created')]
    //Mostrar formulario de creación
    public function updatedIsCreating()
    {
        $this->is_modify = !$this->is_modify;
        $this->is_creating = !$this->is_creating;
    }

    //Activar evento
    #[On('cancelando')]
    //Mostrar formulario de creación
    public function cancela()
    {
        $this->reset(
                        'is_modify',
                        'is_creating'
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

    private function carteras(){

        return Cartera::query()
                        ->with(['responsable', 'concepto_pago', 'estadoCartera'])
                        ->when($this->buscamin, function($query){
                            return $query->where('status', true)
                                    ->where('concepto', 'like', "%".$this->buscamin."%")
                                    ->orWhereHas('responsable', function($q){
                                        $q->where('name', 'like', "%".$this->buscamin."%")
                                            ->orwhere('documento', 'like', "%".$this->buscamin."%");
                                    })
                                    ->orWhereHas('concepto_pago', function($qu){
                                        $qu->where('name', 'like', "%".$this->buscamin."%");
                                    })
                                    ->orWhereHas('estadoCartera', function($que){
                                        $que->where('name', 'like', "%".$this->buscamin."%");
                                    });
                        })
                        ->orderBy($this->ordena, $this->ordenado)
                        ->paginate($this->pages);

    }

    public function render()
    {
        return view('livewire.cartera.cartera.carteras', [
            'carteras'=>$this->carteras()
        ]);
    }
}
