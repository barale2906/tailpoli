<?php

namespace App\Livewire\Financiera\Transaccion;

use App\Models\Academico\Control;
use App\Models\Configuracion\Sede;
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
        $this->reset('is_academico', 'is_inventario');

        switch ($opc) {
            case 1:
                $this->is_academico=!$this->is_academico;
                break;

            case 2:
                $this->is_inventario=!$this->is_inventario;
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
        'soporte'       => 'required|image',
        'observaciones' => 'required',
        'sede_id'       => 'required|integer'
    ];

    private function sedes(){
        return Sede::where('status', true)
                    ->orderBy('name')
                    ->get();
    }



    public function render()
    {
        return view('livewire.financiera.transaccion.transaccion-crear',[
            'sedes'=>$this->sedes(),
        ]);
    }
}
