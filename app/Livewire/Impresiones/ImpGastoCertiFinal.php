<?php

namespace App\Livewire\Impresiones;

use App\Traits\RenderDocTrait;
use Livewire\Attributes\Url;
use Livewire\Component;

class ImpGastoCertiFinal extends Component
{
    use RenderDocTrait;

    #[Url(as: 'gcf')]
    public $id='';

    #[Url(as: 'o')]
    public $ori;


    public function mount(){

        $this->docubase($this->id, 'gastocertifinal', $this->ori);

    }

    public function render()
    {
        return view('livewire.impresiones.imp-gasto-certi-final');
    }
}
