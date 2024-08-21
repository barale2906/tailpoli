<?php

namespace App\Livewire\Cartera\Cartera;

use App\Models\Financiera\Cartera;
use Carbon\Carbon;
use Livewire\Component;

class Consolidado extends Component
{
    public $activa;
    public $sesentaMen=0;
    public $treSenMen=0;
    public $treMen=0;

    public $sesentaMas=0;
    public $treSenMas=0;
    public $treMas=0;

    public $cobrohoy=0;


    public function mount(){
            $this->activa=Cartera::whereIn('status_est', [1,7,8])
                                    ->select('saldo','fecha_pago')
                                    ->orderBy('id', 'ASC')
                                    ->get();

            $this->carte();
        }

public function carte(){

    $date=Carbon::today();

    foreach ($this->activa as $value) {

        $diferencia=$date->diffInDays($value->fecha_pago, false);

        if($diferencia>0){

            $this->porCobrar($diferencia, $value->saldo);

        }else if($diferencia<0){

            $this->enMora($diferencia, $value->saldo);
        }

        if($diferencia===0){
            $this->cobrohoy=$this->cobrohoy+$value->saldo;
        }
    }
}

public function enMora($dif, $saldo){

    $limmenor=-60;
    $limedio=-30;

    if($dif<=$limmenor){

        $this->sesentaMen=$this->sesentaMen+$saldo;
    }

    if($dif>$limmenor && $dif<=$limedio){
        $this->treSenMen=$this->treSenMen+$saldo;
    }

    if($dif>$limedio){
        $this->treMen=$this->treMen+$saldo;
    }

}

public function porCobrar($dif, $saldo){
    $superior=61;
    $medio=31;

    if($dif>=$superior){
        $this->sesentaMas=$this->sesentaMas+$saldo;
    }

    if($dif>=$medio && $dif<$superior){
        $this->treSenMas=$this->treSenMas+$saldo;
    }

    if($dif<$medio){
        $this->treMas=$this->treMas+$saldo;
    }
}

    public function render()
    {
        return view('livewire.cartera.cartera.consolidado');
    }
}
