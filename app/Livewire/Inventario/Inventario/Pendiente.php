<?php

namespace App\Livewire\Inventario\Inventario;

use App\Models\Academico\Control;
use App\Models\Clientes\Pqrs;
use App\Models\Inventario\Inventario;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Pendiente extends Component
{
    public $pendientes;
    public $ids=[];
    public $productos;
    public $entregar=[];
    public $almacen_id;
    public $sede_id;
    public $ruta;
    public $alumno_id;
    public $producto_id;
    public $saldoFin;
    public $crtSaldo;

    public function mount($almacen_id, $sede_id, $ruta){

        $id=intval($almacen_id);
        $se=intval($sede_id);

        $this->almacen_id=$id;
        $this->sede_id=$se;
        $this->ruta=$ruta;

        $this->obtieneIds();
    }

    public function obtieneIds(){

        $this->productos=Inventario::Where('entregado', false)
                                    ->where('tipo', 2)
                                    ->get();

        foreach ($this->productos as $value) {

            if(in_array($value->compra_id, $this->ids)){

            }else{
                array_push($this->ids, $value->compra_id);
            }
        }

        $this->usuariosPendientes();
    }

    public function usuariosPendientes(){

        $this->pendientes=User::whereIn('id', $this->ids)
                                ->orderBy('name', 'ASC')
                                ->get();
    }

    public function updatedAlumnoId(){

        $this->reset('productos', 'entregar');

        $this->productos=Inventario::where('compra_id', $this->alumno_id)
                                    ->where('entregado', false)
                                    ->get();
    }

    public function cargar($item){
        $ele=Inventario::find($item);

        $pr=Inventario::where('producto_id', $ele->producto_id)
                        ->where('almacen_id', $this->almacen_id)
                        ->where('entregado', true)
                        ->where('status', true)
                        ->orderBy('id','ASC')
                        ->first();

        //dd($ele, $pr, $ele->producto_id, $this->almacen_id);

        if($pr){
            if($pr->cantidad>=$ele->cantidad){
                $nuevo=[
                    'id'          =>$pr->id,
                    'saldo'       =>$pr->saldo,
                    'idpen'       =>$ele->id,
                    'cantidad'    =>$ele->cantidad,
                    'producto_id' =>$ele->producto_id,
                    'name'        =>$ele->producto->name,
                    'precio'      =>$ele->precio
                ];



                if(in_array($nuevo, $this->entregar )){
                    dd($nuevo, "ps");
                }else{
                    array_push($this->entregar, $nuevo);
                }
            }
        }else{
            $this->dispatch('alerta', name:'Aún no hay inventario de este producto en este almacén');
        }


    }

    public function eliminar($item){
        foreach ($this->entregar as $value) {
            if($value['id']===$item){

                $nuevo=[
                    'id'          =>$value['id'],
                    'saldo'       =>$value['saldo'],
                    'idpen'       =>$value['idpen'],
                    'cantidad'    =>$value['cantidad'],
                    'producto_id' =>$value['producto_id'],
                    'name'        =>$value['name'],
                    'precio'      =>$value['precio']
                ];

                $indice=array_search($nuevo,$this->entregar,true);
                unset($this->entregar[$indice]);
            }
        }
    }

    public function entregando(){

        foreach ($this->entregar as $value) {

            // Verificar el saldo antes de cargar
            $evaluapoyo=Inventario::where('almacen_id', $this->almacen_id)
                                    ->where('producto_id', $value['producto_id'])
                                    ->where('status', true)
                                    ->where('entregado', true)
                                    ->select('id','saldo')
                                    ->orderBy('id','DESC')
                                    ->first();

            if($evaluapoyo){

                $this->saldoFin=$evaluapoyo->saldo-$value['cantidad'];

                if($this->saldoFin>=0){

                    $this->crtSaldo=1;

                }
            }



            if($this->crtSaldo===1){

                Inventario::create([
                            'tipo'=>0,
                            'fecha_movimiento'=>now(),
                            'cantidad'=>$value['cantidad'],
                            'saldo'=>$this->saldoFin,
                            'precio'=>$value['precio'],
                            'descripcion'=>"Entrega de pendiente",
                            'almacen_id'=>$this->almacen_id,
                            'producto_id'=>$value['producto_id'],
                            'user_id'=>Auth::user()->id,
                            'compra_id'=>$this->alumno_id,
                            'entregado'=>true
                        ]);

                //Descargar el pendiente
                $actua =Inventario::whereId($value['idpen'])->first();
                $descripcion=now()." ".Auth::user()->name.", se entrega el pendiente. ---- ".$actua->descripcion;


                $actua->update([
                                'entregado'=>true,
                                'descripcion'=>$descripcion,
                            ]);

                $con=Control::where('estudiante_id', $this->alumno_id)
                        ->where('status', true)
                        ->get();

                Pqrs::create([
                    'estudiante_id' =>$this->alumno_id,
                    'gestion_id'    =>Auth::user()->id,
                    'fecha'         =>now(),
                    'tipo'          =>1,
                    'observaciones' =>'GESTIÓN:  Kit entrega (p) ----- ',
                    'status'        =>4
                ]);



                if($con){

                    foreach ($con as $value) {

                        //$observa=now().", Kit entrega (p) --- ".$value->observaciones;

                        Control::whereId($value->id)
                                ->update([
                                    'overol'=>'si',
                                    'entrega'=>now(),
                                    //'observaciones'=>$observa
                                ]);
                    }
                }


                $evaluapoyo->update([
                    'status'=>false
                ]);

            }

        }

        $hoy=Carbon::now();
        $hoy->format('Y-m-d');

        $this->dispatch('alerta', name:'Se registro la entrega correctamente');

        $ruta='/impresiones/impRemision?rut='.$this->ruta.'&r='.$this->alumno_id.'&fecha='.$hoy;

        $this->redirect($ruta);
    }


    public function render()
    {
        return view('livewire.inventario.inventario.pendiente');
    }
}
