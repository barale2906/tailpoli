<?php

namespace App\Livewire\Academico\Especial;

use App\Models\User;
use App\Traits\FiltroTrait;
use Livewire\Component;
use Livewire\WithPagination;

class Especiales extends Component
{
    use WithPagination;
    use FiltroTrait;

    public $estudiante_id;
    public $ordena='name';
    public $ordenado='ASC';
    public $pages = 15;

    public $buscar='';
    public $buscamin='';

    public function mount(){
        $this->claseFiltro(8);
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

    public function elegir($id){

        $this->reset('buscar');
        $this->estudiante_id=$id;
    }



    private function usuarios(){

        return User::buscar($this->buscamin)
                    ->where('caso_especial', '>', 0)
                    ->orderBy($this->ordena, $this->ordenado)
                    ->paginate($this->pages);

    }


    public function render()
    {
        return view('livewire.academico.especial.especiales', [
            'usuarios' => $this->usuarios()
        ]);
    }
}
