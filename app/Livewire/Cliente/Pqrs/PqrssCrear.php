<?php

namespace App\Livewire\Cliente\Pqrs;

use App\Models\Clientes\Pqrs;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class PqrssCrear extends Component
{
    use WithFileUploads;

    public $estudiante_id;
    public $opcion;
    public $gestion_id;
    public $tipo;
    public $introtipo;
    public $observaciones;
    public $archivo;
    public $respuesta;
    public $origen=false; //Define si lo crea el usuario o desde la gestión
    public $editar=false;
    public $ruta=null;
    public $rutares=null;
    public $actual;
    public $status=2;
    public $ver=true;
    public $estudiantes;
    public $empleados;

    public function mount($origen=null,$elegido=null){
        $this->origen=$origen;
        switch ($origen) {
            case 1: //Crea PQRS desde la gestión
                $this->estud();
                $this->noestudiantes();
                break;

            case 2: // Edita PQRS
                $this->noestudiantes();
                break;

            case 3: // crea PQRS estudiante
                $this->origen=true;
                $this->estudiante_id=Auth::user()->id;
                $this->gestion_id=Auth::user()->id;
                $this->status=1;
                break;
        }

        if($elegido){
            $this->actual=Pqrs::find($elegido);
            $this->resp();
        }
    }

    public function resp(){
        $this->estudiante_id=$this->actual->estudiante_id;
        $this->gestion_id=$this->actual->gestion_id;
        $this->tipo=$this->actual->tipo;
        $this->opcion=$this->actual->opcion;
        $this->status=$this->actual->status;
        $this->editar=true;

        $this->estado();
    }

    public function estado(){

        if($this->actual->status===4){
            $this->ver=false;
        }
    }

    public function updatedTipo(){
        switch ($this->tipo) {
            case 2:
                $this->introtipo="PAGOS: ";
                break;

            case 3:
                $this->introtipo="NOTAS: ";
                break;

            case 4:
                $this->introtipo="ACÁDEMICO: ";
                break;

            case 5:
                $this->introtipo="PROFESOR: ";
                break;

            case 6:
                $this->introtipo="PLANTA: ";
                break;

            case 7:
                $this->introtipo="TALLERES: ";
                break;

            case 8:
                $this->introtipo="ADMINISTRACIÓN: ";
                break;

            case 9:
                $this->introtipo="OBSERVADOR: ";
                break;

        }
    }

    /**
     * Reglas de validación
     */
    protected $rules = [
        'estudiante_id'=>'required|integer',
        'tipo' => 'required',
        'opcion' => 'required',
        'observaciones'=>'required',
        'archivo'       => 'nullable|mimes:jpg,bmp,png,pdf,jpeg',
        'respuesta'       => 'nullable|mimes:jpg,bmp,png,pdf,jpeg',
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
            'estudiante_id',
            'tipo',
            'observaciones',
            'origen',
            'editar'
        );
    }

    public function new(){

        // validate
        $this->validate();

        if($this->archivo){

            $this->ruta='pqrs/'.$this->estudiante_id."-".uniqid().".".$this->archivo->extension();
            $this->archivo->storeAs($this->ruta);
        }

        //dd($this->estudiante_id, $this->gestion_id, $this->opcion, $this->tipo, $this->observaciones, $this->archivo, $this->ruta, $this->status);



        Pqrs::create([
            'estudiante_id'=>$this->estudiante_id,
            'gestion_id'=>$this->gestion_id,
            'fecha'=>now(),
            'opcion'=>$this->opcion,
            'tipo'=>$this->tipo,
            'observaciones'=>Auth::user()->name." ".$this->introtipo.$this->observaciones,
            'ruta_solicita'=>$this->ruta,
            'status'=>$this->status
        ]);

        // Notificación
        $this->dispatch('alerta', name:'Se ha creado correctamente la PQRS: ');
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');
    }

    public function edit(){

        // validate
        $this->validate();

        if($this->respuesta){

            $this->rutares='pqrs/'.$this->estudiante_id."-".uniqid().".".$this->respuesta->extension();
            $this->respuesta->storeAs($this->rutares);
        }

        $obs=now()." ".Auth::user()->name.$this->introtipo." ".$this->observaciones." ----- ".$this->actual->observaciones;

        $this->actual->update([
            'gestion_id'=>$this->gestion_id,
            'tipo'=>$this->tipo,
            'observaciones'=>$obs,
            'status'=>$this->status,
            'ruta_respuesta'=>$this->rutares
        ]);

        // Notificación
        $this->dispatch('alerta', name:'Se ha actualizado correctamente la PQRS: ');
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');
    }

    private function estud(){
        $this->estudiantes= User::where('status', true)
                                ->orderBy('name', 'ASC')
                                ->with('roles')->get()->filter(
                                    fn ($user) => $user->roles->where('name', 'Estudiante')->toArray()
                                );
    }

    private function noestudiantes(){
        $this->empleados=User::where('status', true)
                                ->orderBy('name')
                                ->with('roles')->get()->filter(
                                    fn ($user) => $user->roles->where('name', '!=', 'Estudiante')->toArray()
                                );
    }

    public function render()
    {
        return view('livewire.cliente.pqrs.pqrss-crear');
    }
}
