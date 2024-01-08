<?php

namespace App\Livewire\Financiera\ReciboPago;

use App\Models\Academico\Control;
use App\Models\Academico\Matricula;
use App\Models\Clientes\Pqrs;
use App\Models\Configuracion\Sede;
use App\Models\Financiera\Cartera;
use App\Models\Financiera\ConceptoPago;
use App\Models\Financiera\ConfPagOtros;
use App\Models\Financiera\ConfPagOtrosDet;
use App\Models\Financiera\EstadoCartera;
use App\Models\Financiera\ReciboPago;
use App\Models\Financiera\Transaccion;
use App\Models\User;
use App\Traits\ComunesTrait;
use App\Traits\MailTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class RecibosPagoCrear extends Component
{
    use WithPagination;
    use ComunesTrait;
    use MailTrait;

    public $medio='';
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

    public $listaotros;


    public $valor=0;
    public $conceptos=0;
    public $concep=[];
    public $nameConcep;
    public $Total=0;
    public $subtotal;
    public $control=[];

    public $buscar=null;
    public $buscaestudi='';

    public $alumno_id='';
    public $alumnoName='';
    public $alumnodocumento='';

    public $ordena='name';
    public $ordenado='ASC';
    public $pages = 20;

    public $transaccion;
    public $status_transa;

    public $pendientes;

    public function mount($ruta=null, $elegido=null, $estudiante=null){
        DB::table('apoyo_recibo')
            ->where('id_creador', Auth::user()->id)
            ->delete();

        $this->ruta=$ruta;

        if($elegido){
            $this->transaccion=Transaccion::find($elegido);
            $this->variables();
        }

        if($estudiante){
            $alum=User::find($estudiante);
            $this->alumno_id=$alum->id;
            $this->alumnoName=$alum->name;
            $this->alumnodocumento=$alum->documento;
            $this->obligaciones();
        }

        $this->cierre();
    }

    public function variables(){
        $this->alumno_id=$this->transaccion->alumno_id;
        $this->alumnoName=$this->transaccion->alumno->name;
        $this->alumnodocumento=$this->transaccion->alumno->documento;
        $this->sede_id=$this->transaccion->sede_id;
        $this->obligaciones();
    }

    public function updatedSedeId(){
        $sede=Sede::find($this->sede_id);
        $config=ConfPagOtros::where('status', true)
                                        ->where('sector_id', $sede->sector_id)
                                        ->select('id')
                                        ->first();

        if($config){
            $this->listaotros=ConfPagOtrosDet::where('conf_pag_otro_id', $config->id)
                                            ->where('status', true)
                                            ->orderBy('name', 'ASC')
                                            ->get();
        }else{
            $this->dispatch('alerta', name:'No hay lista de precios para esta sede');
        }



    }

    #[On('cargados')]
    //obtener itemes cargados
    public function cargando(){
        $this->cargados=DB::table('apoyo_recibo')
                            ->where('id_creador', Auth::user()->id)
                            ->orderBy('tipo')
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

    public function obligaciones(){
        $this->pendientes= Cartera::where('responsable_id', $this->alumno_id)
                                ->where('status', true)
                                ->orderBy('fecha_pago')
                                ->get();

        $this->totalCartera=Cartera::where('responsable_id', $this->alumno_id)
                                    ->where('status', true)
                                    ->sum('saldo');
    }

    public function asigOtro($id, $item,$conf=null){

        $this->valoRecargo();
        //dd($conf);
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
                'name'
                );
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
                        'concepto'=>$this->nameConcep,
                        'valor'=>$this->valor,
                        'saldo'=>$this->saldo,
                        'id_cartera'=>$this->id_cartera,
                        'subtotal'=>$this->subtotal
                    ]);

                    $this->Total=$this->Total+$this->valor;

                    $this->reset(
                                'valor' ,
                                'conceptos',
                                'name'
                                );

                    $this->cargando();
            }else{
                $this->dispatch('alerta', name:'VALOR Mayor que cero');
                $this->reset(
                    'valor' ,
                    'conceptos',
                    'name'
                    );
            }

        }



    }

    public function elimOtro($item, $valor){

        $this->valoRecargo();

        DB::table('apoyo_recibo')
            ->where('id', $item)
            ->delete();

        $this->Total=$this->Total-$valor;

        $this->cargando();
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
                    'sede_id'
                    );
    }

    // Crear Regimen de Salud
    public function new(){
        // validate
        $this->validate();

        $this->fecha_pago=now();

        if($this->pagoTotal){
            $this->Total=$this->totalCartera;
        }



        $ultimo=ReciboPago::where('origen', true)
                                ->max('numero_recibo');


        if($ultimo){
            $recibo=$ultimo+1;
        }else{
            $recibo=1;
        }

        //Crear registro
        $recibo= ReciboPago::create([
                                'numero_recibo'=>$recibo,
                                'origen'=>true,
                                'fecha'=>$this->fecha_pago,
                                'valor_total'=>$this->Total,
                                'medio'=>$this->medio,
                                'observaciones'=>strtolower($this->observaciones).$this->obser,
                                'sede_id'=>$this->sede_id,
                                'creador_id'=>Auth::user()->id,
                                'paga_id'=>$this->alumno_id
                            ]);

        //registros

        /* if($this->recargo>0){
            DB::table('concepto_pago_recibo_pago')
                ->insert([
                    'valor'=>$this->recargoValor,
                    'tipo'=>"otro",
                    'medio'=>$this->medio,
                    'concepto_pago_id'=>$this->recargo_id,
                    'recibo_pago_id'=>$recibo->id,
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ]);
        } */

        if($this->pagoTotal){

            $esta=EstadoCartera::where('name', 'cerrada')->first();
                        $this->estado=$esta->id;
                        $this->status=false;

            foreach ($this->pendientes as $value) {

                DB::table('concepto_pago_recibo_pago')
                    ->insert([
                        'valor'=>$value->saldo,
                        'tipo'=>"cartera",
                        'medio'=>$this->medio,
                        'id_relacional'=>$value->id,
                        'concepto_pago_id'=>$value->concepto_pago_id,
                        'recibo_pago_id'=>$recibo->id,
                        'created_at'=>now(),
                        'updated_at'=>now(),
                    ]);

                $observa=now()." ".$this->alumnoName." realizo pago por ".number_format($value->saldo, 0, ',', '.').", con el recibo N°: ".$recibo->id.". --- ".$value->observaciones;

                Cartera::whereId($value->id)
                        ->update([
                            'fecha_real'=>now(),
                            'saldo'=>0,
                            'observaciones'=>$observa,
                            'status'=>$this->status,
                            'estado_cartera_id'=>$this->estado
                        ]);
            }

        }else{
            foreach ($this->cargados as $value) {

                DB::table('concepto_pago_recibo_pago')
                    ->insert([
                        'valor'=>$value->valor,
                        'tipo'=>$value->tipo,
                        'medio'=>$this->medio,
                        'id_relacional'=>$value->id_cartera,
                        'concepto_pago_id'=>$value->id_concepto,
                        'recibo_pago_id'=>$recibo->id,
                        'created_at'=>now(),
                        'updated_at'=>now(),
                    ]);

                if($value->tipo==="cartera"){

                    $item=Cartera::find($value->id_cartera);
                    $saldo=$item->saldo-$value->valor;
                    $observa=now()." ".$this->alumnoName." realizo pago por ".number_format($value->valor, 0, ',', '.').", con el recibo N°: ".$recibo->id.". --- ".$item->observaciones;

                    if($saldo>0){
                        $esta=EstadoCartera::where('name', 'abonada')->first();
                        $this->estado=$esta->id;
                        $this->status=true;
                    }else{
                        $esta=EstadoCartera::where('name', 'cerrada')->first();
                        $this->estado=$esta->id;
                        $this->status=false;
                    }

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
                        'estado_cartera_id'=>1
                    ]);
                }

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
                        'ultimo_pago'   =>$this->fecha_pago
                    ]);
        }


        //Actualiza la transacción
        if($this->transaccion){
            $observa=now()." ".Auth::user()->name." GENERO RECIBO DE PAGO N°: ".$recibo->numero_recibo." ----- ";
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

        // Notificación
        $this->dispatch('alerta', name:'Se ha creado correctamente el recibo: '.$recibo->numero_recibo);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');

        //Enviar por correo electrónico
        $this->claseEmail(1,$recibo->id);


        $ruta='/impresiones/imprecibo?rut='.$this->ruta.'&r='.$recibo->id;

        $this->redirect($ruta);
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
        /* return User::where('name', 'like', "%".$this->buscaestudi."%")
                        ->orWhere('documento', 'like', "%".$this->buscaestudi."%")
                        ->orderBy('name')
                        ->with('roles')->get()->filter(
                            fn ($user) => $user->roles->where('name', 'Estudiante')->toArray()
                        ); */
    }

    private function concePagos(){
        $this->concep=ConceptoPago::where('status', true)
                            ->orderBy('name')
                            ->get();

        return $this->concep;
    }

    public function render(){
        return view('livewire.financiera.recibo-pago.recibos-pago-crear',[
            'sedes'=>$this->sedes(),
            'estudiantes'=>$this->estudiantes(),
            'concePagos'=>$this->concePagos()
        ]);
    }
}
