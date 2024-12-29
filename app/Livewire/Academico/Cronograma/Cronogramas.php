<?php

namespace App\Livewire\Academico\Cronograma;

use App\Traits\CronogramaTrait;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Cronogramas extends Component
{
    use CronogramaTrait;

    public function mount(){
        $this->claseFiltro(19);
        if(Auth::user()->rol_id===5){
            $this->filtro_profesor=Auth::user()->id;
        }
    }

    public function render()
    {
        return view('livewire.academico.cronograma.cronogramas',[
            'cronogramas'   =>$this->cronogramas(),
        ]);
    }
}
