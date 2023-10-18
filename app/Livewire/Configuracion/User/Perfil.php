<?php

namespace App\Livewire\Configuracion\User;

use App\Models\User;
use Livewire\Component;

class Perfil extends Component
{
    public $id;
    public $elegido;
    public $perf;
    public $actual;

    public function mount($elegido = null,$perf)
    {
        $this->id=$elegido;
        $this->actual=User::find($elegido);
        $this->perf=$perf;
    }

    public function render()
    {
        return view('livewire.configuracion.user.perfil');
    }
}
