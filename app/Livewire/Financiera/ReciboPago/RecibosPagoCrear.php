<?php

namespace App\Livewire\Financiera\ReciboPago;

use App\Models\Academico\Control;
use App\Models\Academico\Matricula;
use App\Models\Clientes\Pqrs;
use App\Models\Configuracion\Sede;
use App\Models\Financiera\Cartera;
use App\Models\Financiera\ConceptoPago;
use App\Models\Financiera\Descuento;
use App\Models\Financiera\EstadoCartera;
use App\Models\Financiera\ReciboPago;
use App\Models\Financiera\Transaccion;
use App\Models\User;
use App\Traits\ComunesTrait;
use App\Traits\MailTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class RecibosPagoCrear extends Component
{
    use WithPagination;
    use ComunesTrait;
    use MailTrait;

    public $medio='';
    public $medioele;
    public $observaciones='';
    public $obser;
    public $sede_id;
    public $cargados;
    public $tipo;
    public $saldo;
    public $id_cartera;
    public $estado;
    public $status;
    public $recargo=0;
    public $recargo_id;
    public $recargoValor=0;
    public $pagoTotal=false;
    public $totalCartera=0;
    public $fecha_pago;
    public $ruta;
    public $banco;
    public $fecha_transaccion;

    public $concepdescuento;
    public $descuento=0;
    public $base;
    public $aplica;
    public $inicial;
    public $diferencia;
    public $fechatransaccion;

    public $concepotro;
    public $otro;

    public $listaotros;


    public $valor=0;
    public $pagado;
    public $apl_descuento=null;
    public $conceptos=0;
    public $concep=[];
    public $nameConcep;
    public $conceptoelegido;
    public $Total=0;
    public $Totaldescue=0;
    public $subtotal;
    public $control=[];

    public $buscar=null;
    public $buscaestudi='';

    public $alumno_id='';
    public $alumnoName='';
    public $alumnodocumento='';

    public $estuActual;

    public $ordena='name';
    public $ordenado='ASC';
    public $pages = 20;

    public $transaccion;
    public $status_transa;

    public $is_transac=false;
    public $is_recibo=true;
    public $is_inventa=false;
    public $controle_id=0;

    public $carteraSeleccionada;
    public $pendientes;
    public $futuros;
    public $matriculas;
    public $matricula_id;
    public $siguientecuota;
    public $matrids=[];
    public $hoy;
    public $minimodescuento=0;
    public $descuentomin=0;
    public $descuentopleno;
    public $gestion=0;
    public $descuconcepto;

    public function mount($ruta=null, $elegido=null, $estudiante=null, $fechatransaccion=null, $matricula=null){

        $this->limpiapoyo();
        $this->cierre();

        $this->ruta=$ruta;
        $this->fechatransaccion=$fechatransaccion;
        if($fechatransaccion){
            $this->hoy=$fechatransaccion;
        } else{
            $this->hoy = Carbon::today()->format('Y-m-d');
        }

        if($elegido){
            $this->transaccion=Transaccion::find($elegido);
            $this->variables();
        }

        if($estudiante){
            $alum=User::find($estudiante);
            $this->siEstudiante($alum,$estudiante);
        }

        if($matricula){
            $matri=intval($matricula);
            $this->matrielegida($matri);
        }

        $this->descuentoConcepto();
    }

    public function siEstudiante($alum){
        $this->alumno_id=$alum->id;
        $this->alumnoName=$alum->name;
        $this->alumnodocumento=$alum->documento;
        $this->obligaciones();
    }

    public function limpiapoyo(){
        DB::table('apoyo_recibo')
            ->where('id_creador', Auth::user()->id)
            ->delete();
    }

    public function limpiafin(){

        $fin = DB::table('apoyo_recibo')
                    ->where('id_creador', Auth::user()->id)
                    ->wherein('tipo',['cartera','financiero'])
                    ->where('id_almacen',$this->alumnodocumento)
                    ->get();

        foreach ($fin as $value) {
            if($value->tipo==='cartera'){
                $this->Total=$this->Total-$value->valor;
                $this->elimregistro($value->id);
            }
            if($value->tipo==='financiero' && $value->id_cartera>0){
                $this->Totaldescue=$this->Totaldescue-$value->valor;
                $this->elimregistro($value->id);
            }
        }
    }

    public function elimregistro($id){
        DB::table('apoyo_recibo')
                ->where('id',$id)
                ->delete();
    }

    public function variables(){
        $this->alumno_id=$this->transaccion->user_id;
        $this->alumnoName=$this->transaccion->user->name;
        $this->alumnodocumento=$this->transaccion->user->documento;
        $this->sede_id=$this->transaccion->sede_id;
        $this->obligaciones();
    }

    public function descuentoConcepto(){
        $concepdescuento=ConceptoPago::where('status', true)
                                            ->where('name', "Descuento")
                                            ->select('id')
                                            ->first();

        $this->concepdescuento=$concepdescuento->id;
    }

    public function obligaciones(){

        $this->matriculas = Cartera::where('responsable_id', $this->alumno_id)
                                    ->where('estado_cartera_id', '<', 5)
                                    ->where('saldo', '>', 0)
                                    ->groupBy('matricula_id') // Agrupa por matricula_id
                                    ->selectRaw('matricula_id, SUM(saldo) as total_saldo') // Selecciona y agrega el saldo
                                    ->orderBy('matricula_id')
                                    ->get();


        $carteraTotal= Cartera::where('responsable_id', $this->alumno_id)
                                ->where('estado_cartera_id', '<',5)
                                ->where('saldo','>',0)
                                //->where('fecha_pago','<=',$this->hoy)
                                ->orderBy('matricula_id')
                                ->orderBy('fecha_pago')
                                ->get();

        /* $this->totalCartera=Cartera::where('responsable_id', $this->alumno_id)
                                    ->where('estado_cartera_id', '<',5)
                                    ->where('saldo','>',0)
                                    ->sum('saldo'); */

        $this->totalCartera=$carteraTotal->sum('saldo');

        $this->pendientes= $carteraTotal;
        $this->student();

    }

    public function matrielegida($idmatricu){

        $this->reset('pendientes','matricula_id');
        $this->matricula_id=$idmatricu;

        $this->carteraSeleccionada= Cartera::where('responsable_id', $this->alumno_id)
                                            ->where('estado_cartera_id', '<',5)
                                            ->where('saldo','>',0)
                                            ->where('matricula_id',$idmatricu)
                                            ->orderBy('fecha_pago')
                                            ->get();

        $this->totalCartera=$this->carteraSeleccionada->sum('saldo');

        $this->pendientes= $this->carteraSeleccionada->filter(function ($deuda) /* use ($hoy) */ {
                                                    return $deuda->fecha_pago < $this->hoy;
                                                });

        $this->futuros=$this->carteraSeleccionada->filter(function ($futur) /* use ($hoy) */ {
                                                return $futur->fecha_pago >= $this->hoy;
                                            });

        $this->siguientecuota=$this->futuros->first();

        $this->calcuminimo($idmatricu);
    }

    public function calcuminimo($idmatricu){
        if($this->siguientecuota){
            if($this->hoy<=$this->siguientecuota->fecha_pago){
                /* if($this->pendientes && $this->pendientes->sum('saldo')>0){
                    $this->reset('minimodescuento');
                }else{

                    $descu=Descuento::where('aplica',0)
                                        ->where('status',1)
                                        ->first();

                    if($descu){
                        if($descu && $descu->tipo===0){
                            $this->descuentomin=$descu->valor;
                        }

                        if($descu && $descu->tipo===1){
                            $this->descuentomin=$this->siguientecuota->saldo*$descu->valor/100;
                        }
                    }else{
                        $this->descuentomin=0;
                    }

                    $this->minimodescuento=$this->siguientecuota->saldo-$this->descuentomin;
                } */

                $descu=Descuento::where('aplica',0)
                                        ->where('status',1)
                                        ->first();

                    if($descu){
                        if($descu && $descu->tipo===0){
                            $this->descuentomin=$descu->valor;
                        }

                        if($descu && $descu->tipo===1){
                            $this->descuentomin=$this->siguientecuota->saldo*$descu->valor/100;
                        }
                    }else{
                        $this->descuentomin=0;
                    }

                    $this->minimodescuento=$this->siguientecuota->saldo-$this->descuentomin;

                    $descuentopleno=Cartera::where('matricula_id',$idmatricu)
                                            ->where('estado_cartera_id', '<',5)
                                            ->max('valor');

                    $this->descuentopleno=$descuentopleno-$this->descuentomin;


            }
        }

    }

    #[On('cargados')]
    //obtener itemes cargados
    public function cargando(){
        $this->cargados=DB::table('apoyo_recibo')
                            ->where('id_creador', Auth::user()->id)
                            ->where('id_almacen',$this->alumnodocumento)
                            ->get();
    }

    //Buscar Alumno
    public function buscAlumno(){
        $this->buscaestudi=strtolower($this->buscar);
    }

    //Limpiar variables
    public function limpiar(){
        $this->reset('buscar');
    }

    public function selAlumno($item){
        $this->alumno_id=$item['id'];
        $this->alumnoName=$item['name'];
        $this->alumnodocumento=$item['documento'];
        $this->limpiar();
        $this->obligaciones();
    }

    public function student(){
        $this->estuActual=User::find($this->alumno_id);
    }

    public function cargaOtro(){

        $this->conceptoelegido=$this->concepotro;
        $this->calcudescu(0,"otro",0,0);

        //Validar si el descuento es mayor que el precio
        if($this->otro<=$this->descuento){
            $this->descuento=0;
            $this->dispatch('alerta', name:'el descuento es mayor que el pago, NO SE CARGARÁ');
        }

        if($this->otro>=$this->descuento){

            $ite=ConceptoPago::find($this->concepotro);

            // Cargar descuento a la tabla temporal
            DB::table('apoyo_recibo')->insert([
                'tipo'=>'otro',
                'id_creador'=>Auth::user()->id,
                'id_concepto'=>$this->concepotro,
                'concepto'=>$ite->name,
                'id_producto'=>$this->concepotro,
                'id_almacen'=>$this->alumnodocumento,
                'producto'=>$ite->name,
                'valor'=>abs($this->otro),
            ]);

            $this->Total=$this->Total+abs($this->otro);

            $this->cargaDescuento();
            $this->reset('otro','pagado');

        }else{
            $this->dispatch('alerta', name:'el descuento debe ser menor o igual al pago');
        }
    }

    public function obtienedescuento(){

        if($this->descuconcepto){
            if($this->descuconcepto && $this->descuconcepto->tipo===0){

                $this->descuento=$this->descuconcepto->valor;
            }

            if($this->descuconcepto && $this->descuconcepto->tipo===1){
                $this->descuento=$this->base*$this->descuconcepto->valor/100;
            }
        }else{
            $this->descuento=0;
        }

        $this->pagado=$this->pagado+$this->descuento;
    }

    public function calcudescu($id,$aplicaa,$inicial,$descuento,$fecha=null){ //1, salod, valor, descuento,fecha
        $this->reset(
                    'descuento',
                    'base',
                    'aplica',
                    'inicial',
                    'diferencia'
                );

        $fecha=Carbon::create($fecha)->format('Y-m-d');

        if($descuento && $descuento>0){
            $this->descuento=0;
        }else{
            if($id===0){
                $this->aplica=2;
                $this->base=$this->otro;
                $this->obtienedescuento();
            }

            if($id===1){
                $this->aplica=0;
                $this->base=$aplicaa;
                $this->inicial=$inicial;
                $this->diferencia=$inicial-$aplicaa;

                /* if($this->fechatransaccion){
                $hoy=Carbon::create($this->fechatransaccion);
                }else{
                    $hoy=Carbon::today();
                } */
                if($fecha>=$this->hoy && floatval($this->valor)===floatval($aplicaa)){
                    //dd(" HOY Es ANTES: ",$hoy,$fecha);
                    //Log::info('Saldo y valor iguales');
                    $this->obtienedescuento();
                }else{
                    //dd(" HOY ES DESPUES: ",$hoy,$fecha);
                    $this->descuento=0;
                }
            }
        }



    }

    public function cargaPago(){

        $this->limpiafin();

        if($this->pagado<=$this->carteraSeleccionada->sum('saldo')){
            foreach ($this->carteraSeleccionada as $value) {

                    if($this->pagado>0){
                        if($this->pagado>$value->saldo){
                            $this->valor=$value->saldo;
                        }

                        if($this->pagado<=$value->saldo){
                            $this->valor=$this->pagado;
                        }
                        $this->conceptos=$value->concepto_pago_id;
                        $this->asigOtro(1,$value);
                        $this->pagado=$this->pagado-$value->saldo;
                    }

            }

            if($this->apl_descuento>0){
                $this->cupondescuento();
            }

            $this->reset('pagado','apl_descuento');
        }else{
            $this->dispatch('alerta', name:'El valor a pagar debe ser menor al valor adeudado.');
        }

    }

    private function cupondescuento(){
        //Asignar el descuento a los itemes calculados
        foreach ($this->cargados as $value) {
            if($this->apl_descuento>0){

                $diferencia=$value->saldo-$value->valor;
                if($this->apl_descuento>$diferencia && $value->saldo>0 && $diferencia>0){

                    DB::table('apoyo_recibo')->insert([
                        'tipo'          =>'financiero',
                        'id_creador'    =>$value->id_creador,
                        'id_concepto'   =>$value->id_concepto,
                        'concepto'      =>'Descuento',
                        'valor'         =>$diferencia,
                        'id_cartera'    =>$value->id_cartera,
                        'id_almacen'    =>$value->id_almacen,
                    ]);
                }

                if($this->apl_descuento<=$diferencia && $value->saldo>0){
                    $valor=$this->apl_descuento;
                    DB::table('apoyo_recibo')->insert([
                        'tipo'          =>'financiero',
                        'id_creador'    =>$value->id_creador,
                        'id_concepto'   =>$value->id_concepto,
                        'concepto'      =>'Descuento',
                        'valor'         =>$valor,
                        'id_cartera'    =>$value->id_cartera,
                        'id_almacen'    =>$value->id_almacen,
                    ]);
                }

                $this->apl_descuento=$this->apl_descuento-$diferencia;
            }
        }

        $this->cargando();
    }

    public function asigOtro($id, $item,$conf=null){

        $this->reset('descuconcepto');

        if($id===0){
            $this->aplica=2;
        } else if($id===1){
            $this->aplica=0;
        }

        $this->conceptoelegido=$item['concepto_pago_id'];

        $this->descuconcepto=Descuento::join('descuento_producto', 'descuentos.id', '=', 'descuento_producto.descuento_id')
                        ->where('descuentos.aplica',$this->aplica)
                        ->where('descuentos.status',1)
                        ->where('descuento_producto.concepto_pago_id', $this->conceptoelegido)
                        ->first();

        if($this->siguientecuota){
            $saldosiguiente=$this->siguientecuota->saldo;
        }else{
            $saldosiguiente=$this->pagado;
        }

        $fechavence=Carbon::create($item['fecha_pago'])->format('Y-m-d');

        //vARIABLES:
        //Log::info('HOY: '.$this->hoy.' VEnce: '.$fechavence.' vALOR MINIMO PARA DESCUENTO: '.$this->minimodescuento.' Pagado:'.$this->pagado.' Saldo Siguiente: '.$saldosiguiente.' Saldo: '.$item['saldo'].' Valor inicial de pago: '.$item['valor']);

        if($this->hoy<=$fechavence && $this->descuconcepto){

            if(floatval($this->minimodescuento)===floatval($this->pagado)){

                $this->descuento=$this->descuentomin;
                $this->valor=$this->pagado+$this->descuentomin;

                //Log::info('IGUALES el descuento: ' . $this->minimodescuento);
                //$this->minimodescuento=$this->descuentopleno;

            }else if(floatval($this->minimodescuento)<floatval($this->pagado) && floatval($this->pagado)<=floatval($saldosiguiente)){

                //Log::info('PAGADO MENOR AL SALDO SIGUIENTE el descuento: ' . $this->minimodescuento.' sALDO SIGUIENTE: '.$saldosiguiente.' VALOR PAGADO: '.$this->pagado);
                $this->descuento=$this->descuentomin;
                $this->valor=$this->pagado+$this->descuentomin;
                //$this->pagado=$this->pagado-$this->minimodescuento;
                $this->pagado=$this->pagado+$this->descuento;

                //$this->minimodescuento=$this->descuentopleno;

            }else{
                //Log::info('PROCESO NORMAL ');
                //($this->minimodescuento=$this->descuentopleno;
                $this->calcudescu($id,$item['saldo'],$item['valor'],$item['descuento'],$item['fecha_pago']);

            }
        }else{
            $this->calcudescu($id,$item['saldo'],$item['valor'],$item['descuento'],$item['fecha_pago']);
        }

        //Validar si el descuento es mayor que el precio
        if($this->valor<=$this->descuento){
            $this->descuento=0;
            $this->dispatch('alerta', name:'el descuento es mayor que el pago, NO SE CARGARÁ');
        }

        if($this->valor>=$this->descuento){
            $dato=explode("-----",$item['observaciones']);
            $dat=$dato[0];

            $this->valoRecargo();

            if($item===0){
                //obtener Matricula
                $matr=Matricula::where('alumno_id', $this->alumno_id)
                                ->orderBy('id', 'DESC')
                                ->first();

                $ya=0;
                $this->subtotal=$conf['precio'];
                $this->conceptos=$conf['concepto_pago_id'];
                $this->nameConcep=$conf['name'];
                if($this->subtotal<=$this->valor){
                    $this->valor=$this->subtotal;
                }

                $this->saldo=$this->subtotal-$this->valor;

                if($this->saldo>0 && $matr){
                    $this->id_cartera=$matr->id;
                }else if($this->saldo>0 && !$matr){
                    $this->dispatch('alerta', name:'¡Debe cancelar completo, no tiene matriculas registradas!');
                    $ya=-1;
                }

            }else{
                //Verificar si el valor mayor a la 1/2
                $mitad=$item['saldo']/2;

                if($mitad>$this->valor){
                    $this->dispatch('alerta', name:'¡Abono inferior a la mitad!, solo con transferencia!');
                    $this->obser="  ¡IMPORTANTE! Se recibe abono inferior, validar transferencia.";
                }

                //Verificar que no exceda el saldo
                if($item['saldo']<$this->valor){
                    $this->valor=$item['saldo'];
                }

                //Verificar que no se haya cargado el dato
                $ya= DB::table('apoyo_recibo')->where('id_cartera',$item['id'])->count();

                //Obtener nombre del concepto
                $this->conceptos=intval($this->conceptos);

                foreach ($this->concep as $value) {

                    if($value->id===$this->conceptos){
                        $this->nameConcep=$value->name;
                    }

                }
            }

            if($ya>0){
                $this->dispatch('alerta', name:'Ya esta cargado');
                $this->reset(
                    'valor' ,
                    'conceptos',
                    //'name',
                    );
                $this->descuento=0;
            }else if($ya===0){
                switch ($id) {
                    case 0:
                        $this->tipo="otro";
                        break;

                    case 1:
                        $this->tipo="cartera";
                        $this->saldo=$item['saldo'];
                        $this->id_cartera=$item['id'];
                        break;

                    default:
                        $this->tipo="inventario";
                        break;
                }

                if($this->valor>0){

                        DB::table('apoyo_recibo')->insert([
                            'tipo'=>$this->tipo,
                            'id_creador'=>Auth::user()->id,
                            'id_concepto'=>$this->conceptos,
                            'producto'  =>$dat,
                            'concepto'=>$this->nameConcep,
                            'valor'=>$this->valor,
                            'saldo'=>$this->saldo,
                            'id_cartera'=>$this->id_cartera,
                            'id_almacen'=>$this->alumnodocumento,
                            'subtotal'=>$this->subtotal
                        ]);

                        $this->Total=$this->Total+$this->valor;

                        $this->reset(
                                    'valor' ,
                                    'conceptos',
                                    //'name'
                                    );

                        $this->cargando();
                }else{
                    $this->dispatch('alerta', name:'VALOR Mayor que cero');
                    $this->reset(
                        'valor' ,
                        'conceptos',
                        //'name'
                        );
                    $this->descuento=0;
                }

            }

            $this->cargaDescuento();

        }else{
            $this->dispatch('alerta', name:'el descuento debe ser menor o igual al pago');
        }
    }

    public function cargaDescuento(){

        if($this->descuento>0){

            if($this->id_cartera>0){
                // Cargar descuento a la tabla temporal
                DB::table('apoyo_recibo')->insert([
                    'tipo'          =>'financiero',
                    'id_creador'    =>Auth::user()->id,
                    'id_concepto'   =>$this->concepdescuento,
                    'concepto'      =>'Descuento',
                    'valor'         =>abs($this->descuento),
                    'id_cartera'    =>$this->id_cartera,
                    'id_almacen'    =>$this->alumnodocumento
                ]);
            }else{
                $ultimo=DB::table('apoyo_recibo')->where('id_almacen',$this->alumnodocumento)->orderBy('id', 'DESC')->first();
                DB::table('apoyo_recibo')->insert([
                    'tipo'          =>'financiero',
                    'id_creador'    =>Auth::user()->id,
                    'id_concepto'   =>$this->concepdescuento,
                    'concepto'      =>'Descuento',
                    'valor'         =>abs($this->descuento),
                    'id_producto'   =>$ultimo->id_concepto,
                    'producto'      =>$ultimo->concepto,
                    'id_almacen'    =>$this->alumnodocumento
                ]);
            }


            $this->Totaldescue=$this->Totaldescue+abs($this->descuento);
        }



        $this->reset('descuento', 'otro', 'concepotro', 'id_cartera');

        $this->cargando();
    }

    public function elimOtro($item){

        $reg=DB::table('apoyo_recibo')
                ->where('id', $item)
                ->first();

        //$this->valoRecargo();

        if($reg->concepto!=='Descuento'){
            $this->Total=$this->Total-$reg->valor;

            if($reg->id_cartera){

                $aplicado=DB::table('apoyo_recibo')
                                ->where('id_cartera', $reg->id_cartera)
                                ->where('concepto', 'Descuento')
                                ->first();

                if($aplicado){
                    DB::table('apoyo_recibo')
                                ->where('id_cartera', $reg->id_cartera)
                                ->where('concepto', 'Descuento')
                                ->delete();

                    $this->Totaldescue=$this->Totaldescue-$aplicado->valor;
                }
            }

            if($reg->id_producto>0){

                $aplic=DB::table('apoyo_recibo')
                                ->where('id_producto', $reg->id_producto)
                                ->where('concepto', 'Descuento')
                                ->first();

                if($aplic){
                    DB::table('apoyo_recibo')
                                ->where('id_producto', $reg->id_producto)
                                ->where('concepto', 'Descuento')
                                ->delete();

                    $this->Totaldescue=$this->Totaldescue-$aplic->valor;
                }
            }
        }

        if($reg->concepto==='Descuento'){
            $this->Totaldescue=$this->Totaldescue-$reg->valor;
        }

        DB::table('apoyo_recibo')
            ->where('id', $item)
            ->delete();

        $this->cargando();
    }

    public function updatedMedio(){
        $registro=explode("-",$this->medio);

        if(intval($registro[1])===2){
            $porc=ConceptoPago::find(intval($registro[0]));

            $this->recargo=$porc->valor;
            $this->recargo_id=$porc->id;
            $this->recargoValor=($this->Total-$this->Totaldescue)*$this->recargo/100;
            $this->Total=$this->Total+$this->recargoValor;
            $this->medioele=$porc->name;
            $this->banco=$porc->name;


            //Cargar valor al recibo
            DB::table('apoyo_recibo')->insert([
                'tipo'=>'financiero',
                'id_creador'=>Auth::user()->id,
                'id_concepto'=>$porc->id,
                'concepto'=>$porc->name,
                'valor'=>$this->recargoValor,
                'id_almacen'=>$this->alumnodocumento
            ]);

            $this->cargando();

        }else{
            $medio=explode("-",$this->medio);
            $this->medioele=$medio[0];
            $this->banco=$medio[0];
            $this->valoRecargo();
        }
    }

    public function valoRecargo(){
        if($this->recargo>0){
            DB::table('apoyo_recibo')
                ->where('id_creador', Auth::user()->id)
                ->where('tipo', 'financiero')
                ->delete();

            $this->Total=$this->Total-$this->recargoValor;
            $this->reset('recargoValor', 'recargo', 'recargo_id', 'medio');
        }
    }



    /**
     * Reglas de validación
     */
    protected $rules = [
        'medio'=>'required',
        'observaciones'=>'required',
        'sede_id'=>'required'
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
                    'medio',
                    'observaciones',
                    'sede_id',
                    'Total',
                    'Totaldescue',
                    'alumno_id',
                    );
    }

    public function updatedPagoTotal(){
        if($this->pagoTotal){
            $this->Total=$this->totalCartera;
            $this->descuento="";

        }else{
            $this->reset('totalCartera');
        }
    }
    // Crear REcibo de Pago
    public function new(){

        // validate
        $this->validate();

        if($this->pagoTotal){
            if($this->descuento>0){
                $this->Totaldescue=$this->descuento;
            }else{
                $this->Totaldescue=0;
            }

        }

        $this->fecha_pago=now();

        $ultimo=ReciboPago::where('origen', true)
                                ->max('numero_recibo');


        if($ultimo){
            $recibo=$ultimo+1;
        }else{
            $recibo=1;
        }


        if($this->transaccion){
            $this->banco=$this->transaccion->banco;
            $this->fecha_transaccion=$this->transaccion->fecha_transaccion;
        }else{
            $this->fecha_transaccion=now();
        }

        //Crear registro
        $recibo= ReciboPago::create([
                                'numero_recibo'=>$recibo,
                                'origen'=>true,
                                'fecha'=>$this->fecha_pago,
                                'valor_total'=>$this->Total,
                                'descuento'=>$this->Totaldescue,
                                'medio'=>$this->medioele,
                                'banco'=>$this->banco,
                                'fecha_transaccion'=>$this->fecha_transaccion,
                                'observaciones'=>strtolower($this->observaciones).$this->obser,
                                'sede_id'=>$this->sede_id,
                                'creador_id'=>Auth::user()->id,
                                'paga_id'=>$this->alumno_id
                            ]);

        $sede=Sede::find($this->sede_id);

        if($this->pagoTotal){

            $esta=EstadoCartera::where('name', 'cerrada')->first();

            $this->estado=$esta->id;
            $this->status=$esta->id;

            $tipo="";
            $conceptodesc=0;
            $descuentomensual=0;
            if($this->descuento){
                $desc=ConceptoPago::where('status', true)
                                    ->where('name', 'like', "%".'descuento'."%")
                                    ->select('id','tipo')
                                    ->first();

                $descuentomensual=$this->descuento/$this->pendientes->count();
                $tipo=$desc->tipo;
                $conceptodesc=$desc->id;
            }


            foreach ($this->pendientes as $value) {

                $dato=explode("-----",$value->observaciones);
                $dat=$dato[0];

                DB::table('concepto_pago_recibo_pago')
                    ->insert([
                        'valor'=>$value->saldo,
                        'tipo'=>"cartera",
                        'medio'=>$this->medioele,
                        'id_relacional'=>$value->id,
                        'producto'=>$dat,
                        'concepto_pago_id'=>$value->concepto_pago_id,
                        'recibo_pago_id'=>$recibo->id,
                        'created_at'=>now(),
                        'updated_at'=>now(),
                    ]);

                if($this->descuento){
                    DB::table('concepto_pago_recibo_pago')
                            ->insert([
                                'valor'=>$descuentomensual,
                                'tipo'=>$tipo,
                                'medio'=>$this->medioele,
                                'id_relacional'=>$value->id,
                                'concepto_pago_id'=>$conceptodesc,
                                'recibo_pago_id'=>$recibo->id,
                                'created_at'=>now(),
                                'updated_at'=>now(),
                            ]);
                }

                $primer=explode("-----",$value->observaciones);
                $inicial=$primer[0];

                $observa=$inicial." ----- ".now()." ".$this->alumnoName." realizo pago por ".number_format($value->saldo, 0, ',', '.').", con el recibo N°: ".$recibo->numero_recibo.". --- ".$value->observaciones;

                Cartera::whereId($value->id)
                        ->update([
                            'fecha_real'=>now(),
                            'saldo'=>0,
                            'descuento'=>$descuentomensual,
                            'observaciones'=>$observa,
                            'status'=>$this->estado,
                            'estado_cartera_id'=>$this->estado
                        ]);
            }

        }else{
            foreach ($this->cargados as $value) {

                $estado="";

                if($value->tipo==="cartera"){

                    $item=Cartera::find($value->id_cartera);

                    $obs=explode('-----',$item->observaciones);
                    $obspr=$obs[0];

                    $saldo=$item->saldo-$value->valor;


                    if($saldo>0){
                        $esta=EstadoCartera::where('name', 'abonada')->first();
                        $this->estado=$esta->id;
                        $this->status=$esta->id;
                        $estado="ABONADA: ";
                    }else{
                        $esta=EstadoCartera::where('name', 'cerrada')->first();
                        $this->estado=$esta->id;
                        $this->status=$esta->id;
                        $estado="CANCELADA: ";
                    }

                    $observa=$obspr.'-----'.now()." ".$estado.$this->alumnoName." realizo pago por ".number_format($value->valor, 0, ',', '.').", con el recibo N°: ".$recibo->numero_recibo.". --- ".$item->observaciones;

                    $item->update([
                        'fecha_real'=>$this->fecha_pago,
                        'saldo'=>$saldo,
                        'observaciones'=>$observa,
                        'status'=>$this->status,
                        'estado_cartera_id'=>$this->estado
                    ]);
                }

                if($value->tipo==="otro" && $value->saldo>0){
                    Cartera::create([
                        'fecha_pago'=>now(),
                        'valor'=>$value->subtotal,
                        'saldo'=>$value->saldo,
                        'observaciones'=>now()." , abono para: ".$value->concepto,
                        'matricula_id'=>$value->id_cartera,
                        'concepto_pago_id'=>$value->id_concepto,
                        'concepto'=>$value->concepto,
                        'responsable_id'=>$this->alumno_id,
                        'estado_cartera_id'=>1,
                        'sede_id'=>$sede->id,
                        'sector_id'=>$sede->sector_id
                    ]);
                }

                if($value->tipo==='financiero' && $value->concepto==='Descuento'){

                    $this->descuento=$value->valor;

                    Pqrs::create([
                        'estudiante_id' =>$this->alumno_id,
                        'gestion_id'    =>Auth::user()->id,
                        'fecha'         =>now(),
                        'tipo'          =>2,
                        'observaciones' =>'PAGOS: '." recibio descuento por $".number_format($this->descuento, 0, ',', '.').", con el recibo N°: ".$recibo->numero_recibo.". ----- ",
                        'status'        =>4
                    ]);

                    if($value->id_cartera){
                        $item=Cartera::find($value->id_cartera);

                        $obs=explode('-----',$item->observaciones);
                        $obspr=$obs[0];

                        $observa=$obspr.'-----'.now()." recibio descuento por $".number_format($this->descuento, 0, ',', '.').", con el recibo N°: ".$recibo->numero_recibo.". --- ".$item->observaciones;
                        $descu=$item->descuento+$this->descuento;

                        $item->update([
                            'descuento'     =>$descu,
                            'observaciones' =>$observa,
                        ]);
                    }else{
                        $nota='-----'.now().' se aplico descuento de: '.number_format($this->descuento, 0, ',', '.').' a: '.$value->producto;
                        DB::table('concepto_pago_recibo_pago')
                                    ->where('recibo_pago_id',$recibo->id)
                                    ->where('concepto_pago_id', $value->id_producto)
                                    ->orderBy('id','DESC')
                                    ->update([
                                        'id_relacional'=>$nota
                                    ]);
                    }
                }

                DB::table('concepto_pago_recibo_pago')
                    ->insert([
                        'valor'=>$value->valor,
                        'tipo'=>$value->tipo,
                        'medio'=>$this->medioele,
                        'id_relacional'=>$value->id_cartera,
                        'concepto_pago_id'=>$value->id_concepto,
                        'producto'=>$estado.$value->producto,
                        'recibo_pago_id'=>$recibo->id,
                        'created_at'=>now(),
                        'updated_at'=>now(),
                    ]);
                $this->reset('estado', 'status');
            }
        }

        //Cargar fecha de pago y observaciones al control

        Pqrs::create([
            'estudiante_id' =>$this->alumno_id,
            'gestion_id'    =>Auth::user()->id,
            'fecha'         =>now(),
            'tipo'          =>2,
            'observaciones' =>'PAGOS: '." realizo pago por $".number_format($this->Total, 0, ',', '.').", con el recibo N°: ".$recibo->numero_recibo.". ----- ",
            'status'        =>4
        ]);

        $control=Control::where('estudiante_id', $this->alumno_id)
                            ->where('status', true)
                            ->get();


        foreach ($control as $value) {

            Control::whereId($value->id)
                    ->update([
                        //'observaciones' =>strtolower($observa),

                    ]);
        }


        //Actualiza la transacción
        if($this->transaccion){
            $observa=now()." ".Auth::user()->name." Genero recibo de pago N°: ".$recibo->numero_recibo." ----- ";
            if($this->transaccion->inventario>0){
                $this->status_transa=$this->transaccion->status;
            }else{
                $this->status_transa=4;
            }

            $this->transaccion->update([
                'observaciones'=>$observa.$this->transaccion->observaciones,
                'gestionador_id'=>Auth::user()->id,
                'status'=>$this->status_transa,
                'status_academico'=>true
            ]);
        }




        //Eliminar datos de apoyo
        DB::table('apoyo_recibo')
            ->where('id_creador', Auth::user()->id)
            ->delete();



        /* $hoy=Carbon::today(); */

        $cartera=Cartera::where('matricula_id',$this->matricula_id)
                                ->where('fecha_pago','<=',$this->hoy)
                                ->where('estado_cartera_id','<',5)
                                ->select('saldo')
                                ->get();

        try {
            if($cartera){
                $mora=0;
                foreach ($cartera as $item) {
                    $mora=$mora+$item->saldo;
                }

                if($mora>0){
                    $estadocartera=3;
                }else{
                    $estadocartera=1;
                }

                Control::where('matricula_id',$this->matricula_id)
                            ->update([
                                'mora'=>$mora,
                                'estado_cartera'=>$estadocartera,
                                'ultimo_pago'   =>$this->fecha_pago
                            ]);
            }
        } catch(Exception $exception){
            Log::info('Descargar mora en control matricula_id: ' . $this->matricula_id . ' Actualiza Mora: ' . $exception->getMessage().' Matricula_id-mora: '.$exception->getLine());
        }
        // Notificación
        $this->dispatch('alerta', name:'Se ha creado correctamente el recibo: '.$recibo->numero_recibo);
        $this->resetFields();
        $this->limpiapoyo();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');
        //Enviar por correo electrónico
        $this->claseEmail(1,$recibo->id);


        $ruta='/impresiones/imprecibo?rut='.$this->ruta.'&r='.$recibo->id;

        $this->redirect($ruta);
    }

    //Mostrar componente de transacciones
    public function generatransaccion(){
        $this->is_transac=true;
        $this->is_inventa=false;
        $this->is_recibo=false;
    }

    //Mostrar mov inventario
    public function generaInventario(){
        $this->is_transac=false;
        $this->is_inventa=true;
        $this->is_recibo=false;
    }

    private function sedes(){
        return Sede::query()
                    ->with(['users'])
                    ->when(Auth::user()->id, function($qu){
                        return $qu->where('status', true)
                                ->whereHas('users', function($q){
                                    $q->where('user_id', Auth::user()->id);
                                });
                    })
                    ->orderBy('name')
                    ->get();
    }

    private function estudiantes(){
        $consulta = User::query();

        if($this->buscaestudi){
            $consulta = $consulta->where('name', 'like', "%".$this->buscaestudi."%")
            ->orwhere('email', 'like', "%".$this->buscaestudi."%")
            ->orwhere('documento', 'like', "%".$this->buscaestudi."%");
        }

        return $consulta->orderBy($this->ordena, $this->ordenado)
                        ->paginate($this->pages);
    }

    private function concePagos(){
        $this->concep=ConceptoPago::where('status', true)
                            ->orderBy('name')
                            ->get();

        return $this->concep;
    }

    private function tarjetas(){
        return ConceptoPago::where('status', true)
                            ->where('name', 'like', "%".'Recargo Tarjeta'."%")
                            ->orderBy('name', 'ASC')
                            ->get();
    }

    private function vigentedescuento(){
        return Descuento::where('status', 1)
                            ->get();
    }

    public function render(){
        return view('livewire.financiera.recibo-pago.recibos-pago-crear',[
            'sedes'=>$this->sedes(),
            'estudiantes'=>$this->estudiantes(),
            'concePagos'=>$this->concePagos(),
            'tarjetas'=>$this->tarjetas(),
            'vigentedescuento'=>$this->vigentedescuento(),
        ]);
    }
}
