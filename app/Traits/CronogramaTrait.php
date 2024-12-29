<?php

namespace App\Traits;

use App\Models\Academico\Cronograma;
use Livewire\Attributes\On;
use Livewire\WithPagination;

trait CronogramaTrait
{
    use WithPagination;
    use FiltroTrait;

    public $ordena='id';
    public $ordenado='DESC';
    public $pages = 3;

    public $buscar='';
    public $buscamin='';

    public $is_modify = true;

    public $filtro_profesor;

    //Cargar variable
    public function buscaText(){
        $this->resetPage();
        $this->buscamin=strtolower($this->buscar);
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
                    );
    }

    private function cronogramas(){
        return Cronograma::buscar($this->buscamin)
                            ->profesor($this->filtro_profesor)
                            ->orderBy($this->ordena, $this->ordenado)
                            ->paginate($this->pages);
    }

}
