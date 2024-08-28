<?php

namespace App\Livewire\Dashboard;

use App\Models\Academico\Asistencia;
use App\Models\Academico\Control;
use App\Models\Academico\Nota;
use App\Models\Financiera\Cartera;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Estudiante extends Component
{
    public $is_notas=false;
    public $is_asistencia=false;
    public $is_modify=true;
    public $is_pqrs=false;
    public $nota;
    public $fecha;
    public $alumno_id;

    public function mount(){
        $this->fecha=now();
        $this->alumno_id=Auth::user()->id;
    }

    //Activar evento
    #[On('cancelando')]
    //Mostrar formulario de creación
    public function updatedIsCreating()
    {
        $this->reset('is_notas', 'is_modify', 'is_asistencia', 'is_pqrs');
    }

    public function show($esta, $act){

        $this->nota=$esta;
        $this->is_modify = !$this->is_modify;


        switch ($act) {
            case 0:
                $this->is_notas=!$this->is_notas;
                break;

            case 1:
                $this->is_asistencia=!$this->is_asistencia;
                break;

            case 2:
                $this->is_pqrs=!$this->is_pqrs;
                break;
        }
    }

    public function notas($id,$profesor){

        $notas=Nota::where('grupo_id', $id)
                    ->where('profesor_id', $profesor)
                    ->select('id')
                    ->first();

        if($notas){
            $this->show($notas->id,0);

        }else{
            $this->dispatch('alerta', name:'No se han sacado notas para este grupo');
        }
    }

    public function asistencia($id, $profesor){

        $asistencia=Asistencia::where('grupo_id', $id)
                                ->where('profesor_id', $profesor)
                                ->select('id')
                                ->first();

        if($asistencia){
            $this->show($asistencia->id, 1);
        } else {
            $this->dispatch('alerta', name:'No se ha registrado asistencia para este grupo');
        }
    }

    private function control(){
        return Control::where('estudiante_id', Auth::user()->id)
                        ->where('status', true)
                        ->get();
    }

    private function cartera(){
        return Cartera::where('responsable_id', Auth::user()->id)
                        ->where('estado_cartera_id', '<',5)
                        ->get();
    }

    public function render()
    {
        return view('livewire.dashboard.estudiante',[
            'control'=>$this->control(),
            'cartera'=>$this->cartera()
        ]);
    }
}
