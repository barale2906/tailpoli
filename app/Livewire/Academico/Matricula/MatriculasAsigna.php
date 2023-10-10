<?php

namespace App\Livewire\Academico\Matricula;

use App\Models\Academico\Curso;
use App\Models\Academico\Matricula;
use App\Models\Financiera\ConfiguracionPago;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class MatriculasAsigna extends Component
{
    public $matricula;
    public $config;
    public $curso;
    public $disponibles=[];
    public $modulos=[];
    public $id;

    public function mount($elegido = null)
    {
        $this->id=$elegido['id'];
        $this->matricula=Matricula::find($elegido['id']);
        $this->config=ConfiguracionPago::find($elegido['configpago']);
        $this->curso=Curso::find($elegido['curso_id']);

        $this->buscaModulos();
    }

    // Buscar modulos asignados según configuración de pago.
    public function buscaModulos(){  //incluye todos los modulos
        if($this->config->incluye){
            $this->modulos=$this->curso->modulos;
            $this->dependencias();
        }else{ // no los incluye todos
            foreach ($this->curso->modulos as $value) {
                $esta=DB::table('configpago_modulo')
                        ->where('config_id', $this->config->id)
                        ->where('modulo_id', $value->id)
                        ->count();
                if($esta>0){
                    $nuevo=[
                        'id'            =>$value->id,
                        'name'          =>$value->name,
                        'dependencia'   =>$value->dependencia
                    ];
                    array_push($this->modulos, $nuevo);
                }
            }

            $this->dependencias();
        }
    }

    // Definir restricciones de dependencia
    public function dependencias(){

    }

    // Buscar grupos por cada modulo según dependencia

    public function render()
    {
        return view('livewire.academico.matricula.matriculas-asigna');
    }
}
