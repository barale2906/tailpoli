<?php

namespace App\Livewire\Academico\Gestion;

use App\Models\Academico\Control;
use App\Models\Academico\Grupo;
use App\Models\Academico\Nota;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Gestiones extends Component
{

    use WithPagination;

    public $ordena='inicia';
    public $ordenado='ASC';
    public $pages = 3;

    public $is_modify = true;
    public $is_creating = false;
    public $is_editing = false;
    public $is_deleting = false;
    public $is_grupos=false;
    public $is_change=false;
    public $is_inventario=false;
    public $is_observaciones=false;
    public $is_asistencias=false;
    public $is_notas=false;

    public $estudiante_id;

    public $ruta=2;

    public $elegido;

    public $buscar='';
    public $buscamin='';

    protected $listeners = ['refresh' => '$refresh'];

    //Cargar variable
    public function buscaText(){
        $this->resetPage();
        $this->buscamin=strtolower($this->buscar);
    }

    //Limpiar variables
    public function limpiar(){
        $this->reset('buscamin', 'buscar');
        $this->resetPage();
    }

    // Ordenar Registros
    public function organizar($campo)
    {
        if($this->ordenado === 'ASC')
        {
            $this->ordenado = 'DESC';
        }else{
            $this->ordenado = 'ASC';
        }
        return $this->ordena = $campo;
    }

    //Numero de registros
    public function paginas($valor)
    {
        $this->resetPage();
        $this->pages=$valor;
    }

    //Activar evento
    #[On('cancelando')]
    //Mostrar formulario de creación
    public function cancela()
    {
        $this->reset(
                        'is_modify',
                        'is_creating',
                        'is_editing',
                        'is_deleting',
                        'is_change',
                        'is_grupos',
                        'is_inventario',
                        'is_observaciones',
                        'is_asistencias',
                        'is_notas'
                    );
    }

    //Activar evento
    #[On('created')]
    //Mostrar formulario de creación
    public function updatedIsCreating()
    {
        $this->is_modify = !$this->is_modify;
        $this->is_creating = !$this->is_creating;
    }

    //Activar evento
    #[On('inventario')]
    //Mostrar formulario de creación
    public function updatedIsInventario()
    {
        $this->is_modify = !$this->is_modify;
        $this->is_inventario = !$this->is_inventario;
    }

    //Activar evento
    #[On('Editando')]
    //Mostrar formulario de creación
    public function updatedIsEditing()
    {
        $this->is_modify = !$this->is_modify;
        $this->is_editing = !$this->is_editing;
    }

    // Mostrar
    public function show($esta, $act, $est=null){

        $this->elegido=$esta;
        $this->is_modify = !$this->is_modify;
        $this->estudiante_id=$est;

        switch ($act) {
            case 0:
                $this->is_observaciones=!$this->is_observaciones;
                break;

            case 1:
                $this->is_asistencias=!$this->is_asistencias;
                break;

            case 2:
                $this->is_notas=!$this->is_notas;
                break;
        }
    }

    //Activar evento
    #[On('Inactivando')]
    //Mostrar formulario de inactivación
    public function updatedIsDeleting()
    {
        $this->is_modify = !$this->is_modify;
        $this->is_deleting = !$this->is_deleting;
    }

    //Activar evento
    #[On('grupos')]
    //Mostrar formulario de inactivación
    public function updatedIsGrupos()
    {
        $this->is_modify = !$this->is_modify;
        $this->is_grupos = !$this->is_grupos;
    }

    //Activar evento
    #[On('estudiantes')]
    //Mostrar formulario de inactivación
    public function updatedIsChange()
    {
        $this->is_modify = !$this->is_modify;
        $this->is_change = !$this->is_change;
    }

    public function notas($item){

        $notas=Nota::where('grupo_id', $item)->first();

        $this->show($notas, 2);
    }

    public function asistencia($item){

        $notas=Nota::where('grupo_id', $item)->first();

        $this->show($notas, 1);
    }

    public function exportar(){
        //return new AcaMatriculaExport($this->buscamin);
    }

    private function controles()
    {
        return Control::query()
                        ->with(['ciclo', 'estudiante'])
                        ->when($this->buscamin, function($query){
                            return $query->where('status', true)
                                    ->where('observaciones', 'like', "%".$this->buscamin."%")
                                    ->orWhereHas('estudiante', function($q){
                                        $q->where('name', 'like', "%".$this->buscamin."%")
                                            ->orWhere('documento', 'like', "%".$this->buscamin."%");
                                    })
                                    ->orWhereHas('ciclo', function($qu){
                                        $qu->where('name', 'like', "%".$this->buscamin."%");
                                    });
                        })
                        ->orderBy($this->ordena, $this->ordenado)
                        ->paginate($this->pages);
    }

    public function render()
    {
        return view('livewire.academico.gestion.gestiones',[
            'controles' =>$this->controles(),
        ]);
    }
}
