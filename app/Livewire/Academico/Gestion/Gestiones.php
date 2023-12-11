<?php

namespace App\Livewire\Academico\Gestion;

use App\Models\Academico\Control;
use App\Models\Academico\Grupo;
use App\Models\Academico\Nota;
use App\Models\Configuracion\Estado;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Gestiones extends Component
{

    use WithPagination;

    public $ordena='estado_cartera';
    public $ordenado='DESC';
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
    public $is_transacciones=false;
    public $is_gestransaccion=false;
    public $is_document=false;

    public $sedes=[];

    public $estudiante_id;

    public $ruta=2;

    public $elegido;

    public $buscar='';
    public $buscamin='';

    protected $listeners = ['refresh' => '$refresh'];

    public function mount(){

        foreach (Auth::user()->sedes as $value) {
            if(in_array($value->id, $this->sedes )){

            }else{
                array_push($this->sedes, $value->id);
            }
        }
    }

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
                        'is_notas',
                        'is_transacciones',
                        'is_gestransaccion',
                        'is_document'
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

            case 3:
                $this->is_transacciones=!$this->is_transacciones;
                break;

            case 4:
                $this->is_gestransaccion=!$this->is_gestransaccion;
                break;

            case 5:
                $this->is_document=!$this->is_document;
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

    public function notas($item, $id){

        $notas=Nota::where('grupo_id', $item)->first();

        if($notas){
            $this->show($notas->id,2);

        }else{
            $this->dispatch('alerta', name:'No se han sacado notas para este grupo');
        }
    }

    public function asistencia($item, $id){

        $this->show($item, 1, $id); //envío id del grupo
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
                                    ->whereIn('sede_id', $this->sedes)
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

    private function estados(){
        return Estado::where('status', true)
                        ->orderBy('name', 'ASC')
                        ->get();

    }

    public function render()
    {
        return view('livewire.academico.gestion.gestiones',[
            'controles' =>$this->controles(),
            'estados'    =>$this->estados()
        ]);
    }
}
