<?php

namespace App\Livewire\Impresiones;

use App\Traits\RenderDocTrait;
use Livewire\Attributes\Url;
use Livewire\Component;

class ImpFormularioPractica extends Component
{
    use RenderDocTrait;

    #[Url(as: 'fp')]
    public $id='';

    #[Url(as: 'o')]
    public $ori;


    public function mount(){

        $this->docubase($this->id, 'formuPractica', $this->ori);

    }

    public function render()
    {
        return view('livewire.impresiones.imp-formulario-practica');
    }
}
