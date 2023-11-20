<?php

namespace App\Livewire\Inventario\Inventario;

use App\Models\Inventario\Inventario;
use Livewire\Component;
use Livewire\WithPagination;

class Pendientes extends Component
{
    use WithPagination;

    public $ordena='status';
    public $ordenado='DESC';
    public $pages = 10;

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
        return new InvInventarioExport();
    }

    private function pendInventarios(){

        return Inventario::where('entregado', false)
                            ->orderBy($this->ordena, $this->ordenado)
                            ->orderBy('id', 'DESC')
                            ->paginate($this->pages);
    }

    public function render()
    {
        return view('livewire.inventario.inventario.pendientes',[

            'pendInventarios'=>$this->pendInventarios()
        ]);
    }
}
