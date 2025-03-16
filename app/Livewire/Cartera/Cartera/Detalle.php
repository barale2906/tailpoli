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
        $this->matricu=Matricula::find($alumno);
        $this->fecha=now();
        //$this->matriculas();
        $this->alumnitem();
    }

    public function deuda(){
        $this->carteras=Cartera::where('matricula_id', $this->matricu->id)
                                ->get();

        $this->total=Cartera::where('estado_cartera_id', '<',5)
                        ->where('matricula_id', $this->matricu->id)
                        ->selectRaw('sum(saldo) as saldo, sum(valor) as valor')
                        ->groupBy('matricula_id')
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

    public function alumnitem(){
        $this->actual=User::find($this->matricu->alumno_id);

        $this->deuda();
        $this->pagos();
    }


    public function render()
    {
        return view('livewire.cartera.cartera.detalle');
    }
}
