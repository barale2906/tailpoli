<?php

namespace App\Livewire\Financiera\Transaccion;

use App\Models\Academico\Control;
use App\Models\Financiera\Transaccion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class TransaccionEditar extends Component
{
    public $actual;
    public $url;
    public $opcion;
    public $observaciones;
    public $observa;
    public $status;
    public $ruta=3;
    public $control;
    public $status_inventario;

    public $is_recibo=false;

    public function mount($elegido){
        $this->actual=Transaccion::find($elegido);
        $this->obteUrl();
        $this->searchcontrol();
    }

    public function obteUrl(){
        $this->url=Storage::url('public/'.$this->actual->ruta);
       // dd($this->url);
    }

    public function searchcontrol(){
        $this->control=Control::where('status', true)
                                ->where('estudiante_id', $this->actual->alumno_id)
                                ->select('id')
                                ->get();
    }

    public function recibo(){
        $this->is_recibo=!$this->is_recibo;
    }

    public function inventar(){

        if($this->opcion==="1"){
            $this->observa=now()." ".Auth::user()->name." APROBO LA TRANSACCIÓN. ----- ";
            $this->status=3;
            $this->status_inventario=true;

        }else if($this->opcion==="2"){
            $this->observa=now()." ".Auth::user()->name." DESAPROBO LA TRANSACCIÓN. ".$this->observaciones." ----- ";
            $this->status=4;
            $this->status_inventario=$this->actual->status_inventario;
        }

        //Actualiza la transacción
        $this->actual->update([
            'observaciones'=>$this->observa.$this->actual->observaciones,
            'status'=>$this->status,
            'status_inventario'=>$this->status_inventario
        ]);

        //Actualiza la gestión del estudiante
        foreach ($this->control as $value) {
            $opc=Control::find($value->id);
            $opc->update([
                'observaciones'=>$this->observa.$opc->observaciones,
            ]);
        }


    }

    public function render()
    {
        return view('livewire.financiera.transaccion.transaccion-editar');
    }
}
