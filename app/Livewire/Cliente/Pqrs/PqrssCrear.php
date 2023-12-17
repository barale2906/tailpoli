<?php

namespace App\Livewire\Cliente\Pqrs;

use App\Models\Clientes\Pqrs;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PqrssCrear extends Component
{
    public $estudiante_id;
    public $gestion_id;
    public $tipo;
    public $introtipo;
    public $observaciones;
    public $archivo;
    public $origen=false; //Define si lo crea el usuario o desde la gestión
    public $editar=false;
    public $ruta=null;

    public function mount($origen=null,$editar=null){
        $this->gestion_id=Auth::user()->id;
        if($origen){
            $this->origen=true;
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
        'observaciones'=>'required',
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

        Pqrs::create([
            'estudiante_id'=>$this->estudiante_id,
            'gestion_id'=>$this->gestion_id,
            'fecha'=>now(),
            'tipo'=>$this->tipo,
            'observaciones'=>Auth::user()->name." ".$this->introtipo.$this->observaciones,
            'ruta'=>$this->ruta
        ]);

        // Notificación
        $this->dispatch('alerta', name:'Se ha creado correctamente la PQRS: ');
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');
    }

    private function estudiantes(){
        return User::where('status', true)
                    ->orderBy('name', 'ASC')
                    ->with('roles')->get()->filter(
                        fn ($user) => $user->roles->where('name', 'Estudiante')->toArray()
                    );
    }

    private function noestudiantes(){
        return User::where('status', true)
                        ->orderBy('name')
                        ->with('roles')->get()->filter(
                            fn ($user) => $user->roles->where('name', '!=', 'Estudiante')->toArray()
                        );
    }

    public function render()
    {
        return view('livewire.cliente.pqrs.pqrss-crear',[
            'estudiantes'=>$this->estudiantes(),
            'noestudiantes'=>$this->noestudiantes()
        ]);
    }
}
