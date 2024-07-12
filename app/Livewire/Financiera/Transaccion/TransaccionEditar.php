<?php

namespace App\Livewire\Financiera\Transaccion;

use App\Models\Academico\Control;
use App\Models\Clientes\Pqrs;
use App\Models\Financiera\Transaccion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;

class TransaccionEditar extends Component
{
    public $actual;
    public $url;
    public $opcion;
    public $observaciones;
    public $observa;
    public $status;
    public $ruta=4;
    public $control;
    public $status_inventario;

    public $is_recibo=1;

    public function mount($elegido){
        $this->actual=Transaccion::find($elegido);
        $this->obteUrl();
        $this->searchcontrol();
    }

    public function resetFields(){
        $this->reset(
            'opcion',
            'observaciones',
            'observa',
            'status_inventario'
        );
    }

    public function obteUrl(){
        $this->url=Storage::url($this->actual->ruta);
    }

    public function searchcontrol(){
        /* $this->control=Control::where('status', true)
                                ->where('estudiante_id', $this->actual->alumno_id)
                                ->select('id')
                                ->get(); */
    }

    public function recibo($id){
        $this->is_recibo=$id;
    }

    public function inventar(){

        if($this->opcion==="1"){
            $this->observa=now()." ".Auth::user()->name." APROBO LA TRANSACCIÓN. ----- ";
            $this->status=2;
            $this->status_inventario=true;

            $this->dispatch('alerta', name:'APROBO LA TRANSACCIÓN ');

        }else if($this->opcion==="2"){
            $this->observa=now()." ".Auth::user()->name." DESAPROBO LA TRANSACCIÓN. ".$this->observaciones." ----- ";
            $this->status=3;
            $this->status_inventario=$this->actual->status_inventario;
            $this->dispatch('alerta', name:'DESAPROBO LA TRANSACCIÓN ');
        }

        //Actualiza la transacción
        $this->actual->update([
            'observaciones'=>$this->observa.$this->actual->observaciones,
            'gestionador_id'=>Auth::user()->id,
            'status'=>$this->status,
            'status_inventario'=>$this->status_inventario
        ]);

        //Actualiza la gestión del estudiante
        /*  foreach ($this->control as $value) {
            $opc=Control::find($value->id);
            $opc->update([
                'observaciones'=>$this->observa.$opc->observaciones,
            ]);
        } */

        Pqrs::create([
            'estudiante_id' =>$this->actual->user_id,
            'gestion_id'    =>Auth::user()->id,
            'fecha'         =>now(),
            'tipo'          =>2,
            'observaciones' =>'PAGO: '.$this->observa,
            'status'        =>4
        ]);

        // Notificación
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');


    }

    //Activar evento
    #[On('cambiando')]
    //Mostrar formulario de gestión
    public function cambia()
    {
        $this->is_recibo=1;
    }

    public function render()
    {
        return view('livewire.financiera.transaccion.transaccion-editar');
    }
}
