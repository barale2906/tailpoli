<?php

namespace App\Livewire\Financiera\Cuenta;

use App\Models\Configuracion\Sede;
use App\Models\Financiera\Cuenta;
use Livewire\Component;

class CuentaEditar extends Component
{
    public $is_crear=false;
    public $is_inactivar=false;
    public $actual;
    public $funcion;
    public $boton;

    public $name;
    public $sede_id;
    public $numero_cuenta;
    public $tipo;
    public $banco;


    public function mount($accion, $elegido=null){

        switch ($accion) {
            case 1:
                $this->funcion="new";
                $this->boton="Crea cuenta";
                $this->is_crear=true;
                break;

            case 2:
                $this->funcion="editar";
                $this->boton="Edita cuenta";
                $this->is_crear=true;
                $this->actual=Cuenta::find($elegido);
                $this->cargadatos();
                break;

            case 3:
                $this->is_inactivar=true;
                $this->actual=Cuenta::find($elegido);
                break;

        }
    }

    public function cargadatos(){
        $this->sede_id=$this->actual->sede_id;
        $this->name=$this->actual->name;
        $this->numero_cuenta=$this->actual->numero_cuenta;
        $this->tipo=$this->actual->tipo;
        $this->banco=$this->actual->banco;
    }

    /**
     * Reglas de validación
     */
    protected $rules = [
        'name'  => 'required|max:100',
        'sede_id' => 'required|integer',
        'numero_cuenta'=> 'required',
        'tipo'=> 'required',
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
                    'is_crear',
                    'is_inactivar',
                    'actual',
                    'name',
                    'sede_id',
                    'numero_cuenta',
                    'tipo',
                    'banco',
                );
    }


    public function new(){

        Cuenta::create([
                'name'=>strtolower($this->name),
                'sede_id'=>$this->sede_id,
                'numero_cuenta'=>$this->numero_cuenta,
                'tipo'=>$this->tipo,
                'banco'=>strtolower($this->banco),
            ]);

        $this->dispatch('alerta', name:'Se creo la cuenta: '.$this->name);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');
    }

    public function editar(){

        $this->actual->update([
            'name'=>strtolower($this->name),
            'sede_id'=>$this->sede_id,
            'numero_cuenta'=>$this->numero_cuenta,
            'tipo'=>$this->tipo,
            'banco'=>strtolower($this->banco),
        ]);

        $this->dispatch('alerta', name:'Se cambio el estado de: '.$this->actual->name);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');
    }

    public function inactivar(){

        $this->actual->update([
            'status'    => !$this->actual->status
        ]);

        $this->dispatch('alerta', name:'Se cambio el estado de: '.$this->actual->name);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');
    }

    private function sedes(){
        return Sede::where('status', true)
                    ->orderBy('name','asc')
                    ->get();
    }

    public function render()
    {
        return view('livewire.financiera.cuenta.cuenta-editar',[
            'sedes'=>$this->sedes()
        ]);
    }
}
