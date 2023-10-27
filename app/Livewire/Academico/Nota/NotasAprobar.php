<?php

namespace App\Livewire\Academico\Nota;

use App\Models\Academico\Grupo;
use App\Models\Academico\Matricula;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class NotasAprobar extends Component
{
    public $actual;
    public $aprueba=0;
    public $idcierra;
    public $encabezado=[];
    public $datoEstudiante;
    public $grupo;

    public function mount($actual = null, $idcierra=null){
        $this->actual=$actual;
        $this->idcierra=$idcierra;
        $this->grupo=Grupo::whereId($this->actual->grupo_id)
                            ->select('modulo_id')
                            ->first();

        $this->notaestu();
    }

    public function notaestu(){
        $this->datoEstudiante=DB::table('notas_detalle')
                                ->where('id', $this->idcierra)
                                ->first();

        $this->calculaencabezado();
    }

    public function calculaencabezado(){
        for ($i=1; $i <= $this->actual->registros; $i++) {
            $nota="nota".$i;
            $pocen="porcen".$i;

            $nuevo=[
                'id'            =>$i,
                'califica'      =>$this->actual->$nota,
                'porcentaje'    =>$this->actual->$pocen,
                'obtenidoNota'  =>$this->datoEstudiante->$nota,
                'acumnota'      =>$this->datoEstudiante->$pocen
            ];

            array_push($this->encabezado, $nuevo);
        }
    }

    public function salida($id){

        if($id===1){
            $observa=now()." --- ¡APRUEBA! --- ".Auth::user()->name." --- ".$this->datoEstudiante->observaciones;

            DB::table('matricula_modulos_aprobacion')
                    ->where('alumno_id', $this->datoEstudiante->alumno_id)
                    ->where('modulo_id', $this->grupo->modulo_id)
                    ->update([
                        'aprobo'        =>true,
                        'updated_at'    =>now(),
                    ]);

            DB::table('notas_detalle')
                    ->where('id', $this->idcierra)
                    ->update([
                        'aprobo'        =>$this->aprueba,
                        'observaciones' =>$observa,
                        'updated_at'    =>now(),
                    ]);
        }

        if($id===2){

            $observa=now()." --- ¡APRUEBA! --- ".Auth::user()->name." --- ".$this->datoEstudiante->observaciones;
            DB::table('notas_detalle')
                    ->where('id', $this->idcierra)
                    ->update([
                        'aprobo'        =>$this->aprueba,
                        'observaciones' =>$observa,
                        'updated_at'    =>now(),
                    ]);

        }

        /* if($this->aprueba==="1"){

            $this->aprueba=1;

            DB::table('matricula_modulos_aprobacion')
                    ->where('alumno_id', $this->datoEstudiante->alumno_id)
                    ->where('modulo_id', $this->grupo->modulo_id)
                    ->update([
                        'aprobo'        =>true,
                        'updated_at'    =>now(),
                    ]);

        }else{
            $this->aprueba=2;
            $this->califica="¡REPRUEBA!";
        }

        $observa=now()." --- ".$this->califica." --- ".Auth::user()->name." --- ".$this->datoEstudiante->observaciones;

        DB::table('notas_detalle')
                    ->where('id', $this->idcierra)
                    ->update([
                        'aprobo'        =>$this->aprueba,
                        'observaciones' =>$observa,
                        'updated_at'    =>now(),
                    ]); */

    }



    public function render()
    {
        return view('livewire.academico.nota.notas-aprobar');
    }
}
