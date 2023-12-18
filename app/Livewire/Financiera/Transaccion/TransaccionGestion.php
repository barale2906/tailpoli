<?php

namespace App\Livewire\Financiera\Transaccion;

use App\Models\Academico\Control;
use App\Models\Clientes\Pqrs;
use App\Models\Financiera\Transaccion;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TransaccionGestion extends Component
{
    public $actual;
    public $ruta;
    public $transaccion;
    public $observaciones;

    public function mount($elegido, $ruta=null){
        $this->actual=Control::find($elegido);
        $this->ruta=$ruta;
    }

    public function elegida($id){
        $this->transaccion=Transaccion::find($id);
    }
    public function responder(){
        $respuesta=now()." ".Auth::user()->name." CONTESTO A LA TRANSACCIÓN N° ".$this->transaccion->id.": ".$this->observaciones." ----- ";
        $this->transaccion->update([
            'observaciones'=>$respuesta.$this->transaccion->observaciones,
            'status'=>1
        ]);

        Pqrs::create([
            'estudiante_id' =>$this->transaccion->alumno_id,
            'gestion_id'    =>Auth::user()->id,
            'fecha'         =>now(),
            'tipo'          =>2,
            'observaciones' =>'PAGO: '.Auth::user()->name." CONTESTO A LA TRANSACCIÓN N° ".$this->transaccion->id.": ".$this->observaciones." ----- ",
            'status'        =>4
        ]);

        $this->actual->update([
            'observaciones'=>$respuesta.$this->actual->observaciones,
        ]);
        $this->dispatch('alerta', name:'Se guardo la respuesta correctamente.');
        $this->reset('transaccion');
    }


    public function render()
    {
        return view('livewire.financiera.transaccion.transaccion-gestion');
    }
}
