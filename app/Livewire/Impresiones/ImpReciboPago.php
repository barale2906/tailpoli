<?php

namespace App\Livewire\Impresiones;

use App\Models\Academico\Matricula;
use App\Models\Financiera\Cartera;
use App\Models\Financiera\ReciboPago;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Url;
use Livewire\Component;

class ImpReciboPago extends Component
{
    #[Url(as: 'r')]
    public $recibo='';

    #[Url(as: 'rut')]
    public $ruta='';
    public $url;

    public $obtener;
    public $detalles;
    public $matriculas;
    public $total;
    public $saldo;

    public function mount(){
        $this->obtener=ReciboPago::whereId($this->recibo)->first();

        $this->obteDetalles();

        switch ($this->ruta) {
            case 0:
                $this->url="/financiera/recibopagos";
                break;

            case 1:
                $this->url="/academico/matriculas";
                break;

            case 2:
                $this->url="/academico/gestion";
                break;

            case 3:
                $this->url="/inventario/inventarios";
                break;

            case 4:
                $this->url="/financiera/transacciones";
                break;

        }
    }

    public function obteDetalles(){
        $this->detalles=DB::table('concepto_pago_recibo_pago')
                                    ->where('concepto_pago_recibo_pago.recibo_pago_id',$this->recibo)
                                    ->join('concepto_pagos', 'concepto_pago_recibo_pago.concepto_pago_id', '=', 'concepto_pagos.id')
                                    ->select('concepto_pagos.name', 'concepto_pago_recibo_pago.valor', 'concepto_pago_recibo_pago.tipo', 'concepto_pago_recibo_pago.id_relacional')
                                    ->get();

        $this->obteTotal();
    }

    public function obteTotal(){

        $this->matriculas=Matricula::where('alumno_id', $this->obtener->paga_id)
                                ->where('status', true)
                                ->get();

        $this->obteSaldo();
    }

    public function obteSaldo(){
        $this->saldo=Cartera::where('responsable_id', $this->obtener->paga_id)
                        ->where('status', true)
                        ->get();

        $this->total=$this->matriculas->sum('valor');
        $this->saldo=$this->saldo->sum('saldo');

    }



    public function render()
    {
        return view('livewire.impresiones.imp-recibo-pago');
    }
}
