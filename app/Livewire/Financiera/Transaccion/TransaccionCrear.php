<?php

namespace App\Livewire\Financiera\Transaccion;

use App\Models\Academico\Control;
use App\Models\Configuracion\Sede;
use App\Models\Financiera\Transaccion;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class TransaccionCrear extends Component
{
    use WithFileUploads;

    public $soporte;

    public $actual;
    public $observacion;
    public $observaciones;
    public $sede_id;
    public $opcion;
    public $url;

    public $inventario;
    public $academico;
    public $is_inventario=false;
    public $is_academico=false;


    public function mount($elegido){
        $this->actual=Control::find($elegido);
        $this->observacion=now()." ".Auth::user()->name." Cargo soporte de consignación. ----- ".$this->actual->observaciones;
    }

    public function updatedOpcion(){
        $opc=intval($this->opcion);
        $this->reset(
                        'is_academico',
                        'is_inventario',
                        'academico',
                        'inventario'
                    );

        switch ($opc) {
            case 1:
                $this->is_academico=!$this->is_academico;
                $this->inventario=0;
                break;

            case 2:
                $this->is_inventario=!$this->is_inventario;
                $this->academico=0;
                break;

            case 3:
                $this->is_academico=!$this->is_academico;
                $this->is_inventario=!$this->is_inventario;
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
        'inventario'    => 'required',
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
                        'inventario',
                    );
    }

    private function sedes(){
        return Sede::where('status', true)
                    ->orderBy('name')
                    ->get();
    }

    public function crear(){
        // validate
        $this->validate();

        $nombre=null;


        $nombre='public_soportes/'.$this->actual->estudiante_id."-".uniqid().".".$this->soporte->extension();
        $this->soporte->storeAs($nombre);

        Transaccion::create([
            'creador_id'=>Auth::user()->id,
            'gestionador_id'=>Auth::user()->id,
            'alumno_id'=>$this->actual->estudiante_id,
            'sede_id'=>$this->sede_id,
            'fecha'=>now(),
            'ruta'=>$nombre,
            'extension'=>$this->soporte->extension(),
            'inventario'=>$this->inventario,
            'academico'=>$this->academico,
            'observaciones'=>$this->observaciones
        ]);

        //Actualizar control
        $this->actual->update([
            'observaciones'=>$this->observacion,
        ]);

        $this->dispatch('alerta', name:'Se cargo soporte de pago para: '.$this->actual->estudiante->name);

        //refresh
        $this->resetFields();
        $this->dispatch('refresh');
        $this->dispatch('cancelando');

    }

    public function render()
    {
        return view('livewire.financiera.transaccion.transaccion-crear',[
            'sedes'=>$this->sedes(),
        ]);
    }
}
