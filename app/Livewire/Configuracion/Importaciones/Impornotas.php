<?php

namespace App\Livewire\Configuracion\Importaciones;

use App\Imports\NotasImport;
use App\Models\Academico\Grupo;
use App\Models\Academico\Nota;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class Impornotas extends Component
{
    use WithFileUploads;

    public $grupos;
    public $profesor_id;
    public $grupo_id;
    public $calificaciones;
    public $notas;
    public $esquemas;
    public $alerta=false;

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
        'calificaciones'    => 'required|mimes:xls,xlsx',
        'profesor_id'       => 'required|integer',
        'grupo_id'          => 'required|integer',
    ];

    public function importar(){

        // validate
        $this->validate();

        //Elimnar registros anteriores
        DB::table('notas_detalle')
            ->where('grupo_id', $this->grupo_id)
            ->where('profesor_id', $this->profesor_id)
            ->delete();

        Excel::import(new NotasImport, $this->calificaciones);

        $this->reset('grupo_id', 'profesor_id', 'notas', 'calificaciones', 'alerta');

        $this->dispatch('alerta', name:'Se importo correctamente el archivo ');

        $ruta='/academico/notas';

        $this->redirect($ruta);
    }

    public function alarma(){
        $this->alerta=!$this->alerta;
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
