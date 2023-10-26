<?php

namespace App\Livewire\Academico\Nota;

use App\Models\Academico\Nota;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class NotasEditar extends Component
{
    public $id;
    public $actual;
    public $notas;
    public $contador;
    public $encabezado=[];
    public $mapaencabe=[];
    public $cargar_nota=false;
    public $listado=true;

    public $notaenv;
    public $porcenv;

    protected $listeners = ['refresh' => '$refresh'];

    public function abrenotas(){
        $this->cargar_nota = !$this->cargar_nota;
        $this->listado = !$this->listado;
        $this->registroNotas();
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


    public function mount($elegido = null){
        $this->id=$elegido['id'];
        $this->actual=Nota::whereId($elegido['id'])->first();
        $this->registroNotas();
        $this->formaencabezado();
    }

    public function registroNotas(){

        $this->contador=$this->actual->registros;

        $this->notas=DB::table('notas_detalle')
                        ->where('nota_id', $this->id)
                        ->orderBy('alumno')
                        ->get();
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

    public function render()
    {
        return view('livewire.academico.nota.notas-editar');
    }
}
