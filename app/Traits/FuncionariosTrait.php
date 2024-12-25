<?php

namespace App\Traits;

use App\Models\Humana\Funcionario;
use Livewire\WithPagination;
use App\Traits\FiltroTrait;
use Livewire\Attributes\On;

trait FuncionariosTrait
{
    use WithPagination;
    use FiltroTrait;

    public $ordena='id';
    public $ordenado='DESC';
    public $pages = 3;

    public $is_modify = true;
    public $is_editing= false;

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

    public function show($id){
        $this->elegido=$id;
        $this->is_modify=false;
        $this->is_editing=true;
    }

    //Activar evento
    #[On('cancelando')]
    //Mostrar formulario de creación
    public function cancela()
    {
        $this->reset(
                        'is_modify',
                        'is_editing',
                        'elegido'
                    );
    }

    public function detalle($id){
        $this->funcionario=Funcionario::where('user_id', $id)
                                        ->first();
    }

    private function funcionarios(){
        return Funcionario::buscar($this->buscamin)
                            ->orderBy($this->ordena, $this->ordenado)
                            ->paginate($this->pages);
    }
}
