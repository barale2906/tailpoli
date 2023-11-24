<?php

namespace App\Livewire\Cartera\Cartera;

use App\Models\Financiera\Cartera;
use App\Models\Financiera\ConceptoPago;
use App\Models\Financiera\EstadoCartera;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Convenio extends Component
{
    public $cartera;
    public $responsables=[];
    public $responsable_id;
    public $deudas;
    public $total;

    public $contado=true;
    public $valor_inicial;
    public $saldo;
    public $cuotas;
    public $valor_cuota;
    public $descripcion;
    public $matricula_id;

    public $fecha;
    public $hoy;
    public $dia;
    public $elegible=[];

    public function mount(){
        DB::table('apoyo_recibo')
            ->where('id_creador', Auth::user()->id)
            ->delete();
        $this->cartera=Cartera::Where('status', true)
                                ->get();

        $this->hoy=now();
        $this->hoy=date('Y-m-d');

        $this->filtrar();
        $this->dias();
    }

    public function dias(){
        for ($i=1; $i <= 30; $i++) {
            array_push($this->elegible, $i);
        }
    }

    public function filtrar(){
        foreach ($this->cartera as $value) {
            $esta=DB::table('apoyo_recibo')->where('id_producto', $value->responsable_id)->count();

            //Cargar usuario a la tabla de apoyo
            if($esta===0){
                DB::table('apoyo_recibo')->insert([
                    'tipo'          =>'cartera',
                    'id_creador'    =>Auth::user()->id,
                    'valor'         =>0,
                    'id_producto'   =>$value->responsable_id,
                    'producto'      =>$value->responsable->name,
                    'almacen'       =>$value->responsable->documento
                ]);
            }
        }

        $this->ordenar();
    }

    public function ordenar(){
        $this->responsables=DB::table('apoyo_recibo')
                                ->where('id_creador', Auth::user()->id)
                                ->orderBy('producto', 'ASC')
                                ->get();
    }

    public function updatedResponsableId(){
        $this->deudas=Cartera::where('responsable_id', $this->responsable_id)
                            ->where('status', true)
                            ->get();

        $this->total=Cartera::where('responsable_id', $this->responsable_id)
                            ->where('status', true)
                            ->sum('saldo');
    }

    public function updatedContado(){
        if($this->contado){
            $this->valor_inicial=$this->total;
            $this->cuotas=0;
            $this->valor_cuota=0;
            $this->dia=1;
        }
    }

    //Activa cuotas
    public function calcuCuota(){

        if($this->total>$this->valor_inicial){
            $this->saldo=$this->total-$this->valor_inicial;
        }

        if($this->total<$this->valor_inicial){
            $this->dispatch('alerta', name:'La inicial debe ser menor al valor del curso.');
            $this->reset(
                'cuotas',
                'valor_cuota',
            );
        }
    }

    // Calculo de las cuotas
    public function calcula(){
        if($this->cuotas>0 && $this->total>$this->valor_inicial){
            $saldo = $this->total-$this->valor_inicial;
            $this->valor_cuota=round($saldo/$this->cuotas, 2);
        }
    }

    /**
     * Reglas de validación
     */
    protected $rules = [
        'total'             => 'required|min:1',
        'valor_inicial'     => 'required|min:1',
        'cuotas'            => 'required|integer',
        'valor_cuota'       => 'required|min:1',
        'descripcion'       => 'required',
        'fecha'             => 'required|date|after_or_equal:hoy',
        'dia'               => 'required|min:1|max:30'
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
                        'total',
                        'valor_inicial',
                        'cuotas',
                        'valor_cuota',
                        'descripcion',
                        'saldo',
                        'fecha',
                        'dia'
                    );
    }

    public function crea(){

        // validate
        $this->validate();

        //anular todos
        //Cargar convenio
        $estado=EstadoCartera::where('name', 'convenio')
                                ->where('status', true)
                                ->first();

        foreach ($this->deudas as $value) {
            $obser=now()." ".Auth::user()->name." --- ANULADO POR CONVENIO DE PAGO --- ".$value->observaciones;
            $this->matricula_id=$value->matricula_id;
            Cartera::whereId($value->id)
                    ->update([
                        'status'        =>false,
                        'estado_cartera_id' =>$estado->id,
                        'observaciones' =>$obser
                    ]);

        }

        //Cargar convenio
        $concepto=ConceptoPago::where('name', 'Inicial convenio')
                                ->where('status', true)
                                ->first();

        Cartera::create([
            'fecha_pago'=>$this->fecha,
            'valor'=>$this->valor_inicial,
            'saldo'=>$this->valor_inicial,
            'observaciones'=>'--- CONVENIO PAGO --- primera cuota de un convenio por: '.$this->total." -- ".$this->descripcion,
            'matricula_id'=>$this->matricula_id,
            'concepto_pago_id'=>$concepto->id,
            'concepto'=>$concepto->name,
            'responsable_id'=>$this->responsable_id,
            'estado_cartera_id'=>1
        ]);

        //Cargar nueva cartera
        //Cuotas
        $concepto=ConceptoPago::where('name', 'Convenio mes')
                                ->where('status', true)
                                ->first();

        $year = now();
        $year = date('Y');
        $mes =now();
        $mes= date('m');
        $date=Carbon::create($year, $mes, $this->dia);
        if($this->cuotas>0){
            $a=1;
            while ($a <= $this->cuotas) {

                $endDate = $date->addMonths();

                Cartera::create([
                    'fecha_pago'=>$endDate,
                    'valor'=>$this->valor_cuota,
                    'saldo'=>$this->valor_cuota,
                    'observaciones'=>'--- CONVENIO PAGO ---'.$a. ' cuota mensual de un convenio por: '.$this->total." -- ".$this->descripcion,
                    'matricula_id'=>$this->matricula_id,
                    'concepto_pago_id'=>$concepto->id,
                    'concepto'=>$concepto->name,
                    'responsable_id'=>$this->responsable_id,
                    'estado_cartera_id'=>1
                ]);

                $a++;
            }

        }

        // Notificación
        $this->dispatch('alerta', name:'Se ha creado correctamente el convenio de pago.');
        $this->resetFields();

        $this->redirect('/financiera/recibopagos');
    }

    public function render(){
        return view('livewire.cartera.cartera.convenio');
    }
}
