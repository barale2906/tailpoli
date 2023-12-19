<?php

namespace App\Livewire\Impresiones;

use App\Traits\RenderDocTrait;
use Carbon\Carbon;
use Livewire\Attributes\Url;
use Livewire\Component;

class ImpCartaPagare extends Component
{
    use RenderDocTrait;

    #[Url(as: 'cp')]
    public $id='';

    #[Url(as: 'o')]
    public $ori;

    public $fecha;


    public function mount(){

        $this->fecha=Carbon::now();

        $this->docubase($this->id, ['cartaPagare'], $this->ori);

    }


    public function render()
    {
        return view('livewire.impresiones.imp-carta-pagare');
    }
}
