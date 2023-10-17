<?php

namespace App\Livewire\Configuracion\User;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class UsersCreate extends Component
{
    public $name = '';
    public $email = '';
    public $documento = '';
    public $password = '';
    public $rol = '';
    public $clase;

    public function mount($clase){
        $this->clase=$clase;

        $this->tipo();

    }

    public function tipo(){
        if($this->clase===1){
            $this->rol="Estudiante";
        }
        if($this->clase===2){
            $this->rol="Profesor";
        }
    }

    /**
     * Reglas de validación
     */
    protected $rules = [
        'name' => 'required|max:100',
        'email'=>'required|email',
        'documento'=>'required',
        'password'=>'required|min:8',
        'rol'=>'required'
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset('name', 'email', 'documento', 'password','rol');
    }

    // Crear Regimen de Salud
    public function new(){
        // validate
        $this->validate();

        //Verificar que no exista el registro en la base de datos
        $existe=User::Where('name', '=',strtolower($this->name))
                    ->orWhere('email','=',strtolower($this->email))
                    ->orWhere('documento','=',strtolower($this->documento))
                    ->count();

        if($existe>0){
            $this->dispatch('alerta', name:'Ya existe este Usuario: '.$this->name);
        } else {

            //Crear registro
            $nuevoUs=User::create([
                'name'=>strtolower($this->name),
                'email'=>strtolower($this->email),
                'documento'=>strtolower($this->documento),
                'password'=>bcrypt($this->password)
            ]);

            $nuevoUs->assignRole($this->rol);

            // Notificación
            $this->dispatch('alerta', name:'Se ha creado correctamente el Usuario: '.$this->name);
            $this->resetFields();

            //refresh
            $this->dispatch('refresh');
            $this->dispatch('created');
        }
    }

    private function roles(){
        return Role::where('status', true)
                    ->orderBy('name')
                    ->get();
    }

    public function render()
    {
        return view('livewire.configuracion.user.users-create', [
            'roles'=>$this->roles(),
        ]);
    }
}
