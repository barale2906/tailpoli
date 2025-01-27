<?php

namespace App\Livewire\Inventario\Inventario;

use App\Models\Inventario\Almacen;
use App\Models\Inventario\Inventario;
use App\Models\Inventario\Producto;
use Livewire\Component;

class Saldos extends Component
{
    public $existencias;
    public $almacenes;
    public $productos;
    public $ids=[];

    public function mount(){
        $this->existencias=Inventario::where('status',true)->get();
        $this->obtealma();
    }

    public function obtealma(){
        $this->reset('ids');
        $almacenes=Inventario::where('status',true)
                                ->select('almacen_id')
                                ->groupBy('almacen_id')
                                ->get();

        foreach ($almacenes as $value) {
            array_push($this->ids,$value->almacen_id);
        }
        $this->almaNombres();
    }

    Public function almaNombres(){
        $this->almacenes=Almacen::whereIn('id',$this->ids)
                                    ->orderBy('name','ASC')
                                    ->get();

        $this->obteprod();
    }

    public function obteprod(){
        $this->reset('ids');
        $productos=Inventario::where('status',true)
                                ->select('producto_id')
                                ->groupBy('producto_id')
                                ->get();

        foreach ($productos as $value) {
            array_push($this->ids,$value->producto_id);
        }
        $this->prodNombres();
    }

    public function prodNombres(){
        $this->productos=Producto::whereIn('id',$this->ids)
                                    ->orderBy('name', 'ASC')
                                    ->get();
    }


    public function render()
    {
        return view('livewire.inventario.inventario.saldos');
    }
}
