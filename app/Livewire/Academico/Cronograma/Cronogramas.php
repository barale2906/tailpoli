<?php

namespace App\Livewire\Academico\Cronograma;

use App\Models\Academico\Ciclogrupo;
use App\Traits\CronogramaTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Cronogramas extends Component
{
    use CronogramaTrait;

    public function mount(){
        $this->claseFiltro(19);
        if(Auth::user()->rol_id===5){
            $this->filtro_profesor=Auth::user()->id;
        }

        //$this->prt();
    }

    public function prt(){
        $ciclos=Ciclogrupo::where('ciclo_id', 6141)
                            ->get();

        foreach ($ciclos as $value) {
            $this->cronocrea(6141,$value->fecha_inicio,$value->fecha_fin,$value->grupo_id);
        }
    }

    public function render()
    {
        return view('livewire.academico.cronograma.cronogramas',[
            'cronogramas'   =>$this->cronogramas(),
        ]);
    }
}
