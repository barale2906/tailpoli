<?php

namespace App\Livewire\Cartera\Cartera;

use App\Models\Financiera\Cartera;
use App\Models\Financiera\ReciboPago;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Detalle extends Component
{
    public $actual;
    public $carteras;
    public $total;
    public $recibos;

    public function mount($alumno){
        $this->actual=User::find($alumno);
        $this->deuda();
        $this->pagos();
    }

    public function deuda(){
        $this->carteras=Cartera::where('status', true)
                                ->where('responsable_id', $this->actual->id)
                                ->get();

        $this->total=DB::table('carteras')
                        ->where('responsable_id', $this->actual->id)
                        ->selectRaw('sum(saldo) as saldo, sum(valor) as valor')
                        ->groupBy('responsable_id')
                        ->first();
    }

    public function pagos(){
        $this->recibos=ReciboPago::where('paga_id', $this->actual->id)->get();
    }


    public function render()
    {
        return view('livewire.cartera.cartera.detalle');
    }
}
