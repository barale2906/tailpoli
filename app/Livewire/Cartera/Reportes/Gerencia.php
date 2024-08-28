<?php

namespace App\Livewire\Cartera\Reportes;

use App\Livewire\Reportes\Activos;
use App\Models\Financiera\Cartera;
use Carbon\Carbon;
use Livewire\Component;

class Gerencia extends Component
{
    public $mes;
    public $anio;
    public $activos;
    public $moractivos;
    public $inician;
    public $matriculas;
    public $desertados;
    public $reintegran;
    public $inicia;
    public $finaliza;
    public $is_reporte=false;



    public function limpiar(){
        $this->reset(
            'is_reporte',
            'activos',
            'moractivos',
            'inician',
            'matriculas',
            'desertados',
            'reintegran',
            'inicia',
            'finaliza',
        );
    }

    public function updatedAnio(){
        $this->limpiar();
        $this->reset('mes');
    }

    public function updatedMes(){
        $this->limpiar();
        $this->limites();
    }

    public function limites(){
        $dias=Carbon::create($this->anio,$this->mes,1)->daysInMonth;
        $fechain=Carbon::create($this->anio,$this->mes,1);
        $fechafin=Carbon::create($this->anio,$this->mes,$dias,23,59,59);
        $this->inicia=$fechain->format('Y-m-d H:i:s');
        $this->finaliza=$fechafin->format('Y-m-d H:i:s');
        $this->estuactivo();
    }

    public function estuactivo(){
        $this->activos=


        Cartera::selectRaw('sum(saldo) as saldo, sum(valor) as original,sede_id')
                                ->groupBy('sede_id')
                                ->whereBetween('fecha_pago',[$this->inicia,$this->finaliza])
                                ->where('estado_cartera_id', '<',5)
                                ->get();
    }

    private function elegiano(){
        $ini=2019;
        $hoy=Carbon::now()->year;
        $diferencia=$hoy-$ini;
        $anos=array();

        for ($i=0; $i <= $diferencia; $i++) {
            $reg=$hoy-$i;
            array_push($anos,$reg);
        }

        return $anos;
    }

    public function render()
    {
        return view('livewire.cartera.reportes.gerencia',[
            'elegianos' =>$this->elegiano(),
        ]);
    }
}
