<?php

namespace App\Livewire\Academico\Gestion;

use App\Models\Academico\Control;
use App\Models\Academico\Matricula;
use App\Models\Financiera\Cartera;
use App\Models\User;
use Livewire\Component;

class Activar extends Component
{
    public $estud;
    public $estudiante;

    public function mount($estud){
        $this->estud=$estud;
        $this->estudiante=User::find($estud);
    }

    public function activar(){
        $crt=Control::where('estudiante_id',$this->estud)->get();

        if($crt){
            foreach ($crt as $value) {
                Control::where('id',$value->id)->update([
                    'status_est'=>1
                ]);
            }
        }

        //Actualizar Matricula
        Matricula::where('alumno_id',$this->estud)
                ->update([
                    'status_est'=>1
                ]);

        //Actualizar Cartera
        Cartera::where('responsable_id', $this->estud)
                ->update([
                    'status_est'=>1
                ]);

        //refresh
        $this->dispatch('alerta', name:'Se activo correctamente el estudiante: '.strtoupper($this->estudiante->name));
        $this->dispatch('refresh');
        $this->dispatch('cancelando');
    }



    public function render()
    {
        return view('livewire.academico.gestion.activar');
    }
}
