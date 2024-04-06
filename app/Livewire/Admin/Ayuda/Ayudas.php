<?php

namespace App\Livewire\Admin\Ayuda;

use Livewire\Component;

class Ayudas extends Component
{
    public $crt;
    public $is_detalle=false;

    public function buscar($item){
        $this->crt=$item;
        $this->is_detalle=true;
    }

    public function render()
    {
        return view('livewire.admin.ayuda.ayudas');
    }
}
