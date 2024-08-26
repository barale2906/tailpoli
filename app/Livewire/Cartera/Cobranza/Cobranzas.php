<?php

namespace App\Livewire\Cartera\Cobranza;

use App\Models\Academico\Curso;
use App\Models\Configuracion\Sede;
use App\Models\Financiera\Cobranza;
use App\Traits\FiltroTrait;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Cobranzas extends Component
{
    use WithPagination;
    use FiltroTrait;

    public $ordena='id';
    public $ordenado='DESC';
    public $pages = 15;
    public $elegido;

    public $is_modify = true;
    public $is_generar = false;
    public $is_observaciones=false;

    public $buscar='';
    public $buscamin='';
    public $filtroSede;
    public $filtrocurso;
    public $sedeids=[];
    public $curids=[];

    public $ruta=2;

    protected $listeners = ['refresh' => '$refresh'];

    public function mount(){

        $this->claseFiltro(11);
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
        $this->controles();
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
                        'is_generar',
                        'is_observaciones'
                    );
    }

    // Mostrar
    public function show($esta, $act){

        $this->elegido=$esta;
        $this->is_modify = !$this->is_modify;

        switch ($act) {
            case 0:
                $this->is_observaciones=!$this->is_observaciones;
                break;

            case 1:
                $this->is_generar=!$this->is_generar;
                break;

        }
    }

    private function cobranzas()
    {
        $cobrar=Cobranza::buscar($this->buscamin)
                        ->sede($this->filtroSede)
                        ->curso($this->filtrocurso)
                        ->orderBy($this->ordena, $this->ordenado)
                        ->paginate($this->pages);

        foreach ($cobrar as $value) {
            array_push($this->sedeids,$value->sede_id);
            array_push($this->curids,$value->curso_id);
        }

        return $cobrar;
    }

    private function sedes(){
        return Sede::whereIn('id',$this->sedeids)
                    ->orderBy('name','ASC')
                    ->get();
    }

    private function cursos(){
        return Curso::whereIn('id',$this->curids)
                    ->orderBy('name','ASC')
                    ->get();
    }

    public function render()
    {
        return view('livewire.cartera.cobranza.cobranzas',[
            'cobranzas' => $this->cobranzas(),
            'sedes'     => $this->sedes(),
            'cursos'    => $this->cursos(),
        ]);
    }
}
