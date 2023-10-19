<?php

namespace App\Livewire\Configuracion\User;

use App\Models\User;
use Livewire\Component;

class Contrasena extends Component
{
    public $id;
    public $elegido;
    public $actual;
    public $existente;
    public $nuevo;
    public $valida;

    public function mount($elegido = null)
    {
        $this->id=$elegido;
        $this->actual=User::find($elegido);
    }

    /**
     * Reglas de validación
     */
    protected $rules = [
        'existente' => 'required|min:8',
        'nuevo' => 'required|min:8',
        'valida'=>'required|min:8',
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset('existente', 'nuevo', 'valida');
    }

    public function editCont(){

         // validate
        $this->validate();

        $encriptado=bcrypt($this->existente);
        $encripnue=bcrypt($this->nuevo);
        $encripvali=bcrypt($this->valida);

        $password=$this->actual->password;

        if($encriptado===$password){

            if($encripnue===$encripvali){

                User::whereId($this->id)->update([
                    'password'=>$encripnue,
                ]);

                $this->dispatch('alerta', name:'Ha modificado correctamente la contraseña');
                $this->resetFields();

            }else{
                $this->dispatch('alerta', name:'Debe ser igual la nueva contraseña con su validación');
            }

        }else{
            $this->dispatch('alerta', name:'Debe digitar correctamente la contraseña actual');
        }

    }

    public function render()
    {
        return view('livewire.configuracion.user.contrasena');
    }
}
