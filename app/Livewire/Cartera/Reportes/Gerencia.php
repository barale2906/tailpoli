<?php

namespace App\Livewire\Cartera\Reportes;

use App\Livewire\Reportes\Activos;
use App\Models\Academico\Control;
use App\Models\Configuracion\Estado;
use App\Models\Financiera\Cartera;
use App\Traits\FiltroTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Gerencia extends Component
{
    use FiltroTrait;

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
    public $estados=[];
    public $status_estu;
    public $controles;
    public $is_reporte=false;

    public $estado_estudiante;
    public $filtroSede;

    public function mount(){

        $this->claseFiltro(15);

        $this->reset('estados');

        $this->status_estu=Estado::all();

        array_push($this->estados,"Vacio");

        foreach ($this->status_estu as $value) {
            array_push($this->estados,$value->name);
        }
    }

    private function controles(){
        $controles = Control::whereNotIn('status_est',[11])
                        ->sede($this->filtroSede)
                        ->status($this->estado_estudiante)
                        ->get();

        $this->estuactivo();

        return $controles;
    }

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

        $this->activos=Cartera::select('sede_id', 'status_est', DB::raw('count(matricula_id) as total_estado'), DB::raw('SUM(saldo) as total_saldo'), DB::raw('SUM(valor) as total_saldo_inicial'), DB::raw('SUM(status_est) as estados'))
                                ->groupBy('sede_id', 'status_est')
                                ->whereNotIn('status_est',[11])
                                ->status($this->estado_estudiante)
                                //->whereBetween('fecha_pago',[$this->inicia,$this->finaliza])
                                ->where('estado_cartera_id', '<',5)
                                ->orderBy('sede_id','ASC')
                                ->get();

        $this->is_reporte=true;
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

    private function sedes(){
        return Cartera::where('estado_cartera_id', '<',5)
                        ->select('sede_id')
                        ->groupBy('sede_id')
                        ->get();
    }

    public function render()
    {
        return view('livewire.cartera.reportes.gerencia',[
            'elegianos' =>$this->elegiano(),
            'sedes'     =>$this->sedes(),
            'controles' =>$this->controles(),
        ]);
    }
}
