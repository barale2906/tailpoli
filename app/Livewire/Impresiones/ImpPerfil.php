<?php

namespace App\Livewire\Impresiones;

use App\Models\User;
use Livewire\Attributes\Url;
use Livewire\Component;

class ImpPerfil extends Component
{
    #[Url(as: 'u')]
    public $id='';
    public $user;

    public function mount(){
        $this->user=User::find($this->id);
    }

    public function render()
    {
        return view('livewire.impresiones.imp-perfil');
    }
}
