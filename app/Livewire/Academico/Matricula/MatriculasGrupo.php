<?php

namespace App\Livewire\Academico\Matricula;

use App\Models\Academico\Grupo;
use App\Models\Academico\Modulo;
use App\Models\Configuracion\Sede;
use Livewire\Component;

class MatriculasGrupo extends Component
{
    public $grupo;
    public $ciudad;
    public $modulo;

    public function mount($elegido = null)
    {
        $this->grupo=Grupo::find($elegido['id']);
        $this->ciudad=Sede::find($elegido['sede_id']);
        $this->modulo=Modulo::find($elegido['modulo_id']);
    }

    public function render()
    {
        return view('livewire.academico.matricula.matriculas-grupo');
    }
}
