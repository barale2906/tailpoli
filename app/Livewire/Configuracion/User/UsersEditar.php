<?php

namespace App\Livewire\Configuracion\User;

use App\Models\Configuracion\Perfil;
use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class UsersEditar extends Component
{
    public $name = '';
    public $lastname = '';
    public $email = '';
    public $documento = '';
    public $tipo_documento = '';
    public $password = '';
    public $rol = '';
    public $id = '';
    public $actual;
    public $elegido;
    public $clase;

    public $is_sector = true;

    /**
     * Reglas de validación
     */
    protected $rules = [
        'name' => 'required|max:100',
        'lastname' => 'required|max:100',
        'email'=>'required|email',
        'documento'=>'required',
        'tipo_documento'=>'required',
        'rol'=>'required',
        'id'    => 'required'
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset('name', 'lastname', 'email', 'documento', 'tipo_documento', 'password','rol', 'id');
    }

    public function mount($elegido = null,$clase)
    {
        $this->id=$elegido['id'];
        $this->clase=$clase;
        $this->rolasig();
    }

    public function rolasig(){
        $this->actual=User::whereId($this->id)->first();

        if($this->actual->roles->count()){
            $this->rol=$this->actual->roles[0]['name'];
        }

        $this->valores();
    }

    public function valores(){
        $this->name=$this->actual->perfil->name;
        $this->lastname=$this->actual->perfil->lastname;
        $this->documento=$this->actual->documento;
        $this->tipo_documento=$this->actual->perfil->tipo_documento;
        $this->email=$this->actual->email;
    }

    //Actualizar
    public function edit()
    {
        // validate
        $this->validate();

        //Actualizar registros
        $completo=$this->name." ".$this->lastname;
        User::whereId($this->id)->update([
            'name'=>strtolower($completo),
            'email'=>strtolower($this->email),
            'documento'=>strtolower($this->documento),
        ]);

        //Actualizar Rol
        $this->actual->syncRoles($this->rol);

        Perfil::where('user_id',$this->id)
                ->update([
                    'tipo_documento'=>$this->tipo_documento,
                    'documento'=>$this->documento,
                    'name'=>strtolower($this->name),
                    'lastname'=>strtolower($this->lastname)
                ]);


        $this->dispatch('alerta', name:'Se ha modificado correctamente el Usuario: '.$this->name);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('Editando');
    }

    private function roles(){
        return Role::where('status', true)
                    ->orderBy('name')
                    ->get();
    }

    public function render()
    {
        return view('livewire.configuracion.user.users-editar', [
            'roles'=>$this->roles(),
        ]);
    }
}
