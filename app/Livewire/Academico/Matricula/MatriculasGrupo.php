<?php

namespace App\Livewire\Academico\Matricula;

use App\Models\Academico\Grupo;
use App\Models\Academico\Horario;
use App\Models\Academico\Modulo;
use App\Models\Configuracion\Sede;
use Livewire\Component;

class MatriculasGrupo extends Component
{
    public $grupo;
    public $ciudad;
    public $modulo;
    public $horarios;
    public $sede_id;

    public function mount($elegido = null, $estudiante_id=null)
    {
        $this->grupo=Grupo::find($elegido);

        $this->sede_id=$this->grupo->sede_id;

        $this->ciudad=Sede::find($this->sede_id);
        $this->modulo=Modulo::find($this->grupo->modulo_id);

        $this->cargaHorarios();
    }

    public function cargaHorarios(){
        $this->horarios=Horario::where('sede_id', $this->sede_id)
                                ->where('grupo_id', $this->grupo->id)
                                ->orderBy('hora', 'ASC')
                                ->get();
    }

    public function render()
    {
        return view('livewire.academico.matricula.matriculas-grupo');
    }
}
