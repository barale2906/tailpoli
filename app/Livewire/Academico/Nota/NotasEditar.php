<?php

namespace App\Livewire\Academico\Nota;

use App\Models\Academico\Nota;
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
    public $cargar_estudiante=false;
    public $cargar_nota=false;
    public $modificar=false;
    public $listado=true;

    protected $listeners = ['refresh' => '$refresh'];

    //Activar evento
    #[On('Estudiante')]
    //Mostrar formulario de creación de estudiante
    public function updatedCargarEstudiante()
    {
        $this->cargar_estudiante = !$this->cargar_estudiante;
        $this->listado = !$this->listado;
    }

    //Activar evento
    #[On('Modif')]
    //Mostrar formulario de modificación
    public function updatedModificar()
    {
        $this->modificar = !$this->modificar;
        $this->listado = !$this->listado;
    }

    public function estudiante(){
        $this->cargar_estudiante = !$this->cargar_estudiante;
        $this->listado = !$this->listado;
    }

    public function abremodificar(){
        $this->modificar = !$this->modificar;
        $this->listado = !$this->listado;
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
        }
    }

    public function render()
    {
        return view('livewire.academico.nota.notas-editar');
    }
}
