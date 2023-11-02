<?php

namespace App\Livewire\Academico\Grupo;

use App\Models\Academico\Grupo;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class GruposCambiar extends Component
{
    public $alumno;
    public $matricula_id;
    public $curso_id;
    public $grupo_actual=0;
    public $actual;
    public $grupos;
    public $grupo_nuevo=0;
    public $nuevo;

    public function mount($elegido=null){
        $this->alumno=User::whereId($elegido['alumno_id'])->first();
        $this->curso_id=$elegido['curso_id'];
        $this->matricula_id=$elegido['id'];
    }

    public function updatedGrupoActual(){
        $this->actual=Grupo::whereId($this->grupo_actual)->first();

        $this->grupos=Grupo::where('modulo_id', $this->actual->modulo_id)
                            ->where('status', true)
                            ->orderBy('sede_id')
                            ->orderBy('name')
                            ->get();
    }

    public function updatedGrupoNuevo(){
        $this->nuevo=Grupo::whereId($this->grupo_nuevo)->first();
    }

    public function cambiar(){

        //Eliminar grupo actual
        DB::table('grupo_user')
            ->where('grupo_id', $this->grupo_actual)
            ->where('user_id', $this->alumno->id)
            ->delete();

        DB::table('grupo_matricula')
            ->where('grupo_id', $this->grupo_actual)
            ->where('matricula_id', $this->matricula_id)
            ->delete();

        DB::table('notas_detalle')
            ->where('grupo_id', $this->grupo_actual)
            ->where('alumno_id', $this->alumno->id)
            ->update([
                'status'=>false
            ]);

        $inscritos=$this->actual->inscritos-1;
        Grupo::whereId($this->grupo_actual)
                ->update([
                    'inscritos' =>$inscritos
                ]);

        // Agregar nuevo Grupo
        DB::table('grupo_user')
            ->insert([
                'grupo_id'  =>$this->grupo_nuevo,
                'user_id'   =>$this->alumno->id
            ]);

        DB::table('grupo_matricula')
            ->insert([
                'grupo_id'      =>$this->grupo_nuevo,
                'matricula_id'  =>$this->matricula_id
            ]);

        $inscri=$this->nuevo->inscritos+1;
        Grupo::whereId($this->grupo_nuevo)
                ->update([
                    'inscritos' =>$inscri
                ]);

        $this->dispatch('alerta', name:'Se ha cambiado el grupo correctamente. Las notas y Asistencias NO SE MODIFICAN NI ACTUALIZAN');

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cambiagrupo');
    }



    public function render()
    {
        return view('livewire.academico.grupo.grupos-cambiar');
    }
}
