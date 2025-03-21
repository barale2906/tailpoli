<?php

namespace App\Livewire\Cartera\Cartera;

use App\Models\Academico\Matricula;
use App\Models\Financiera\Cartera;
use App\Models\Financiera\EstadoCartera;
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
    public $carterastatus=['vacio'];
    public $ids=[];
    public $recid=[];

    public $carterastate=true;
    public $recibostate=false;
    public $observaview=false;
    public $elegid;

    public function mount($alumno){
        $this->estadocartera();
        $this->matricu=Matricula::find($alumno);
        $this->fecha=now();
        //$this->matriculas();
        $this->alumnitem();
    }

    public function estadocartera(){

        $this->reset('carterastatus');
        $cartera=EstadoCartera::all();
        foreach ($cartera as $value) {
            array_push($this->carterastatus,$value->name);
        }
    }

    public function deuda(){
        $this->carteras=Cartera::where('matricula_id', $this->matricu->id)
                                ->get();

        $this->total=Cartera::where('estado_cartera_id', '<',5)
                        ->where('matricula_id', $this->matricu->id)
                        ->selectRaw('sum(saldo) as saldo, sum(valor) as valor')
                        ->groupBy('matricula_id')
                        ->first();

        $this->pagos();
    }

    public function pagos(){

        $this->reset('ids','recid');

        foreach ($this->carteras as $value) {
            array_push($this->ids,$value->id);
        }
        //dd('ids', $this->ids,'Conteo',count($this->ids));
        $i=0;
        for ($i=0; $i < count($this->ids); $i++) {
            $recibo=DB::table('concepto_pago_recibo_pago')
                        ->where('id_relacional',$this->ids[$i])
                        ->select('recibo_pago_id')
                        ->first();

            if($recibo){
                array_push($this->recid,$recibo->recibo_pago_id);
            }
        }

        $this->recibos=ReciboPago::whereIn('id', $this->recid)->get();
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
    }

    public function observ($id){
        $this->reset(
            'observaview',
            'elegid'
        );
        dd($id);
        if($id!==$this->elegid){
            $this->observaview=true;
            $this->elegid=$id;
        }
    }

    public function muestraObs($cartera)
    {
        dd($cartera);
    }
    public function render()
    {
        return view('livewire.cartera.cartera.detalle');
    }
}
