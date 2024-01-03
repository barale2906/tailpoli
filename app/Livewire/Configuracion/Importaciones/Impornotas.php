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
    public $mascinco=0;
    public $negativo=0;

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
            ->where('nota_id', $this->notas)
            ->where('grupo_id', $this->grupo_id)
            ->where('profesor_id', $this->profesor_id)
            ->where('status', true)
            ->where('aprobo', 0)
            ->delete();

        Excel::import(new NotasImport, $this->calificaciones);

        $this->corrigeNotas();
    }

    public function corrigeNotas(){

        DB::table('notas_detalle')
                ->where('nota_id', $this->notas)
                ->where('grupo_id', $this->grupo_id)
                ->where('profesor_id', $this->profesor_id)
                ->where('status', true)
                ->where('aprobo', 0)
                ->orderBy('id', 'ASC')
                ->each(function($ins){
                    for ($i=1; $i <= 10; $i++) {
                        $nota="nota".$i;
                        if($ins->$nota<0){
                            $this->negativo=$this->negativo+1;
                        }

                        if($ins->$nota>5){
                            $this->mascinco=$this->mascinco+1;
                        }
                    }
                });


                if($this->negativo===0 && $this->mascinco===0){

                    $this->dispatch('alerta', name:'Se importo correctamente el archivo, por favor valide la información.');

                    $ruta='/academico/notas';

                    $this->redirect($ruta);

                }else if($this->negativo>0 || $this->mascinco>0){
                    $this->dispatch('alerta', name:'DEBE VOLVER A CARGAR, notas mayores a 5 o menores a 0 no se permiten.');
                    DB::table('notas_detalle')
                        ->where('nota_id', $this->notas)
                        ->where('grupo_id', $this->grupo_id)
                        ->where('profesor_id', $this->profesor_id)
                        ->where('status', true)
                        ->where('aprobo', 0)
                        ->delete();

                }

        $this->reset('grupo_id', 'profesor_id', 'notas', 'calificaciones', 'alerta', 'negativo', 'mascinco');
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
