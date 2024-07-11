<?php

namespace App\Livewire\Financiera\CierreCaja;

use App\Exports\FinCierreCajaExport;
use App\Exports\FinInfContabExport;
use App\Models\Financiera\CierreCaja;
use App\Traits\FiltroTrait;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class CierreCajas extends Component
{
    use WithPagination;
    use FiltroTrait;

    public $ordena='id';
    public $ordenado='DESC';
    public $pages = 15;

    public $is_modify = true;
    public $is_creating = false;
    public $is_deleting = false;
    public $is_watching = false;
    public $is_desbloqueo=false;

    public $elegido;
    public $accion;

    public $buscar='';
    public $buscamin='';
    public $filtroCreades;
    public $filtroCreahas;
    public $filtrocrea=[];
    public $filtroSede;
    public $is_reporte=true;
    public $is_poliandino=true;
    public $is_logo='img/logo.jpeg';




    protected $listeners = ['refresh' => '$refresh'];

    public function mount($reporte=null){
        $this->claseFiltro(4);
        if($reporte){
            $this->is_reporte=false;
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

    //Activar evento
    #[On('cancelando')]
    //Mostrar formulario de creación
    public function cancela()
    {
        $this->reset(
                        'is_modify',
                        'is_creating',
                        //'is_editing',
                        'is_deleting',
                        'is_watching',
                        'is_desbloqueo'
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

    public function updatedFiltroCreahas(){
        if($this->filtroCreades<=$this->filtroCreahas){
            $crea=array();
            array_push($crea, $this->filtroCreades);
            array_push($crea, $this->filtroCreahas);
            $this->filtrocrea=$crea;
        }else{
            $this->reset('filtroCreades','filtroCreahas');
        }
    }

    //Activar evento
    #[On('created')]
    //Mostrar formulario de creación
    public function updatedIsCreating()
    {
        $this->is_modify = !$this->is_modify;
        $this->is_creating = !$this->is_creating;
    }

    // Mostrar Regimen de Salud
    public function show($esta, $act){

        $this->elegido=$esta;
        $this->is_modify = !$this->is_modify;
        $this->accion=$act;

        switch ($act){
            case 0:
                $this->is_deleting=!$this->is_deleting;
                break;

            case 1:
                $this->is_watching=!$this->is_watching;
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
    #[On('watched')]
    //Mostrar pantalla de impresión
    public function updatedIsWatching()
    {
        $this->is_modify = !$this->is_modify;
        $this->is_watching = !$this->is_watching;
    }

    //Activar evento
    #[On('desbloqueando')]
    //Mostrar pantalla de impresión
    public function updatedIsDesbloquear()
    {
        $this->is_modify = !$this->is_modify;
        $this->is_desbloqueo = !$this->is_desbloqueo;
    }

    public function exportar(){
        return new FinCierreCajaExport($this->buscamin,$this->filtroSede,$this->filtrocrea,$this->is_poliandino,$this->is_logo);
    }

    public function empresa(){
        $this->is_poliandino=!$this->is_poliandino;
        $this->logos();
    }

    public function logos(){
        if($this->is_poliandino){
            $this->is_logo='img/logo.jpeg';
        }else{
            $this->is_logo='img/logopol.jpg';
        }
    }

    public function exportRecibos(){
        $this->exportar();
        $this->exportcontab();
    }

    public function exportcontab(){
        return new FinInfContabExport($this->buscamin,$this->filtroSede,$this->filtrocrea,$this->is_poliandino,$this->is_logo);
    }



    private function cierres()
    {
        return CierreCaja::buscar($this->buscamin)
                            ->sede($this->filtroSede)
                            ->crea($this->filtrocrea)
                            ->orderBy($this->ordena, $this->ordenado)
                            ->paginate($this->pages);
    }

    private function sedes(){
        return CierreCaja::select('sede_id')
                            ->groupBy('sede_id')
                            ->get();
    }

    public function render()
    {
        return view('livewire.financiera.cierre-caja.cierre-cajas', [
            'cierres'=>$this->cierres(),
            'sedes'=>$this->sedes(),
        ]);
    }
}
