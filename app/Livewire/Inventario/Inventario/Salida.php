<?php

namespace App\Livewire\Inventario\Inventario;

use App\Models\Academico\Control;
use App\Models\Clientes\Pqrs;
use App\Models\Configuracion\Sede;
use App\Models\Financiera\ConceptoPago;
use App\Models\Financiera\ReciboPago;
use App\Models\Financiera\Transaccion;
use App\Models\Inventario\Almacen;
use App\Models\Inventario\Inventario;
use App\Models\Inventario\PagoConfig;
use App\Models\Inventario\Producto;
use App\Models\User;
use App\Traits\MailTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Salida extends Component
{
    use MailTrait;
    use WithPagination;

    public $almacen;
    public $cantidad;
    public $precio;
    public $conceptopago;
    public $sede_id;
    public $ruta;

    public $descripcion;
    public $medio;
    public $medioele;

    public $movimientos;
    public $Total=0;
    public $Totaldescuento=0;
    public $id_ultimo;
    public $saldo;
    public $descuento;
    public $concepdescuento;


    public $producto_id;
    public $producto;

    public $buscapro=null;
    public $buscaproducto=0;
    public $ultimoregistro;

    public $ordena='name';
    public $ordenado='ASC';
    public $pages = 20;

    public $buscar=null;
    public $buscaestudi='';
    public $buscamin='';
    public $alumno;
    public $alumno_id;
    public $configPago;
    public $crt=true;
    public $fin=true;
    public $control=0;
    public $recibo;
    public $banco;
    public $fecha_transaccion;


    public $recargo=0;
    public $recargo_id;
    public $recargoValor=0;

    public $crtSaldo;
    public $saldoObtenido;
    public $saldoFin;

    public $transaccion;


    public function mount($almacen_id=null, $sede_id=null, $ruta=null, $transaccion=null){

        if($transaccion){
            $this->transaccion=Transaccion::find($transaccion);
            $this->selAlumno($this->transaccion->user_id);
            $this->medioele="transferencia";
        }

        $id=intval($almacen_id);
        $this->almacen=Almacen::find($id);

        $ed=intval($sede_id);
        $this->sede_id=$ed;
        $idsector=Sede::whereId($ed)->select('id','sector_id')->first();
        $state=$idsector->sector_id;

        $this->ruta=$ruta;

        $this->listaprecios($state);

        $this->concepto();
    }

    public function updatedMedio(){

        $registro=explode("-",$this->medio);
        if(intval($registro[1])===2){

            $porc=ConceptoPago::find(intval($registro[0]));

            $this->recargo=$porc->valor;
            $this->recargo_id=$porc->id;
            $this->recargoValor=$this->Total*$this->recargo/100;
            $this->Total=$this->Total+$this->recargoValor;
            $this->medioele=$porc->name;
            $this->banco=$porc->name;


            //Cargar valor al recibo
            DB::table('apoyo_recibo')->insert([
                'tipo'=>'financiero',
                'id_creador'=>Auth::user()->id,
                'id_concepto'=>$porc->id,
                'concepto'=>$porc->name,
                'producto'=>$porc->name,
                'cantidad'=>1,
                'subtotal'=>$this->recargoValor,
                'valor'=>$this->recargoValor
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

    public function concepto(){

        $concepdescuento=ConceptoPago::where('status', true)
                                            ->where('name', "Descuento")
                                            ->select('id')
                                            ->first();

        $this->concepdescuento=$concepdescuento->id;

        $this->conceptopago=ConceptoPago::where('status', true)
                                            ->where('tipo', 'inventario')
                                            ->first();
    }

    public function listaprecios($id){
        $this->configPago=PagoConfig::where('sector_id', $id)
                                    ->where('status', true)
                                    ->first();

        if(!$this->configPago){
            $this->dispatch('alerta', name:'No se ha definido costos para esta ciudad');
            $this->crt=!$this->crt;
        }
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
        if($this->transaccion){

            $this->alumno_id=$item;
            $this->alumno=User::find($item);

        }else{
            $this->alumno_id=$item['id'];
            $this->alumno=User::find($item['id']);
            $this->limpiar();
        }

    }

    //Buscar producto
    public function buscaProducto(){
        $this->buscaproducto=strtolower($this->buscapro);
    }

    //Limpiar variables
    public function limpiarpro(){
        $this->reset('producto_id', 'buscapro');
    }

    // Cargar producto
    public function selProduc($item){

        $this->valoRecargo();
        $value = DB::table('pago_configs_producto')
                        ->whereId($item)
                        ->first();

        $this->producto=Producto::find($value->producto_id);
        $this->precio=$value->valor;
        $this->limpiarpro();
        $this->actual();
    }

    //Seleccionar registro activo
    public function actual(){
        $this->ultimoregistro= Inventario::where('almacen_id', $this->almacen->id)
                                        ->where('producto_id', $this->producto->id)
                                        ->where('status', true)
                                        ->first();

        if($this->ultimoregistro){
            $this->saldo=$this->ultimoregistro->saldo;
            $this->id_ultimo=$this->ultimoregistro->id;
        }else{
            $this->saldo=0;
            $this->id_ultimo=0;
        }
    }

    //cargar productos
    public function temporal(){

        $this->saldo=$this->saldo-$this->cantidad;

        $valor=$this->precio*$this->cantidad;

        $this->Total=$this->Total+$valor;


        if($this->saldo>=0){

            DB::table('apoyo_recibo')->insert([
                'tipo'=>'inventario',
                'id_creador'=>Auth::user()->id,
                'id_concepto'=>$this->conceptopago->id,
                'concepto'=>"Entrada de Inventario",
                'valor'=>$this->precio,
                'cantidad'=>$this->cantidad,
                'subtotal'=>$valor,
                'entregado'=>true,
                'id_producto'=>$this->producto->id,
                'producto'=>$this->producto->name,
                'id_almacen'=>$this->almacen->id,
                'almacen'=>$this->almacen->name,
                'id_ultimoreg'=>$this->id_ultimo,
                'saldo'=>$this->saldo,
            ]);


        }else{

            DB::table('apoyo_recibo')->insert([
                'tipo'=>'inventario',
                'id_creador'=>Auth::user()->id,
                'id_concepto'=>$this->conceptopago->id,
                'concepto'=>"Entrada de Inventario",
                'valor'=>$this->precio,
                'cantidad'=>$this->cantidad,
                'subtotal'=>$valor,
                'entregado'=>false,
                'id_producto'=>$this->producto->id,
                'producto'=>$this->producto->name,
                'id_almacen'=>$this->almacen->id,
                'almacen'=>$this->almacen->name,
                'id_ultimoreg'=>$this->id_ultimo,
                'saldo'=>$this->saldo,
            ]);

            $this->dispatch('alerta', name:'¡NO SUFICIENTES, PENDIENTE POR ENTREGA!');

        }

        $this->cargaDescuento();

    }

    public function cargaDescuento(){

        if($this->descuento>0){

            $descuento=$this->descuento*$this->cantidad;

            DB::table('apoyo_recibo')->insert([
                'tipo'          =>'financiero',
                'id_creador'    =>Auth::user()->id,
                'id_concepto'   =>$this->concepdescuento,
                'id_producto'   =>$this->producto->id,
                'producto'      =>'Descuento '.$this->producto->name,
                'concepto'      =>'Descuento',
                'valor'         =>abs($this->descuento),
                'cantidad'      =>$this->cantidad,
                'subtotal'      =>abs($descuento),
            ]);

            $this->Totaldescuento=$this->Totaldescuento+abs($descuento);
        }

        $this->reset('cantidad','precio','producto','producto_id', 'saldo', 'descuento');

        $this->cargando();
    }

    //Eliminar producto
    public function elimOtro($item){


        $reg=DB::table('apoyo_recibo')->whereId($item)->first();

        if($reg->concepto!=='Descuento'){
            $this->Total=$this->Total-$reg->subtotal;

            $aplicado=DB::table('apoyo_recibo')
                        ->where('id_producto', $reg->id_producto)
                        ->where('concepto', 'Descuento')
                        ->first();

            if($aplicado){
                DB::table('apoyo_recibo')
                            ->where('id_producto', $aplicado->id_producto)
                            ->where('concepto', 'Descuento')
                            ->delete();

                $this->Totaldescuento=$this->Totaldescuento-$aplicado->subtotal;
            }
        }

        if($reg->concepto==='Descuento'){
            $this->Totaldescuento=$this->Totaldescuento-$reg->subtotal;
        }

        DB::table('apoyo_recibo')
            ->where('id', $item)
            ->delete();

        $this->cargando();
    }

    //Actualizar registros
    public function cargando(){
        $this->movimientos=DB::table('apoyo_recibo')
                                ->where('id_creador', Auth::user()->id)
                                ->get();
    }

    /**
     * Reglas de validación
     */
    protected $rules = [
        'descripcion'=> 'required'
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
            'cantidad',
            'saldo',
            'precio',
            'descripcion',
            'producto_id',
            'Total',
            'Totaldescuento',
            'alumno_id',
        );
    }

    public function new(){
        // validate
        $this->validate();

        if($this->movimientos->count()>0){

            foreach ($this->movimientos as $value) {

                if($value->tipo!=='financiero'){

                    // Verificar el saldo antes de cargar
                    $evaluapoyo=Inventario::where('almacen_id', $this->almacen->id)
                                            ->where('producto_id', $value->id_producto)
                                            ->where('status', true)
                                            ->select('id','saldo')
                                            ->first();


                    if($evaluapoyo){
                        $this->saldoFin=$evaluapoyo->saldo-$value->cantidad;
                        if($this->saldoFin>=0){

                            $this->crtSaldo=1;

                        }else if($this->saldoFin<0){

                            $this->crtSaldo=0;
                            $this->saldoFin=$evaluapoyo->saldo;
                        }

                    }else{
                        $this->saldoFin=0;
                        $this->crtSaldo=0;
                    }

                    if($this->crtSaldo===1){

                        $inventa = Inventario::create([
                                            'tipo'=>0,
                                            'fecha_movimiento'=>now(),
                                            'cantidad'=>$value->cantidad,
                                            'saldo'=>$this->saldoFin,
                                            'precio'=>$value->valor,
                                            'descripcion'=>$this->descripcion,
                                            'almacen_id'=>$value->id_almacen,
                                            'producto_id'=>$value->id_producto,
                                            'user_id'=>Auth::user()->id,
                                            'compra_id'=>$this->alumno_id,
                                            'entregado'=>true
                                        ]);

                        Pqrs::create([
                                'estudiante_id' =>$this->alumno_id,
                                'gestion_id'    =>Auth::user()->id,
                                'fecha'         =>now(),
                                'tipo'          =>1,
                                'observaciones' =>'GESTIÓN:  Kit (C) ----- ',
                                'status'        =>4
                            ]);

                        $con=Control::where('estudiante_id', $this->alumno_id)
                            ->where('status', true)
                            ->get();




                        if($con){

                            foreach ($con as $value) {

                                //$observa=now().", Kit (C) --- ".$value->observaciones;

                                Control::whereId($value->id)
                                        ->update([
                                            'overol'=>'si',
                                            'compra'=>now(),
                                            'entrega'=>now(),
                                            //'observaciones'=>$observa
                                        ]);
                            }
                        }


                        $evaluapoyo->update([
                            'status'=>false
                            ]);

                        DB::table('apoyo_recibo')
                            ->whereId($value->id)
                            ->update([
                                'id_cartera'=>$inventa->id
                            ]);


                    }else{

                        $inventa = Inventario::create([
                                                'tipo'=>2,
                                                'fecha_movimiento'=>now(),
                                                'cantidad'=>$value->cantidad,
                                                'saldo'=>$this->saldoFin,
                                                'precio'=>$value->valor,
                                                'descripcion'=>$this->descripcion,
                                                'almacen_id'=>$value->id_almacen,
                                                'producto_id'=>$value->id_producto,
                                                'user_id'=>Auth::user()->id,
                                                'compra_id'=>$this->alumno_id,
                                                'entregado'=>false,
                                                'status'=>false,
                                                ]);

                        $con=Control::where('estudiante_id', $this->alumno_id)
                            ->where('status', true)
                            ->get();

                        Pqrs::create([
                            'estudiante_id' =>$this->alumno_id,
                            'gestion_id'    =>Auth::user()->id,
                            'fecha'         =>now(),
                            'tipo'          =>1,
                            'observaciones' =>'GESTIÓN: Overol (P) -----',
                            'status'        =>4
                        ]);

                        if($con){
                            foreach ($con as $value) {
                                //$observa=now().", Overol (P) --- ".$value->observaciones;

                                Control::whereId($value->id)
                                        ->update([
                                            'overol'=>'pendiente',
                                            'compra'=>now(),
                                            //'observaciones'=>$observa
                                        ]);
                            }
                        }


                        DB::table('apoyo_recibo')
                            ->whereId($value->id)
                            ->update([
                                    'entregado'=>false,
                                    'status'=>false
                                ]);

                            $this->control=$this->control+1;
                        /* $costo=$value->cantidad*$value->valor;
                        $this->Total=$this->Total-$costo; */
                    }

                }

            }

            //Generar Recibo de Pago

            $this->recibo();

        }else{
            $this->dispatch('alerta', name:'Debe cargar productos');
        }

    }

    public function recibo(){

        if($this->Total>0){

            $corregido=strtolower($this->descripcion);
            $comentarios=now()." ".$this->alumno->name." realizo pago por ".number_format($this->Total, 0, ',', '.').". --- ".$corregido;

            $ultimo=ReciboPago::where('origen',false)
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

            //Crear recibo
            $this->recibo= ReciboPago::create([
                'numero_recibo'=>$recibo,
                'origen'=>false,
                'fecha'=>now(),
                'valor_total'=>$this->Total,
                'descuento'=>$this->Totaldescuento,
                'medio'=>$this->medioele,
                'banco'=>$this->banco,
                'fecha_transaccion'=>$this->fecha_transaccion,
                'observaciones'=>$comentarios,
                'sede_id'=>$this->sede_id,
                'creador_id'=>Auth::user()->id,
                'paga_id'=>$this->alumno_id
            ]);

            //registros

            $cargados=DB::table('apoyo_recibo')
                            ->where('id_creador', Auth::user()->id)
                            //->where('status', true)
                            ->orderBy('producto')
                            ->get();

            /* if($this->recargo>0){
                DB::table('concepto_pago_recibo_pago')
                    ->insert([
                        'valor'=>$this->recargoValor,
                        'tipo'=>"otro",
                        'medio'=>$this->medio,
                        'concepto_pago_id'=>$this->recargo_id,
                        'recibo_pago_id'=>$this->recibo->id,
                        'created_at'=>now(),
                        'updated_at'=>now(),
                    ]);
            } */

            foreach ($cargados as $value) {

                DB::table('concepto_pago_recibo_pago')
                    ->insert([
                        'valor'=>$value->subtotal,
                        'tipo'=>$value->tipo,
                        'medio'=>$this->medioele,
                        'producto'=>$value->producto,
                        'cantidad'=>$value->cantidad,
                        'unitario'=>$value->valor,
                        'subtotal'=>$value->subtotal,
                        'id_relacional'=>$value->id_cartera,
                        'concepto_pago_id'=>$this->conceptopago->id,
                        'recibo_pago_id'=>$this->recibo->id,
                        'created_at'=>now(),
                        'updated_at'=>now(),
                    ]);

            }

            //Eliminar datos de apoyo
            DB::table('apoyo_recibo')
                ->where('id_creador', Auth::user()->id)
                ->where('status', true)
                ->delete();

            if($this->control>0){
                $this->movimientos=DB::table('apoyo_recibo')
                                    ->where('id_creador', Auth::user()->id)
                                    ->where('status', false)
                                    ->orderBy('producto')
                                    ->get();
            }
            // Notificación
            $this->dispatch('alerta', name:'Se ha cargado correctamente el movimiento de inventario y generado el recibo N°: '.$this->recibo->numero_recibo);
            $this->resetFields();
            $this->fin=!$this->fin;
            $this->dispatch('mostodo');

            //Descargar la transaccion
            if($this->transaccion){
                $respuesta=now()." ".Auth::user()->name." Genero recibo por los productos N°".$this->recibo->numero_recibo." ----- ";
                $this->transaccion->update([
                    'observaciones'=>$respuesta.$this->transaccion->observaciones,
                    'status'=>4
                ]);

                Pqrs::create([
                    'estudiante_id' =>$this->alumno_id,
                    'gestion_id'    =>Auth::user()->id,
                    'fecha'         =>now(),
                    'tipo'          =>1,
                    'observaciones' =>'GESTIÓN: GENERO RECIBO POR LOS PRODUCTOS ----- ',
                    'status'        =>4
                ]);

                /* $actu=Control::whereId($this->transaccion->control_id)->first();

                $actu->update([
                            'observaciones'=>$respuesta.$actu->observaciones,
                        ]); */

            }

            //Enviar por correo electrónico
            $this->claseEmail(1,$this->recibo->id);

            $ruta='/impresiones/imprecibo?rut='.$this->ruta.'&r='.$this->recibo->id;


            $this->redirect($ruta);

        } else{
            $this->dispatch('borrarMov');
            $this->cargando();
            $this->dispatch('alerta', name:'Verifique los saldos, variaron los saldos');
        }




    }

    public function finalizar(){
        //refresh
        $this->dispatch('refresh');
        $this->dispatch('borrarMov');
        $this->dispatch('created');

        $ruta='/impresiones/imprecibo?rut='.$this->ruta.'&r='.$this->recibo->id;

        $this->redirect($ruta);
    }


    //Productos
    private function productos(){

        if($this->configPago){
            return DB::table('pago_configs_producto')
                        ->where('pago_configs_id', $this->configPago->id)
                        ->where('name', 'like', "%".$this->buscaproducto."%")
                        ->orderBy('name')
                        ->get();
        }
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

    private function tarjetas(){
        return ConceptoPago::where('status', true)
                            ->where('name', 'like', "%".'Recargo Tarjeta'."%")
                            ->orderBy('name', 'ASC')
                            ->get();
    }

    public function render()
    {
        return view('livewire.inventario.inventario.salida',[
            'estudiantes'   =>$this->estudiantes(),
            'productos'     =>$this->productos(),
            'tarjetas'      =>$this->tarjetas(),
        ]);
    }
}
