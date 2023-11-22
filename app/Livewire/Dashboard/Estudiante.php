<?php

namespace App\Livewire\Dashboard;

use App\Models\Academico\Control;
use App\Models\Financiera\Cartera;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Estudiante extends Component
{
    public $is_notas=false;
    public $is_modify=true;
    public $grupo;
    public $fecha;

    public function mount(){
        $this->fecha=now();
    }

    //Activar evento
    #[On('cancelando')]
    //Mostrar formulario de creación
    public function updatedIsCreating()
    {
        $this->reset('is_notas', 'is_modify');
    }

    public function show($esta, $act){

        $this->grupo=$esta;
        $this->is_modify = !$this->is_modify;


        switch ($act) {
            case 0:
                $this->is_notas=!$this->is_notas;
                break;
        }
    }

    private function control(){
        return Control::where('estudiante_id', Auth::user()->id)
                        ->where('status', true)
                        ->get();
    }

    private function cartera(){
        return Cartera::where('responsable_id', Auth::user()->id)
                        ->where('status', true)
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
