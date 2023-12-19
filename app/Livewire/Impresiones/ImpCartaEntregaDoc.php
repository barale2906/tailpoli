<?php

namespace App\Livewire\Impresiones;

use App\Traits\RenderDocTrait;
use Carbon\Carbon;
use Livewire\Attributes\Url;
use Livewire\Component;

class ImpCartaEntregaDoc extends Component
{
    use RenderDocTrait;

    #[Url(as: 'ced')]
    public $id='';

    #[Url(as: 'o')]
    public $ori;

    public $fechaMes;


    public function mount(){

        $this->fechaMes=Carbon::now()->locale('es')->isoFormat('dddd D \d\e MMMM \d\e\l Y');

        $this->docubase($this->id, ['comproEntrega'], $this->ori);

    }


    public function render()
    {
        return view('livewire.impresiones.imp-carta-entrega-doc');
    }
}
