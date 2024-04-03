<?php

namespace App\Livewire\Admin\Ayuda;

use Livewire\Component;

class Ayudas extends Component
{
    public $crt;
    public $is_video=false;

    public function buscar($item){
        $this->crt=$item;
        $this->is_video=true;
    }

    public function render()
    {
        return view('livewire.admin.ayuda.ayudas');
    }
}
