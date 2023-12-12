<?php

namespace App\Livewire\Configuracion\Importaciones;

use App\Models\Academico\Grupo;
use App\Models\User;
use Livewire\Component;

class Impornotas extends Component
{
    public $grupos;
    public $profesor_id;
    public $detalle=false;

    public function updatedProfesorId(){

        $this->grupos=Grupo::where('profesor_id', $this->profesor_id)
                            ->where('status', true)
                            ->orderBy('name', 'ASC')
                            ->get();
    }



    private function profesores()
    {
        return User::where('status', true)
                        ->orderBy('name', 'ASC')
                        ->with('roles')->get()->filter(
                            fn ($user) => $user->roles->where('name', 'Profesor')->toArray()
                        );
    }
    public function render()
    {
        return view('livewire.configuracion.importaciones.impornotas',[
            'profesores'=>$this->profesores()
        ]);
    }
}
