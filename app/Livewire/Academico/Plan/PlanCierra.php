<?php

namespace App\Livewire\Academico\Plan;

use App\Models\Academico\Acaplandeta;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Models\Academico\Cronodeta;
use Illuminate\Support\Facades\Auth;

class PlanCierra extends Component
{

    public $plan;
    public $crono;
    public $actividades;
    public $evidencias;
    public $resultados;

    public function mount($plan,$crono){
        $esta=DB::table('crono_plan_cierre')
                    ->where('crono_id',$crono)
                    ->where('plan_id',$plan)
                    ->first();

        if($esta && $esta->nombre){
            // Notificación
            $this->dispatch('alerta', name:$esta->nombre.': Cerro esta fecha el día: '.$esta->fecha_cierre);
            $this->dispatch('cerrando');
        }else{
            $this->plan=Acaplandeta::find($plan);
            $this->crono=Cronodeta::find($crono);
        }
    }

    /**
     * Reglas de validación
     */
    protected $rules = [
        'actividades'       => 'required',
        'evidencias'       => 'required',
        'resultados'   => 'required'
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
            'actividades',
            'evidencias',
            'resultados',
        );
    }

    public function new(){
        // validate
        $this->validate();
        $prefijo=now().", Fecha Clase: ".$this->crono->fecha_programada." - ";

        //Actualizar registro
        $this->plan->update([
            'actividades'=>$prefijo.$this->actividades." ----- ".$this->plan->actividades,
            'evidencias'=>$prefijo.$this->evidencias." ----- ".$this->plan->evidencias,
            'resultados'=>$prefijo.$this->resultados." ----- ".$this->plan->resultados,
        ]);

        //Insertar control
        DB::table('crono_plan_cierre')
            ->insert([
                        'crono_id'=>$this->crono->id,
                        'plan_id'=>$this->plan->id,
                        'fecha_cierre'=>now(),
                        'fecha_crono'=>$this->crono->fecha_programada,
                        'usuario'=>Auth::user()->id,
                        'nombre'=>Auth::user()->name,
            ]);

        // Notificación
        $this->dispatch('alerta', name:'Se cerro la actividad con fecha: '.$this->crono->fecha_programada);
        $this->dispatch('cerrando');
        $this->resetFields();
    }

    public function render()
    {
        return view('livewire.academico.plan.plan-cierra');
    }
}
