<?php

namespace App\Livewire\Inventario\Inventario;

use App\Exports\InvInventarioPendExport;
use App\Models\Inventario\Inventario;
use Livewire\Component;
use Livewire\WithPagination;

class Pendientes extends Component
{
    use WithPagination;

    public $ordena='fecha_movimiento';
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
        return new InvInventarioPendExport();
    }

    private function pendInventarios(){

        return Inventario::where('entregado', false)
                            ->join('users', 'inventarios.compra_id', '=', 'users.id')
                            ->orderBy($this->ordena, $this->ordenado)
                            ->paginate($this->pages);
    }

    public function render()
    {
        return view('livewire.inventario.inventario.pendientes',[

            'pendInventarios'=>$this->pendInventarios()
        ]);
    }
}
