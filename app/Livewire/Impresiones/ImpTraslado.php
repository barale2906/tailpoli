<?php

namespace App\Livewire\Impresiones;

use App\Models\Inventario\Inventario;
use Livewire\Attributes\Url;
use Livewire\Component;

class ImpTraslado extends Component
{
    #[Url(as: 'tras')]
    public $traslado='';

    #[Url(as: 'rut')]
    public $ruta='';

    public $url;
    public $documento;
    public $envia;
    public $sedenv;
    public $envDireccion;
    public $recibe;
    public $recDireccion;
    public $sederec;
    public $fecha;

    public function mount(){
        switch ($this->ruta) {

            case 1:
                $this->url="/inventario/inventarios";
                break;

            default:
                $this->url="/academico/gestion";
                break;

        }

        $this->registro();
    }

    public function registro(){

        $this->documento=Inventario::where('traslado', $this->traslado)
                                    ->whereNotNull('envia')
                                    ->get();

        $this->almacenes();
    }

    public function almacenes(){
        $envia=Inventario::where('traslado', $this->traslado)
                            ->whereNotNull('envia')
                            ->groupBy('envia', 'almacen_id', 'fecha_movimiento')
                            ->select('envia', 'almacen_id', 'fecha_movimiento')
                            ->first();

        $this->envia=$envia->almacen->name;
        $this->fecha=$envia->fecha_movimiento;
        $this->envDireccion=$envia->almacen->sede->address;
        $this->sedenv=$envia->almacen->sede->name;

        $recibe=Inventario::where('traslado', $this->traslado)
                            ->whereNotNull('recibe')
                            ->groupBy('recibe', 'almacen_id')
                            ->select('recibe', 'almacen_id')
                            ->first();

        $this->recibe=$recibe->almacen->name;
        $this->recDireccion=$recibe->almacen->sede->address;
        $this->sederec=$recibe->almacen->sede->name;
    }

    public function render()
    {
        return view('livewire.impresiones.imp-traslado');
    }
}
