<?php

namespace App\Livewire\Inventario\Inventario;

use App\Models\Inventario\Almacen;
use App\Models\Inventario\Inventario;
use Livewire\Component;
use Livewire\WithPagination;

class InventariosSede extends Component
{
    use WithPagination;

    public $producto;
    public $detalle;
    public $almacen='';
    public $tipos=['SALIDA','ENTRADA','PENDIENTE','TRASLADO'];

    public $ordena='status';
    public $ordenado='DESC';
    public $pages = 10;

    public function mount($producto = null)
    {
        //dd($producto['almacen']['id']);
        $this->producto = $producto;

    }



    public function alma($item){

        $this->almacen=$item;
    }

    private function almacenes(){
        return Almacen::query()
                        ->whereHas('inventarios' , function($q){
                            $q->where('status', true)
                                ->where('producto_id', $this->producto['producto']['id'] );
                        })
                        ->orderBy('name')
                        ->get();
    }

    private function inventarios()
    {
        return Inventario::where('producto_id', $this->producto['producto']['id'])
                            ->where('almacen_id', $this->almacen)
                            ->orderBy($this->ordena, $this->ordenado)
                            ->orderBy('id', 'DESC')
                            ->paginate($this->pages);
    }

    public function render()
    {
        return view('livewire.inventario.inventario.inventarios-sede', [
            'almacenes'=>$this->almacenes(),
            'inventarios'=>$this->inventarios()
        ]);
    }
}
