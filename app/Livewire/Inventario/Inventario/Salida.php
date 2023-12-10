<?php

namespace App\Livewire\Inventario\Inventario;

use App\Models\Academico\Control;
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

class Salida extends Component
{
    use MailTrait;

    public $almacen;
    public $cantidad;
    public $precio;
    public $conceptopago;
    public $sede_id;
    public $ruta;

    public $descripcion;
    public $medio;

    public $movimientos;
    public $Total=0;
    public $id_ultimo;
    public $saldo;


    public $producto_id;
    public $producto;

    public $buscapro=null;
    public $buscaproducto=0;
    public $ultimoregistro;

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
            $this->selAlumno($this->transaccion->alumno_id);
            $this->medio="transferencia";
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

        if($this->medio==="tarjeta"){

            $porc=ConceptoPago::where('status', true)
                                ->where('name', 'Recargo Tarjeta')
                                ->first();

            $this->recargo=$porc->valor;
            $this->recargo_id=$porc->id;
            $this->recargoValor=$this->Total*$this->recargo/100;
            $this->Total=$this->Total+$this->recargoValor;


            //Cargar valor al recibo
            DB::table('apoyo_recibo')->insert([
                'tipo'=>'financiero',
                'id_creador'=>Auth::user()->id,
                'id_concepto'=>$porc->id,
                'concepto'=>$porc->name,
                'producto'=>'Recargo Tarjeta',
                'cantidad'=>1,
                'subtotal'=>$this->recargoValor,
                'valor'=>$this->recargoValor
            ]);

            $this->cargando();

        }else{
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
        $this->conceptopago=ConceptoPago::where('tipo', 'inventario')
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

        $this->reset('cantidad','precio','producto','producto_id', 'saldo');
        $this->cargando();


    }

    //Eliminar producto
    public function elimOtro($item){

        $this->valoRecargo();
        $prod=DB::table('apoyo_recibo')->whereId($item)->first();

        DB::table('apoyo_recibo')
            ->where('id', $item)
            ->delete();

        $valori=$prod->valor*$prod->cantidad;
        $this->Total=$this->Total-$valori;


        $this->cargando();
    }

    //Actualizar registros
    public function cargando(){
        $this->movimientos=DB::table('apoyo_recibo')
                                ->where('id_creador', Auth::user()->id)
                                ->orderBy('producto')
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
            'producto_id'
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

                        $con=Control::where('estudiante_id', $this->alumno_id)
                            ->where('status', true)
                            ->get();


                        if($con){

                            foreach ($con as $value) {

                                $observa=now().", Kit (C) --- ".$value->observaciones;

                                Control::whereId($value->id)
                                        ->update([
                                            'overol'=>'si',
                                            'compra'=>now(),
                                            'entrega'=>now(),
                                            'observaciones'=>$observa
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

                        if($con){
                            foreach ($con as $value) {
                                $observa=now().", Overol (P) --- ".$value->observaciones;

                                Control::whereId($value->id)
                                        ->update([
                                            'overol'=>'pendiente',
                                            'compra'=>now(),
                                            'observaciones'=>$observa
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

            //Crear recibo
            $this->recibo= ReciboPago::create([
                'numero_recibo'=>$recibo,
                'origen'=>false,
                'fecha'=>now(),
                'valor_total'=>$this->Total,
                'medio'=>$this->medio,
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
                        'medio'=>$this->medio,
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
                $respuesta=now()." ".Auth::user()->name." GENERO RECIBO POR LOS PRODUCTOS ----- ";
                $this->transaccion->update([
                    'observaciones'=>$respuesta.$this->transaccion->observaciones,
                    'status'=>4
                ]);

                $actu=Control::whereId($this->transaccion->control_id)->first();

                $actu->update([
                            'observaciones'=>$respuesta.$actu->observaciones,
                        ]);

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
        return User::where('status', true)
                        ->where('name', 'like', "%".$this->buscaestudi."%")
                        ->orWhere('documento', 'like', "%".$this->buscaestudi."%")
                        ->orderBy('name')
                        ->with('roles')->get()->filter(
                            fn ($user) => $user->roles->where('name', 'Estudiante')->toArray()
                        );
    }

    public function render()
    {
        return view('livewire.inventario.inventario.salida',[
            'estudiantes'   =>$this->estudiantes(),
            'productos'     =>$this->productos()
        ]);
    }
}
