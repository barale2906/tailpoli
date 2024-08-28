<?php

namespace App\Livewire\Cartera\Cartera;

use App\Models\Academico\Matricula;
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
    public $matricu;
    public $fecha;

    public $carterastate=true;
    public $recibostate=false;

    public function mount($alumno){
        $this->actual=User::find($alumno);
        $this->fecha=now();
        $this->deuda();
        $this->pagos();
        $this->matriculas();
    }

    public function deuda(){
        $this->carteras=Cartera::where('responsable_id', $this->actual->id)
                                ->get();

        $this->total=Cartera::where('estado_cartera_id', '<',5)
                        ->where('responsable_id', $this->actual->id)
                        ->selectRaw('sum(saldo) as saldo, sum(valor) as valor')
                        ->groupBy('responsable_id')
                        ->first();
    }

    public function pagos(){
        $this->recibos=ReciboPago::where('paga_id', $this->actual->id)->get();
    }

    public function cambiaVista(){
        $this->carterastate=!$this->carterastate;
        $this->recibostate=!$this->recibostate;
    }

    public function matriculas(){
        $this->matricu=Matricula::where('alumno_id', $this->actual->id)
                                ->get();
    }


    public function render()
    {
        return view('livewire.cartera.cartera.detalle');
    }
}
