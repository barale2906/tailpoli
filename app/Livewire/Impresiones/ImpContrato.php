<?php

namespace App\Livewire\Impresiones;

use App\Models\Academico\Matricula;
use App\Models\Configuracion\Documento;
use App\Traits\RenderDocTrait;
use Livewire\Attributes\Url;
use Livewire\Component;

class ImpContrato extends Component
{
    use RenderDocTrait;

    #[Url(as: 'c')]
    public $id='';

    #[Url(as: 'o')]
    public $ori;


    public function mount(){

        $this->docubase($this->id, 'contrato', $this->ori);

    }


    public function render()
    {
        return view('livewire.impresiones.imp-contrato');
    }
}
