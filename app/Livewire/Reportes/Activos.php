<?php

namespace App\Livewire\Reportes;

use App\Models\Academico\Control;
use App\Models\Configuracion\Estado;
use App\Traits\FiltroTrait;
use Livewire\Component;
use Livewire\WithPagination;

class Activos extends Component
{
    use WithPagination;

    public $ordena='estado_cartera';
    public $ordenado='DESC';
    public $pages = 15;

    public $estado=1;
    public $buscamin;
    public $buscar='';

    public $filtroSede;

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

    private function controles(){
        return Control::estado($this->estado)
                        ->buscar($this->buscamin)
                        ->sede($this->filtroSede)
                        ->orderBy($this->ordena, $this->ordenado)
                        ->paginate($this->pages);
    }

    private function sedes(){
        return Control::select('sede_id')
                        ->groupBy('sede_id')
                        ->get();
    }

    private function estados(){
        return Estado::where('status', true)
                        ->orderBy('name', 'ASC')
                        ->get();
    }

    public function render()
    {
        return view('livewire.reportes.activos',[
            'estados'=>$this->estados(),
            'controles'=>$this->controles(),
            'sedes'=>$this->sedes(),
        ]);
    }
}
