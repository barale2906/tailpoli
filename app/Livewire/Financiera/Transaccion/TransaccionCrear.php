<?php

namespace App\Livewire\Financiera\Transaccion;

use App\Models\Clientes\Pqrs;
use App\Models\Configuracion\Sede;
use App\Models\Financiera\Transaccion;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class TransaccionCrear extends Component
{
    use WithFileUploads;

    public $soporte;

    public $actual;
    public $editarlo;
    public $observacion;
    public $observaciones;
    public $sede_id;
    public $banco;
    public $opcion;
    public $url;

    public $otro=0;
    public $academico=0;
    public $fecha_transaccion;
    public $total;
    public $is_otro=false;
    public $is_academico=false;


    public function mount($elegido,$ruta=null){

        if($ruta){
            $this->editarlo=Transaccion::find($elegido);
            $this->asignardatos();
        }else{
            $this->actual=User::find($elegido);
        }

        //$this->observacion=now()." ".Auth::user()->name." Cargo soporte de consignación. ----- ".$this->actual->observaciones;
    }

    public function asignardatos(){

        $this->actual=User::find($this->editarlo->user_id);
        $this->sede_id=$this->editarlo->sede_id;
        $this->total=$this->editarlo->total;
        $this->fecha_transaccion=$this->editarlo->fecha_transaccion;
        $this->banco=$this->editarlo->banco;

        $this->is_academico=true;
        $this->is_otro=true;
        $this->academico=$this->editarlo->academico;
        $this->otro=$this->editarlo->inventario;

    }

    public function updatedOpcion(){
        $opc=intval($this->opcion);
        $this->reset(
                        'is_academico',
                        'is_otro',
                        'academico',
                        'otro'
                    );

        switch ($opc) {
            case 1:
                $this->is_academico=!$this->is_academico;
                $this->otro=0;
                break;

            case 2:
                $this->is_otro=!$this->is_otro;
                $this->academico=0;
                break;

            case 3:
                $this->is_academico=!$this->is_academico;
                $this->is_otro=!$this->is_otro;
                break;
        }
    }

    /**
     * Reglas de validación
     */
    protected $rules = [
        'soporte'       => 'required|mimes:jpg,bmp,png,pdf,jpeg',
        'observaciones' => 'required',
        'sede_id'       => 'required|integer',
        'academico'     => 'required',
        'otro'          => 'required',
        'total'         => 'required',
        'fecha_transaccion' => 'required',
        'banco'         => 'required',
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
                        'soporte',
                        'observaciones',
                        'observacion',
                        'sede_id',
                        'academico',
                        'otro',
                        'total',
                        'fecha_transaccion',
                        'banco'
                    );
    }

    private function sedes(){
        return Sede::where('status', true)
                    ->orderBy('name')
                    ->get();
    }

    public function crear(){

        $suma=$this->academico+$this->otro;

        if($suma===intval($this->total)){
            // Validar si ya esta cargado
            $esta=Transaccion::where('fecha_transaccion', $this->fecha_transaccion)
                                ->where('total', intval($this->total))
                                ->where('user_id', $this->actual->id)
                                ->where('status','<',5)
                                ->count('id');

            if($esta>0){
                $this->dispatch('alerta', name:$this->actual->name.' ya registro un pago con ese soporte.');
            }else{
                $this->new();
            }
        }else{
            $this->dispatch('alerta', name:'La suma de los itemes no es igual al total de la transacción.');
            $this->reset('academico', 'otro');
        }

    }

    public function new(){

        // validate
        $this->validate();

        $nombre=null;

        $nombre='public_soportes/'.$this->actual->id."-".uniqid().".".$this->soporte->extension();
        $this->soporte->storeAs($nombre);

        Transaccion::create([
            'creador_id'=>Auth::user()->id,
            'gestionador_id'=>Auth::user()->id,
            'user_id'=>$this->actual->id,
            'sede_id'=>$this->sede_id,
            'fecha'=>now(),
            'ruta'=>$nombre,
            'extension'=>$this->soporte->extension(),
            'academico'=>intval($this->academico),
            'inventario'=>intval($this->otro),
            'fecha_transaccion'=>$this->fecha_transaccion,
            'banco'=>$this->banco,
            'total'=>intval($this->total),
            'observaciones'=>$this->observaciones,
        ]);

        //Actualizar control
        /*  $this->actual->update([
            'observaciones'=>$this->observacion,
        ]); */

        Pqrs::create([
            'estudiante_id' =>$this->actual->id,
            'gestion_id'    =>Auth::user()->id,
            'fecha'         =>now(),
            'tipo'          =>2,
            'observaciones' =>'PAGO: Cargo soporte de consignación. ----- ',
            'status'        =>4
        ]);

        $this->dispatch('alerta', name:'Se cargo soporte de pago para: '.$this->actual->name);

        //refresh
        $this->resetFields();
        $this->dispatch('refresh');
        $this->dispatch('cancelando');
    }

    public function editar(){

        $suma=intval($this->academico)+intval($this->otro);

        if($suma===intval($this->total) && $this->observaciones){

            $this->editarlo->update([

                'gestionador_id'=>Auth::user()->id,
                'user_id'=>$this->actual->id,
                'sede_id'=>$this->sede_id,
                'academico'=>intval($this->academico),
                'inventario'=>intval($this->otro),
                'fecha_transaccion'=>$this->fecha_transaccion,
                'banco'=>$this->banco,
                'total'=>intval($this->total),
                'observaciones'=>now().' '.Auth::user()->name.': ¡MODIFCO LA SOLICITUD! '.$this->observaciones." ----- ".$this->editarlo->observaciones,

            ]);

            //refresh
            $this->resetFields();
            $this->dispatch('refresh');
            $this->dispatch('cambiando');
            $this->dispatch('alerta', name:'Se actualizo correctamente');

        }else{
            $this->dispatch('alerta', name:'La suma de los itemes no es igual al total de la transacción y / o registre observaciones.');
        }

    }

    public function anular(){
        if($this->observaciones){
            $this->editarlo->update([
                'status'=>5,
                'observaciones'=>now().' '.Auth::user()->name.': ¡ANULO LA SOLICITUD!: '.$this->observaciones." ----- ".$this->editarlo->observaciones,
            ]);

            //refresh
            $this->resetFields();
            $this->dispatch('refresh');
            $this->dispatch('cancelando');
            $this->dispatch('alerta', name:'Se anulo correctamente la solicitud N°: '.$this->editarlo->id);

        }else{
            $this->dispatch('alerta', name:'Registre observaciones de cierre.');
        }
    }

    public function render()
    {
        return view('livewire.financiera.transaccion.transaccion-crear',[
            'sedes'=>$this->sedes(),
        ]);
    }
}
