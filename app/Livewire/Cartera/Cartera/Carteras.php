<?php

namespace App\Livewire\Cartera\Cartera;

use App\Exports\CarCarteraExport;
use App\Models\Financiera\Cartera;
use App\Models\Financiera\EstadoCartera;
use App\Traits\FiltroTrait;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Carteras extends Component
{
    use WithPagination;
    use FiltroTrait;

    public $ordena='responsable_id';
    public $ordenado='DESC';
    public $pages = 3;

    public $alumno;

    public $is_modify = true;
    public $is_creating = false;
    public $is_cartera=false;

    public $buscar='';
    public $buscamin='';

    public $filtroVendes;
    public $filtroVenhas;
    public $filtroven=[];
    public $filtroCiudad;
    public $filtroSede;
    public $filtrostatusest=[];
    public $estado_estudiante=[];
    public $estado_cartera=[];

    protected $listeners = ['refresh' => '$refresh'];

    public function mount(){
        $this->claseFiltro(9);
        $this->filtrostatusest=[1,7,8];
        $this->estado_estudiante=[1,7,8];
        $this->estado_cartera=[1,2,3,4,6];
        $this->elegidos();
    }

    public function updatedFiltroVenhas(){
        if($this->filtroVendes<=$this->filtroVenhas){
            $crea=array();
            array_push($crea, $this->filtroVendes);
            array_push($crea, $this->filtroVenhas);
            $this->filtroven=$crea;
        }else{
            $this->dispatch('alerta', name:'Fecha de inicio debe ser menor a fecha fin');
        }
    }

    public function updatedEstadoEstudiante(){
        $this->carteras();
        $this->total();
        $this->elegidos();
    }

    public function updatedEstadoCartera(){
        $this->carteras();
        $this->total();
        $this->elegidos();
    }

    //Cargar variable
    public function buscaText(){
        $this->resetPage();
        $this->reset(
                'filtroven',
                'filtroCiudad',
                'filtroSede',
                'estado_estudiante',
                //'estado_cartera',
        );
        $this->buscamin=strtolower($this->buscar);
    }

    //Limpiar variables
    public function limpiar(){
        $this->reset('buscamin', 'buscar');
        $this->resetPage();
    }

    //Activar evento
    #[On('cancelando')]
    //Mostrar formulario de creación
    public function cancela(){

        $this->reset(
                        'is_modify',
                        'is_creating',
                        'is_cartera',
                        'alumno'
                    );
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

    public function exportar(){
        return new CarCarteraExport(
                        $this->buscamin,
                        $this->filtroven,
                        $this->filtroCiudad,
                        $this->filtroSede,
                        $this->estado_estudiante,
                        $this->estado_cartera
                    );
    }

    public function show($alumno,$est){
        $this->alumno=$alumno; //Se cambio el id del alumno por el Id de matricula
        $this->is_modify=!$this->is_modify;
        switch ($est) {
            case 0:
                $this->is_cartera=!$this->is_cartera;
                break;

            case 1:
                $this->is_creating = !$this->is_creating;
                break;
        }

    }

    private function elegidos(){
        return DB::table('estados')
                    ->whereIn('id',$this->estado_estudiante)
                    ->orderBy('name')
                    ->get();
    }

    private function carteras(){

        //DB::enableQueryLog();

        $consulta= Cartera::with(['responsable','estadoCartera','concepto_pago'])
                        ->buscar($this->buscamin)
                        ->vencido($this->filtroven)
                        ->sede($this->filtroSede)
                        ->ciudad($this->filtroCiudad)
                        ->status($this->estado_estudiante)
                        ->statcar($this->estado_cartera)
                        ->selectRaw('sum(saldo) as saldo, matricula_id, responsable_id')
                        //->selectRaw('SUM(CASE WHEN estado_cartera_id < 5 THEN valor WHEN estado_cartera_id = 6 THEN valor ELSE 0 END) as original')
                        ->selectRaw('sum(valor) as original')
                        ->groupBy('matricula_id','responsable_id')
                        ->orderBy($this->ordena, $this->ordenado)
                        ->Paginate($this->pages);

        //dd(DB::getQueryLog());

        return $consulta;
    }

    private function total(){

        return Cartera::with(['responsable','estadoCartera','concepto_pago'])
                        ->buscar($this->buscamin)
                        ->vencido($this->filtroven)
                        ->sede($this->filtroSede)
                        ->ciudad($this->filtroCiudad)
                        ->status($this->estado_estudiante)
                        ->statcar($this->estado_cartera)
                        ->sum('saldo');
    }

    private function sedes(){
        return Cartera::where('estado_cartera_id', '<',5)
                        ->select('sede_id')
                        ->groupBy('sede_id')
                        ->get();
    }

    private function ciudades(){
        return Cartera::where('estado_cartera_id', '<',5)
                        ->select('sector_id')
                        ->groupBy('sector_id')
                        ->get();
    }

    private function status_estu(){
        return DB::table('estados')
                    ->orderBy('name')
                    ->get();
    }

    private function estadoscartera(){
        return EstadoCartera::where('status',true)
                                ->orderBy('id','ASC')
                                ->get();
    }

    public function render()
    {
        return view('livewire.cartera.cartera.carteras', [
            'carteras'  =>$this->carteras(),
            'total'     =>$this->total(),
            'sedes'     =>$this->sedes(),
            'ciudades'  =>$this->ciudades(),
            'status_estu'=>$this->status_estu(),
            'elegidos'  =>$this->elegidos(),
            'estacartera'=>$this->estadoscartera()
        ]);
    }
}
