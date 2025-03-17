<?php

namespace App\Livewire\Cartera\Cartera;

use App\Models\Academico\Control;
use App\Models\Academico\Matricula;
use App\Models\Clientes\Pqrs;
use App\Models\Financiera\Cartera;
use App\Models\Financiera\ConceptoPago;
use App\Models\Financiera\EstadoCartera;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Convenio extends Component
{
    public $cartera;
    public $responsables=[];
    public $responsable_id;
    public $deudas;
    public $total;
    public $tipoconvenio;

    public $is_total=false;
    public $is_aplaza=false;
    public $is_retiro=false;
    public $is_aplazadeta=false;

    public $contado=true;
    public $especiales=false;
    public $id_elimina;
    public $observaciones;
    public $actual;
    public $valor_inicial;
    public $saldo;
    public $cuotas;
    public $valor_cuota;
    public $saldo_aplazamiento;
    public $cuotadiferidas;
    public $cuotasaldo;
    public $descripcion;
    public $matricula_id;
    public $sede_id;
    public $sector_id;
    public $matricula;

    public $fecha;
    public $hoy;
    public $dia;
    public $elegible=[];
    public $fechaPago;

    public $valor_aplazamiento;

    public function mount($id=null){
        if($id){
            $this->matricula=Matricula::find($id);
            $this->responsable_id=$this->matricula->alumno_id;
            $this->updatedResponsableId();
            $this->especiales=true;
            $this->datos();
        }
        DB::table('apoyo_recibo')
            ->where('id_creador', Auth::user()->id)
            ->delete();
        /* $this->cartera=Cartera::where('estado_cartera_id', '<',5)
                                ->where('responsable_id', $this->responsable_id)
                                ->where('saldo','>',0)
                                ->get(); */

        $this->hoy=now();
        $this->hoy=date('Y-m-d');

        $this->valor_aplazamiento= DB::table('cuotaplaza')
                                            ->where('status',1)
                                            ->first();

        //$this->filtrar();
        $this->dias();
    }

    public function datos(){
        $this->actual=User::find($this->responsable_id);
    }

    public function dias(){
        for ($i=1; $i <= 30; $i++) {
            array_push($this->elegible, $i);
        }
    }

    public function filtrar(){
        /* foreach ($this->cartera as $value) { */
        foreach ($this->deudas as $value) {
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
        $this->deudas=Cartera::where('matricula_id', $this->matricula->id)
                            ->where('estado_cartera_id', '<',5)
                            ->where('saldo','>',0)
                            ->get();

        if ($this->deudas->isNotEmpty()) {
            $primerRegistro = $this->deudas->first();
            // Trabajas con el primer registro
            $this->sede_id=$primerRegistro->sede_id;
            $this->sector_id=$primerRegistro->sector_id;
            $this->total=$this->deudas->sum('saldo');
        } /*

        if($this->deudas->count()>0){
            $crt=Cartera::where('responsable_id', $this->responsable_id)
                        ->where('estado_cartera_id', '<',5)
                        ->where('saldo','>',0)
                        ->first();

            $this->sede_id=$crt->sede_id;
            $this->sector_id=$crt->sector_id;
        }

        $this->total=Cartera::where('matricula_id', $this->matricula->id)
                            ->where('estado_cartera_id', '<',5)
                            ->where('saldo','>',0)
                            ->sum('saldo');
 */
        $this->filtrar();
    }

    public function updatedContado(){
        if($this->contado){
            $this->valor_inicial=$this->total;
            $this->cuotas=0;
            $this->valor_cuota=0;
            $this->dia=1;
        }
    }

    public function updatedTipoconvenio(){
        $id=intval($this->tipoconvenio);
        $this->reset('is_total','is_aplaza','is_retiro');
        switch ($id) {
            case 1:
                $this->is_total=true;
                break;

            case 2:

                $this->is_aplaza=true;
                $this->valor_inicial=$this->valor_aplazamiento->valor;
                $this->cuomensual();
                break;

            case 3:
                $this->is_retiro=true;
                $this->cuotas=0;
                $this->valor_cuota=0;
                $this->dia=1;
                break;
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

    //Determina v alor de cuota mensual
    public function cuomensual(){
        $crt=Cartera::where('responsable_id', $this->responsable_id)
                        ->where('saldo','>',0)
                        ->where('concepto_pago_id',2)
                        ->select('valor')
                        ->first();

        if($crt){
            $this->valor_cuota=$crt->valor;
        }else{
            $this->reset('is_aplaza','tipoconvenio');
            $this->dispatch('alerta', name:'Haga Convenio completo o Retiro.');
        }

    }

    // Calculo de las cuotas
    public function calcula(){
        if($this->cuotas>0 && $this->total>$this->valor_inicial){
            $saldo = $this->total-$this->valor_inicial;
            $this->valor_cuota=$saldo/$this->cuotas;
            $this->redondear();
        }
    }

    //Calculo cuotas afectadas
    public function calculafectadas(){

        if($this->cuotas<=12 && $this->cuotas>0){
            $aplazamiento=$this->cuotas*$this->valor_inicial;
            $this->saldo_aplazamiento=$this->total-$aplazamiento;
            $this->cuotadiferidas=floor($this->saldo_aplazamiento/$this->valor_cuota);  //Calcula el número de cuotas completas
            $cuotadif=$this->saldo_aplazamiento-($this->cuotadiferidas*$this->valor_cuota);
            $diferencia=$cuotadif % 1000;
            $this->cuotasaldo=$cuotadif-$diferencia; // Cuota saldo redondeada a 1000
            $this->is_aplazadeta=true;
        }else{
            $this->reset('cuotas');
            $this->dispatch('alerta', name:'Entre 1 y 12 cuotas.');

        }


    }

    public function redondear(){
        $this->valor_cuota=intval($this->valor_cuota);
        $diferencia=$this->valor_cuota % 1000;
        $this->valor_cuota=$this->valor_cuota-$diferencia;
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
                        'dia',
                        'cuotadiferidas',
                        'cuotasaldo'
                    );
    }

    public function crea(){

        // validate
        $this->validate();

        //anular todos
        //Cargar convenio
        /* $estado=EstadoCartera::where('name', 'convenio')
                                ->where('status', true)
                                ->first(); */

        $this->fechaPago = Carbon::createFromFormat('Y-m-d', $this->fecha)->setDay($this->dia);

        foreach ($this->deudas as $value) {
            $obser=now()." ".Auth::user()->name." --- CASTIGADO POR CONVENIO DE PAGO --- ".$value->observaciones;
            $this->matricula_id=$value->matricula_id;
            Cartera::whereId($value->id)
                    ->update([
                        'status'        =>5,
                        'estado_cartera_id' =>5,
                        'observaciones' =>$obser
                    ]);
        }

        $id=intval($this->tipoconvenio);
        switch ($id) {
            case 1:
                //Cargar convenio
                $concepto=ConceptoPago::where('name', 'Inicial convenio')
                                ->where('status', true)
                                ->first();

                Cartera::create([
                        'fecha_pago'=>$this->fecha,
                        'valor'=>$this->valor_inicial,
                        'saldo'=>$this->valor_inicial,
                        'observaciones'=>'--- CONVENIO PAGO --- primera cuota de un convenio por: '.$this->total." -- ".strtolower($this->descripcion),
                        'matricula_id'=>$this->matricula_id,
                        'concepto_pago_id'=>$concepto->id,
                        'concepto'=>$concepto->name,
                        'responsable_id'=>$this->responsable_id,
                        'estado_cartera_id'=>4,
                        'sede_id'=>$this->sede_id,
                        'sector_id'=>$this->sector_id,
                        'status'=>4
                ]);

                //Cargar nueva cartera
                //Cuotas
                $concepto=ConceptoPago::where('name', 'Convenio mes')
                        ->where('status', true)
                        ->first();


                if($this->cuotas>0){

                    /* $year = now();
                    $year = date('Y');
                    $mes =now();
                    $mes= date('m');
                    $date=Carbon::create($year, $mes, $this->dia); */

                    $a=1;
                    while ($a <= $this->cuotas) {

                        $endDate = $this->fechaPago->addMonths();

                        Cartera::create([
                        'fecha_pago'=>$endDate,
                        'valor'=>$this->valor_cuota,
                        'saldo'=>$this->valor_cuota,
                        'observaciones'=>'Cuota N°: '.$a.' mensual CONVENIO PAGO ----- de un convenio por: '.$this->total." -- ".strtolower($this->descripcion),
                        'matricula_id'=>$this->matricula_id,
                        'concepto_pago_id'=>$concepto->id,
                        'concepto'=>$concepto->name,
                        'responsable_id'=>$this->responsable_id,
                        'estado_cartera_id'=>4,
                        'sede_id'=>$this->sede_id,
                        'sector_id'=>$this->sector_id,
                        'status'=>4
                        ]);

                        $a++;
                    }

                }
                break;

            case 2:
                //Calcular cuotas faltantes de aplazamiento
                $cuoaplaza=$this->cuotas-1;

                if($cuoaplaza>0){
                    $this->cuotadiferidas=$this->cuotadiferidas+$cuoaplaza;
                }

                // Cargar primer cuota de aplzamiento
                $concepto=ConceptoPago::where('name', 'Inicial convenio')
                                ->where('status', true)
                                ->first();

                Cartera::create([
                        'fecha_pago'=>$this->fecha,
                        'valor'=>$this->valor_inicial,
                        'saldo'=>$this->valor_inicial,
                        'observaciones'=>'--- CONVENIO PAGO APLAZAMIENTO --- primera cuota de un convenio por: '.$this->total." -- ".strtolower($this->descripcion),
                        'matricula_id'=>$this->matricula_id,
                        'concepto_pago_id'=>$concepto->id,
                        'concepto'=>$concepto->name,
                        'responsable_id'=>$this->responsable_id,
                        'estado_cartera_id'=>4,
                        'sede_id'=>$this->sede_id,
                        'sector_id'=>$this->sector_id,
                        'status'=>4
                ]);

                // Cargar las demás cuotas de aplazamiento
                $conceptomes=ConceptoPago::where('name', 'Convenio mes')
                                            ->where('status', true)
                                            ->first();

                /* $year = now();
                    $year = date('Y');
                    $mes =now();
                    $mes= date('m');
                    $date=Carbon::create($year, $mes, $this->dia); */

                $a=1;
                while ($a <= $this->cuotadiferidas) {

                    $valor=0;

                    if($a<=$cuoaplaza){
                        // Cargar cuotas aplazamiento pendientes
                        $valor=$this->valor_inicial;
                    }else{
                        // Cargar cuotas de cuota mensual
                        $valor=$this->valor_cuota;
                    }

                    $endDate = $this->fechaPago->addMonths();

                    Log::info('Convenio: ' . $valor. ' N°: '.$a." Aplaza: ".$cuoaplaza." Diferidas: ".$this->cuotadiferidas." SAldo: ".$this->cuotasaldo.' fecha: '.$endDate);

                    Cartera::create([
                            'fecha_pago'=>$endDate,
                            'valor'=>$valor,
                            'saldo'=>$valor,
                            'observaciones'=>'Cuota N°: '.$a.' mensual CONVENIO PAGO APLAZAMIENTO ----- de un convenio por: '.$this->total." -- ".strtolower($this->descripcion),
                            'matricula_id'=>$this->matricula_id,
                            'concepto_pago_id'=>$conceptomes->id,
                            'concepto'=>$conceptomes->name,
                            'responsable_id'=>$this->responsable_id,
                            'estado_cartera_id'=>4,
                            'sede_id'=>$this->sede_id,
                            'sector_id'=>$this->sector_id,
                            'status'=>4
                    ]);

                    $a++;
                }

                if($this->cuotasaldo>0){
                    $endDate = $this->fechaPago->addMonths();
                    log::info(' fecha:'.$endDate);

                    Cartera::create([
                        'fecha_pago'=>$endDate,
                        'valor'=>$this->cuotasaldo,
                        'saldo'=>$this->cuotasaldo,
                        'observaciones'=>'Cuota N°: '.$a.' mensual CONVENIO PAGO APLAZAMIENTO ----- de un convenio por: '.$this->total." -- ".strtolower($this->descripcion),
                        'matricula_id'=>$this->matricula_id,
                        'concepto_pago_id'=>$conceptomes->id,
                        'concepto'=>$conceptomes->name,
                        'responsable_id'=>$this->responsable_id,
                        'estado_cartera_id'=>4,
                        'sede_id'=>$this->sede_id,
                        'sector_id'=>$this->sector_id,
                        'status'=>4
                    ]);
                }

                break;

            case 3:
                //Cargar convenio
                $concepto=ConceptoPago::where('name', 'Inicial convenio')
                                ->where('status', true)
                                ->first();

                Cartera::create([
                        'fecha_pago'=>$this->fecha,
                        'valor'=>$this->valor_inicial,
                        'saldo'=>$this->valor_inicial,
                        'observaciones'=>'--- CONVENIO PAGO RETIRO --- Cuota retiro por: '.$this->total." -- ".strtolower($this->descripcion),
                        'matricula_id'=>$this->matricula_id,
                        'concepto_pago_id'=>$concepto->id,
                        'concepto'=>$concepto->name,
                        'responsable_id'=>$this->responsable_id,
                        'estado_cartera_id'=>4,
                        'sede_id'=>$this->sede_id,
                        'sector_id'=>$this->sector_id,
                        'status'=>4
                ]);

                //Marcar como retirado el estudiante
                $esta=Control::where('estudiante_id', $this->responsable_id)
                                        ->count();

                if($esta>0){
                    Control::where('estudiante_id', $this->responsable_id)
                            ->update([
                                'status_est'    =>6
                            ]);
                }

                //Estado en cartera
                $car=Cartera::where('responsable_id', $this->responsable_id)
                ->count();

                if($car>0){
                    Cartera::where('responsable_id', $this->responsable_id)
                            ->update([
                                'status_est'    =>6,
                            ]);
                }

                //Matriculas
                $matr=Matricula::where('alumno_id', $this->responsable_id)
                ->count();

                if($matr>0){
                    Matricula::where('alumno_id', $this->responsable_id)
                                ->update([
                                    'status_est'    =>6,
                                    'anula'=>now()." ¡¡¡ANULADO POR RETIRO!!! ".strtolower($this->observaciones),
                                    'anula_user'=>Auth::user()->name,
                                    'status'=>false,
                                ]);
                }



                break;
        }

        Pqrs::create([
            'estudiante_id' =>$this->responsable_id,
            'gestion_id'    =>Auth::user()->id,
            'fecha'         =>now(),
            'tipo'          =>2,
            'observaciones' =>'PAGO: Se genero acuerdo de pago ----- ',
            'status'        =>4
        ]);

        // Notificación
        $this->dispatch('alerta', name:'Se ha creado correctamente el convenio de pago.');
        $this->resetFields();
        $this->updatedResponsableId();
        $this->dispatch('cancelando');
    }

    public function eliminar($id){
        $this->id_elimina=$id;
    }

    public function anular(){

        $dato=Cartera::find($this->id_elimina);

        $obser=now()." ".Auth::user()->name." --- ANULADO --- ".$this->observaciones." ----- ".$dato->observaciones;

        $dato->update([
            'status'            => 7,
            'estado_cartera_id'=>7,
            'observaciones'     => $obser
        ]);

        Pqrs::create([
            'estudiante_id' =>$this->responsable_id,
            'gestion_id'    =>Auth::user()->id,
            'fecha'         =>now(),
            'tipo'          =>2,
            'observaciones' =>'PAGO: Se anulo un cobro ----- ',
            'status'        =>4
        ]);

        $this->dispatch('alerta', name:'Se ha ANULADO correctamente el pago.');
        $this->updatedResponsableId();
        $this->reset('id_elimina', 'observaciones');
    }

    public function render(){
        return view('livewire.cartera.cartera.convenio');
    }
}
