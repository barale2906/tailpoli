<?php

namespace App\Livewire\Impresiones;

use Livewire\Attributes\Url;
use Livewire\Component;

class ImpTraslado extends Component
{
    #[Url(as: 'tras')]
    public $traslado='';

    #[Url(as: 'rut')]
    public $ruta='';

    public function mount(){

    }

    public function render()
    {
        return view('livewire.impresiones.imp-traslado');
    }
}
