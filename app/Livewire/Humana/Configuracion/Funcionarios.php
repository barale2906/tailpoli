<?php

namespace App\Livewire\Humana\Configuracion;

use App\Traits\FuncionariosTrait;
use Livewire\Component;

class Funcionarios extends Component
{
    use FuncionariosTrait;

    public function render()
    {
        return view('livewire.humana.configuracion.funcionarios',[
            'funcionarios'  => $this->funcionarios(),
        ]);
    }
}
