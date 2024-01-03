<?php

namespace App\Livewire\Academico\Nota;

use App\Exports\AcaNotaExport;
use App\Exports\AcaNotaPlantExport;
use App\Models\Academico\Nota;
use App\Models\Clientes\Pqrs;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class NotasEditar extends Component
{
    public $id;
    public $actual;
    public $notas;
    public $contador;
    public $encabezado=[];
    public $encabezadoxls=[];
    public $mapaencabe=[];
    public $cargar_nota=false;
    public $aprueba=false;
    public $idcierra;
    public $listado=true;
    public $estudiante;
    public $cargar=false;

    public $grupo;

    public $notaenv;
    public $porcenv;

    protected $listeners = ['refresh' => '$refresh'];

    public function abrenotas(){
        $this->cargar_nota = !$this->cargar_nota;
        $this->listado = !$this->listado;
        $this->registroNotas();
    }

    public function finaprueba($id){
        $this->idcierra=$id;
        $this->estudiante=DB::table('notas_detalle')
                            ->where('id', $id)
                            ->first();
        $this->abrenaprueba();
    }

    public function abrenaprueba(){
        $this->aprueba = !$this->aprueba;
        $this->listado = !$this->listado;
        $this->registroNotas();
    }

    public function reprobo(){
        $observa=now()." --- ¡REPROBO! --- ".Auth::user()->name." --- ".$this->estudiante->observaciones;
            DB::table('notas_detalle')
                    ->where('id', $this->idcierra)
                    ->update([
                        'aprobo'        =>2,
                        'observaciones' =>$observa,
                        'updated_at'    =>now(),
                    ]);

            DB::table('matricula_modulos_aprobacion')
                    ->where('alumno_id', $this->estudiante->alumno_id)
                    ->where('modulo_id', $this->actual->grupo->modulo_id)
                    ->update([
                        'updated_at'    =>now(),
                        'observaciones' =>now()." --- ¡REPROBO! ".Auth::user()->name." --- ",
                    ]);



            $estudent=User::find($this->estudiante->alumno_id);
            $estudent->update([
                'caso_especial'=>1
            ]);

            Pqrs::create([
                'estudiante_id' =>$this->estudiante->alumno_id,
                'gestion_id'    =>Auth::user()->id,
                'fecha'         =>now(),
                'tipo'          =>4,
                'observaciones' =>'ACÁDEMICO: '." --- ¡REPROBO! --- ".$this->estudiante->grupo." --- ".Auth::user()->name." ----- ",
                'status'        =>4
            ]);

        $this->dispatch('alerta', name:'El(la) estudiante: '.$this->estudiante->alumno." ¡REPROBO!");
        $this->reset('idcierra');
        $this->abrenaprueba();
    }


    public function aprobo(){

        $moduloAp=DB::table('matricula_modulos_aprobacion')
                    ->where('alumno_id', $this->estudiante->alumno_id)
                    ->where('modulo_id', $this->actual->grupo->modulo_id)
                    ->select('observaciones')
                    ->first();

        $observac=now()." --- ¡APROBO! --- ".Auth::user()->name." --- ".$moduloAp->observaciones;

        DB::table('matricula_modulos_aprobacion')
                        ->where('alumno_id', $this->estudiante->alumno_id)
                        ->where('modulo_id', $this->actual->grupo->modulo_id)
                        ->update([
                            'aprobo'        =>true,
                            'updated_at'    =>now(),
                            'observaciones' =>$observac,
                        ]);

        $observa=now()." --- ¡APROBO! --- ".Auth::user()->name." --- ".$this->estudiante->observaciones;
                DB::table('notas_detalle')
                        ->where('id', $this->idcierra)
                        ->update([
                            'aprobo'        =>1,
                            'observaciones' =>$observa,
                            'updated_at'    =>now(),
                        ]);

        Pqrs::create([
            'estudiante_id' =>$this->estudiante->alumno_id,
            'gestion_id'    =>Auth::user()->id,
            'fecha'         =>now(),
            'tipo'          =>4,
            'observaciones' =>'ACÁDEMICO: '." --- ¡APROBO! ".$this->estudiante->grupo." --- ".Auth::user()->name." ----- ",
            'status'        =>4
        ]);

            $this->dispatch('alerta', name:'El(la) estudiante: '.$this->estudiante->alumno." ¡APROBO!");
            $this->reset('idcierra');
            $this->abrenaprueba();
    }

    public function calificacion($id){
        foreach($this->mapaencabe as $value){
            if($value['id']===$id){
                $this->notaenv=$value['nota'];
                $this->porcenv=$value['porcen'];
            }
        }

        $this->abrenotas();
    }


    public function mount($elegido = null, $cargar=null){
        $this->id=$elegido;
        $this->actual=Nota::whereId($elegido)->first();
        $this->grupo=$this->actual->grupo_id;
        $this->registroNotas();
        $this->formaencabezado();
        if($cargar){
            $this->cargar=true;
        }
    }

    public function registroNotas(){

        $this->contador=$this->actual->registros;

        $this->notas=DB::table('notas_detalle')
                        ->where('status', true)
                        ->where('nota_id', $this->id)
                        ->orderBy('alumno')
                        ->get();

        $this->encabezadoExcel();


    }

    public function formaencabezado(){
        for ($i=1; $i <= $this->contador; $i++) {

            $nota="nota".$i;
            $porce="porcen".$i;

            array_push($this->encabezado, $nota);
            array_push($this->encabezado, $porce);

            $nuevo=[
                'id'    =>$i,
                'nota'  =>$nota,
                'porcen'=>$porce
            ];

            array_push($this->mapaencabe, $nuevo);
        }

        $this->cargarEstudiantes();
    }

    public function encabezadoExcel(){
        if(!$this->cargar){
            $this->reset('encabezadoxls');
            array_push($this->encabezadoxls, "grupo");
            array_push($this->encabezadoxls, "profesor");
            array_push($this->encabezadoxls, "alumno");
            array_push($this->encabezadoxls, "acumulado");
            array_push($this->encabezadoxls, "observaciones");

            foreach ($this->encabezado as $value) {
                $item = $this->actual->$value;
                array_push($this->encabezadoxls, $item);
            }
        }else{
            $this->reset('encabezadoxls');
            array_push($this->encabezadoxls, "nota_id");
            array_push($this->encabezadoxls, "alumno_id");
            array_push($this->encabezadoxls, "alumno");
            array_push($this->encabezadoxls, "profesor_id");
            array_push($this->encabezadoxls, "profesor");
            array_push($this->encabezadoxls, "grupo_id");
            array_push($this->encabezadoxls, "grupo");
            array_push($this->encabezadoxls, "observaciones");
            array_push($this->encabezadoxls, "acumulado");

            foreach ($this->encabezado as $value) {
                $item = $this->actual->$value;
                array_push($this->encabezadoxls, $item);
            }
        }

    }

    public function cargarEstudiantes(){
        if($this->actual->grupo->inscritos!==$this->notas->count()){
            $alumnos=User::query()
                            ->with(['alumnosGrupo'])
                            ->when($this->actual->grupo_id, function($qu){
                                return $qu->where('status', true)
                                        ->whereHas('alumnosGrupo', function($q){
                                            $q->where('grupo_id', $this->actual->grupo_id);
                                        });
                            })
                            ->select('id', 'name')
                            ->orderBy('name')
                            ->get();

            foreach ($alumnos as $value) {
                $esta=DB::table('notas_detalle')
                            ->where('nota_id', $this->id)
                            ->where('alumno_id', $value->id)
                            ->count();

                if($esta===0){
                    $this->cargaEstudiante($value);
                }
            }
        }

        $this->registroNotas();
    }

    public function cargaEstudiante($estu){
        DB::table('notas_detalle')
            ->insert([
                'nota_id'       =>$this->actual->id,
                'alumno_id'     =>$estu->id,
                'alumno'        =>$estu->name,
                'profesor_id'   =>$this->actual->profesor_id,
                'profesor'      =>$this->actual->profesor->name,
                'grupo_id'      =>$this->actual->grupo_id,
                'grupo'         =>$this->actual->grupo->name,
                'observaciones' =>"--",
                'created_at'    =>now(),
                'updated_at'    =>now()
            ]);
    }

    public function exportar(){
        return new AcaNotaExport($this->id, $this->encabezadoxls);
    }

    public function exportarPlantilla(){
        return new AcaNotaPlantExport($this->id, $this->encabezadoxls);
    }

    public function render()
    {
        return view('livewire.academico.nota.notas-editar');
    }
}
