<?php

namespace App\Livewire\Impresiones;

use App\Traits\RenderDocTrait;
use Carbon\Carbon;
use Livewire\Attributes\Url;
use Livewire\Component;

class ImpPagare extends Component
{
    use RenderDocTrait;

    #[Url(as: 'p')]
    public $id='';

    #[Url(as: 'o')]
    public $ori;

    public $fecha;


    public function mount(){

        $this->fecha=Carbon::now();

        $this->docubase($this->id, ['pagare'], $this->ori);

    }

    public function render()
    {
        return view('livewire.impresiones.imp-pagare');
    }
}
