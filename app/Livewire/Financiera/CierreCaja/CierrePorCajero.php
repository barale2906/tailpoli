<?php

namespace App\Livewire\Financiera\CierreCaja;

use App\Models\Financiera\CierreCaja;
use App\Models\Financiera\ConceptoPago;
use App\Models\Financiera\ReciboPago;
use App\Traits\ComunesTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class CierrePorCajero extends Component
{
    use ComunesTrait;

    public $sedes=[];
    public $unica;
    public $sede_id;
    public $agrupado;
    public $recibos;
    public $comentarios;
    public $dinero_entegado;
    public $valor_total=0;
    public $status=1;

    public $valor_pensiones=0;
    public $valor_efectivo=0;
    public $valor_tarjeta=0;
    public $valor_cheque=0;
    public $valor_consignacion=0;

    public $valor_otros=0;
    public $valor_efectivo_o=0;
    public $valor_tarjeta_o=0;
    public $valor_cheque_o=0;
    public $valor_consignacion_o=0;
    public $descuentosT=0;
    public $id_concepto;

    public $elegido;
    public $accion=2;

    public $ruta=1;

    public $print=false;

    public function mount ($ruta=null){
        $this->cierre();
        $this->id_concepto=ConceptoPago::where('name', 'Descuento')->first();
        $this->recibos=ReciboPago::where('creador_id', Auth::user()->id)
                                ->where('status', '!=', 1)
                                ->get();

        $this->ruta=$ruta;

        $this->sedeMas();
    }

    /**
     * Reglas de validación
     */
    protected $rules = [
        'dinero_entegado' => 'required',
        'valor_total'=>'required',
        'comentarios' => 'required'
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset('dinero_entegado', 'comentarios', 'valor_total');
    }

    public function sedeMas(){

        $this->agrupado=$this->recibos->groupBy('sede_id');

        if($this->agrupado->count()===1){
            $this->unica=ReciboPago::where('creador_id', Auth::user()->id)
                                        ->where('status', '!=', 1)
                                        ->first();

            $this->sede_id=$this->unica->sede_id;
            $this->updatedSedeId();
        }else{
            foreach ($this->recibos as $value) {
                $nuevo=[
                    'id'=>$value->sede->id,
                    'name'=>$value->sede->name,
                ];

                if(in_array($nuevo, $this->sedes)){

                }else{
                    array_push($this->sedes, $nuevo);
                }

            }
        }
    }

    public function updatedSedeId(){
        $this->reset('valor_total');
        $this->recibos=ReciboPago::where('status', 0)
                                    ->where('sede_id', $this->sede_id)
                                    ->where('creador_id', Auth::user()->id)
                                    ->get();
            $this->totalizar();

    }

    public function totalizar(){
        $this->valor_total=ReciboPago::where('sede_id', $this->sede_id)
                                        ->where('creador_id', Auth::user()->id)
                                        ->where('cierre', null)
                                        ->where('status', 0)
                                        ->sum('valor_total');

        $this->carteradet();
    }

    // Crear
    public function new(){

        // validate
        $this->validate();

        //Crear registro
        $cierre=CierreCaja::create([
                        'fecha_cierre'=>now(),
                        'fecha'=>now(),
                        'valor_total'=>$this->valor_total,
                        'valor_reportado'=>$this->dinero_entegado,
                        'efectivo'=>$this->valor_efectivo+$this->valor_efectivo_o,
                        'efectivo_descuento'=>$this->descefec,
                        'efectivo_disponible'=>$this->efectivoentrega,
                        'cobro_tarjeta'=>$this->valor_tarjeta,
                        'tarjeta'=>$this->tarjetaventa,
                        'descuentotal'=>$this->descuentosT,
                        'observaciones'=>$this->comentarios,

                        'valor_pensiones'=>$this->valor_pensiones,
                        'valor_efectivo'=>$this->valor_efectivo,
                        'valor_tarjeta'=>$this->valor_pensiones-$this->valor_efectivo-$this->valor_cheque-$this->valor_consignacion,
                        'valor_cheque'=>$this->valor_cheque,
                        'valor_consignacion'=>$this->valor_consignacion,

                        'valor_otros'=>$this->valor_otros,
                        'valor_efectivo_o'=>$this->valor_efectivo_o,
                        'valor_tarjeta_o'=>$this->valor_otros-$this->valor_efectivo_o-$this->valor_cheque_o-$this->valor_consignacion_o,
                        'valor_cheque_o'=>$this->valor_cheque_o,
                        'valor_consignacion_o'=>$this->valor_consignacion_o,

                        'sede_id'=>$this->sede_id,
                        'cajero_id'=>Auth::user()->id,
                        'coorcaja_id'=>Auth::user()->id
                    ]);

        //relacionar recibos
        foreach ($this->recibos as $value) {

            $this->status=2;

            //Actualizar recibo
            ReciboPago::whereId($value->id)->update([
                                    'status'=>$this->status,
                                    'cierre'=>$cierre->id
                                ]);

            //Cargar recibo al cierre
            DB::table('cierre_caja_recibo_pago')
            ->insert([
                'cierre_caja_id'=>$cierre->id,
                'recibo_pago_id'=>$value->id,
                'created_at'=>now(),
                'updated_at'=>now(),
            ]);
        }

        //Datos de impresión
        $this->elegido=$cierre;

        // Notificación
        $this->dispatch('alerta', name:'Se ha realizado correctamente el cierre de caja N°: '.$cierre->id);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->print=!$this->print;

        $ruta='/impresiones/impcierre?o='.$this->ruta.'&c='.$cierre->id;

        $this->redirect($ruta);

    }

    //volver
    #[On('volver')]
    public function vuelve(){
        $this->dispatch('created');
    }

    public function render()
    {
        return view('livewire.financiera.cierre-caja.cierre-por-cajero');
    }
}
