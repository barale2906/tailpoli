<?php

namespace App\Traits;

use App\Models\Humana\Funcionario;
use Livewire\WithPagination;
use App\Traits\FiltroTrait;

trait FuncionariosTrait
{
    use WithPagination;
    use FiltroTrait;

    public $ordena='id';
    public $ordenado='DESC';
    public $pages = 3;

    public $is_modify = true;

    public $elegido;

    public $buscar='';
    public $buscamin='';

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

    private function funcionarios(){
        return Funcionario::buscar($this->buscamin)
                            ->orderBy($this->ordena, $this->ordenado)
                            ->paginate($this->pages);
    }
}
