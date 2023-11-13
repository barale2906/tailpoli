<?php

namespace App\Livewire\Impresiones;

use App\Traits\RenderDocTrait;
use Carbon\Carbon;
use Livewire\Attributes\Url;
use Livewire\Component;

class ImpCartaCobro extends Component
{
    use RenderDocTrait;

    #[Url(as: 'cco')]
    public $id='';

    #[Url(as: 'o')]
    public $ori;

    public $fechaMes;
    public $fecha;


    public function mount(){

        $this->fechaMes=Carbon::now()->locale('es')->isoFormat('dddd D \d\e MMMM \d\e\l Y');
        $this->fecha=Carbon::now();

        $this->docubase($this->id, 'cartaCobro', $this->ori);

    }

    public function render()
    {
        return view('livewire.impresiones.imp-carta-cobro');
    }
}
