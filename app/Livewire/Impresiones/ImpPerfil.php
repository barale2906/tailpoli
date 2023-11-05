<?php

namespace App\Livewire\Impresiones;

use App\Models\User;
use Livewire\Attributes\Url;
use Livewire\Component;

class ImpPerfil extends Component
{
    #[Url(as: 'u')]
    public $id='';

    #[Url(as: 'o')]
    public $ori='';

    public $ruta;



    public $user;

    public function mount(){
        $this->user=User::find($this->id);

        $this->urlruta();
    }

    public function urlruta(){

        if ($this->ori===1) {
            $this->ruta="/configuracion/users";
        } else if($this->ori===0){
            $this->ruta="/academico/estudiantes";
        }

    }

    public function render()
    {
        return view('livewire.impresiones.imp-perfil');
    }
}
