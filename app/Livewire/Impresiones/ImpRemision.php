<?php

namespace App\Livewire\Impresiones;

use App\Models\Inventario\Inventario;
use App\Models\User;
use Livewire\Attributes\Url;
use Livewire\Component;

class ImpRemision extends Component
{
    #[Url(as: 'r')]
    public $alumno='';

    #[Url(as: 'rut')]
    public $ruta='';

    #[Url(as: 'fecha')]
    public $fecha='';

    public $url;

    public $alumnoDeta;
    public $obtener;
    public $sede;

    public function mount(){

        $this->fecha=date("Y-m-d");

        $this->alumnoDeta=User::find($this->alumno);

        $this->obtener=Inventario::where('compra_id', $this->alumno)
                                    ->where('entregado', true)
                                    ->where('tipo', 0)
                                    ->where('fecha_movimiento', $this->fecha)
                                    ->get();

        $this->sede=Inventario::where('compra_id', $this->alumno)
                                    ->where('entregado', true)
                                    ->where('tipo', 0)
                                    ->where('fecha_movimiento', $this->fecha)
                                    ->first();


        switch ($this->ruta) {

            case 1:
                $this->url="/inventario/inventarios";
                break;

            case 2:
                $this->url="/academico/gestion";
                break;

        }
    }


    public function render()
    {
        return view('livewire.impresiones.imp-remision');
    }
}
