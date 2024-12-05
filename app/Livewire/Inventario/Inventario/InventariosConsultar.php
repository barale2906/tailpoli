<?php

namespace App\Livewire\Inventario\Inventario;

use App\Models\Inventario\Inventario;
use App\Traits\CrtStatusTrait;
use Livewire\Component;

class InventariosConsultar extends Component
{
    use CrtStatusTrait;

    public $id='';
    public $actual;


    public $saldostate=true;
    public $almacenstate=false;

    public function mount($elegido = null)
    {
        $this->actual=Inventario::find($elegido);
    }

    public function cambiaVista(){
        $this->saldostate=!$this->saldostate;
        $this->almacenstate=!$this->almacenstate;
    }

    private function saldos(){
        return Inventario::where('status', true)
                        ->where('producto_id', $this->actual->producto_id)
                        ->get();
    }



    public function render()
    {
        return view('livewire.inventario.inventario.inventarios-consultar', [
            'saldos'=>$this->saldos(),
        ]);
    }
}
