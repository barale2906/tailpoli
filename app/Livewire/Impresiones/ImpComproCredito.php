<?php

namespace App\Livewire\Impresiones;

use App\Traits\RenderDocTrait;
use Livewire\Attributes\Url;
use Livewire\Component;

class ImpComproCredito extends Component
{
    use RenderDocTrait;

    #[Url(as: 'cc')]
    public $id='';

    #[Url(as: 'o')]
    public $ori;


    public function mount(){

        $this->docubase($this->id, 'comproCredito', $this->ori);

    }

    public function render()
    {
        return view('livewire.impresiones.imp-compro-credito');
    }
}
