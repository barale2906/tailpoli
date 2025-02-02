<?php

namespace App\Livewire\Inventario\Inventario;

use App\Exports\InvSaldoExport;
use App\Models\Inventario\Almacen;
use App\Models\Inventario\Inventario;
use App\Models\Inventario\Producto;
use Exception;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Saldos extends Component
{
    public $existencias;
    public $almacenes;
    public $productos;
    public $ids=[];
    public $totales=[];

    public function mount(){
        //$this->existencias=Inventario::where('status',true)->get();
        $this->obtealma();
        //$this->obtetotal();
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
        $this->obtetotales();
    }

    public function obtetotales(){

        foreach ($this->productos as $value) {
            $this->reset('existencias');

            $row=[
                'producto'=>$value->name
            ];
            foreach ($this->almacenes as $alma) {
                $this->existencias=Inventario::where('status', true)
                                        ->where('producto_id', $value->id)
                                        ->where('almacen_id', $alma->id)
                                        ->first();

                if($this->existencias){
                    $row[$alma->id]=$this->existencias->saldo;
                    //Log::info('HABIA producto: ' . $value->name.' almacén: '.$alma->name.' SAldo: '.$this->existencias->saldo);
                }else{
                    $row[$alma->id]=0;
                    //Log::info('SIN producto: ' . $value->name.' almacén: '.$alma->name);
                }
            }
            array_push($this->totales,$row);
        }
    }

    public function exportar(){
        return new InvSaldoExport($this->totales,$this->almacenes,$this->ids);
    }


    public function render()
    {
        return view('livewire.inventario.inventario.saldos');
    }
}
