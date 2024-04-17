<?php

namespace App\Livewire\Admin\Ayuda;

use Livewire\Attributes\On;
use Livewire\Component;

class Ayudas extends Component
{
    public $crt;
    public $is_detalle=false;

    #[On('cancelando')]
    public function cancelar(){
        $this->reset(
            'crt',
            'is_detalle'
        );
    }

    public function buscar($item){
        $this->cancelar();
        $this->activar($item);
    }

    public function activar($reg){
        $this->crt=$reg;
        $this->is_detalle=true;
    }

    public function render()
    {
        return view('livewire.admin.ayuda.ayudas');
    }
}
