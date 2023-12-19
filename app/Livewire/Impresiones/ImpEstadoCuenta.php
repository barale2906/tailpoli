<?php

namespace App\Livewire\Impresiones;

use App\Traits\RenderDocTrait;
use Carbon\Carbon;
use Livewire\Attributes\Url;
use Livewire\Component;

class ImpEstadoCuenta extends Component
{
    use RenderDocTrait;

    #[Url(as: 'ec')]
    public $id='';

    #[Url(as: 'o')]
    public $ori;

    public $fecha;


    public function mount(){

        $this->fecha=Carbon::now();

        $this->docubase($this->id, ['estadoCuenta'], $this->ori);

    }

    public function render()
    {
        return view('livewire.impresiones.imp-estado-cuenta');
    }
}
