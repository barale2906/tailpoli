<?php

namespace App\Livewire\Configuracion\Importaciones;

use App\Models\Academico\Grupo;
use App\Models\Academico\Nota;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;

class Impornotas extends Component
{
    use WithFileUploads;

    public $grupos;
    public $profesor_id;
    public $grupo_id;
    public $calificaciones;
    public $notas;
    public $esquemas;

    public function updatedProfesorId(){

        $this->grupos=Grupo::where('profesor_id', $this->profesor_id)
                            ->where('status', true)
                            ->orderBy('name', 'ASC')
                            ->get();
    }

    public function updatedGrupoId(){
        $this->esquemas=Nota::where('grupo_id', $this->grupo_id)
                                ->where('profesor_id', $this->profesor_id)
                                ->get();
    }

    /**
     * Reglas de validación
     */
    protected $rules = [
        'encabezado'    => 'required|mimes:xls,xlsx',
        'profesor_id'   => 'required|integer',
        'grupo_id'      => 'required|integer',
        'registros'     => 'required|integer',
    ];

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
