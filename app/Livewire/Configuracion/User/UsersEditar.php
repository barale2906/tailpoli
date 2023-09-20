<?php

namespace App\Livewire\Configuracion\User;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class UsersEditar extends Component
{
    public $name = '';
    public $email = '';
    public $documento = '';
    public $password = '';
    public $rol = '';
    public $id = '';
    public $actual;
    public $elegido;

    public $is_sector = true;

    /**
     * Reglas de validación
     */
    protected $rules = [
        'name' => 'required|max:100',
        'email'=>'required|email',
        'documento'=>'required',
        'rol'=>'required',
        'id'    => 'required'
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset('name', 'email', 'documento', 'password','rol', 'id');
    }

    public function mount($elegido = null)
    {
        $this->name=$elegido['name'];
        $this->id=$elegido['id'];
        $this->email=$elegido['email'];
        //$this->rol=$elegido['rol'];
        $this->documento=$elegido['documento'];
        $this->rolasig();
    }

    public function rolasig(){
        $this->actual=User::whereId($this->id)->first();

        if($this->actual->roles->count()){
            $this->rol=$this->actual->roles[0]['name'];
        }
    }

    //Actualizar
    public function edit()
    {
        // validate
        $this->validate();

        //Actualizar registros
        User::whereId($this->id)->update([
            'name'=>strtolower($this->name),
            'email'=>strtolower($this->email),
            'documento'=>strtolower($this->documento),
        ]);

        //Actualizar Rol
        $this->actual->syncRoles($this->rol);


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
