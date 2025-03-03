<?php

namespace App\Livewire\Academico\Gestion;

use App\Models\Academico\Control;
use App\Models\Clientes\Pqrs;
use App\Models\Financiera\Cartera;
use App\Models\Financiera\ReciboPago;
use App\Models\Financiera\Transaccion;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Observaciones extends Component
{
    public $elegido;
    public $comentarios;
    public $fecha;
    public $ruta;
    public $alumno;
    //public $observaciones=[];
    public $historialAlumno;

    public function mount($elegido=null, $ruta=null){
        $this->ruta=$ruta;
        $this->elegido=Control::where('estudiante_id',$elegido)->first();
        $this->fecha=now();
        $this->alumn();
        //$this->arraobserva();
        $this->historial();
    }

    public function historial(){
        $this->historialAlumno=Pqrs::where('estudiante_id', $this->elegido->estudiante_id)
                                    ->orderBy('fecha', 'DESC')
                                    ->get();
    }

    public function arraobserva(){
        //$this->observaciones=explode("-----", $this->elegido->observaciones);
    }

    public function alumn(){
        $this->alumno=$this->elegido->estudiante_id;
    }

    public function guardar(){

        Pqrs::create([
            'estudiante_id' =>$this->elegido->estudiante_id,
            'gestion_id'    =>Auth::user()->id,
            'fecha'         =>now(),
            'tipo'          =>1,
            'observaciones' =>'GESTIÓN: '.Auth::user()->name." escribio: ".$this->comentarios." ----- ",
            'status'        =>1
        ]);

        $this->dispatch('alerta', name:'Comentario guardado satisfactoriamente');

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');
    }

    private function cartera(){
        return Cartera::where('responsable_id', $this->elegido->estudiante_id)
                        ->whereNot('estado_cartera_id',5)
                        ->orderBy('matricula_id', 'ASC')
                        ->orderBy('fecha_pago', 'ASC')
                        ->get();
    }

    private function saldoCartera(){
        return Cartera::where('responsable_id', $this->elegido->estudiante_id)
                        ->where('estado_cartera_id', '<',5)
                        ->sum('saldo');
    }

    private function recibos(){
        return ReciboPago::where('paga_id', $this->elegido->estudiante_id)
                            ->get();
    }

    private function transacciones(){
        return Transaccion::where('user_id', $this->elegido->estudiante_id)
                            ->get();
    }

    public function render()
    {
        return view('livewire.academico.gestion.observaciones',[
            'cartera'=>$this->cartera(),
            'saldocartera'=>$this->saldoCartera(),
            'recibos'=>$this->recibos(),
            'transacciones'=>$this->transacciones()
        ]);
    }
}
