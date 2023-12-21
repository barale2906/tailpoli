<?php

namespace App\Livewire\Academico\Estudiante;

use App\Models\User;
use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;
use Livewire\WithPagination;

class CasoEspMatr extends Component
{
    use WithPagination;

    public $estudiante_id;

    public $ordena='id';
    public $ordenado='DESC';
    public $pages = 3;

    public $buscar='';
    public $buscamin='';

    //Cargar variable
    public function buscaText(){
        $this->resetPage();
        $this->buscamin=strtolower($this->buscar);
    }

    //Limpiar variables
    public function limpiar(){
        $this->reset(
            'buscamin',
            'buscar',
            'estudiante_id'
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

    public function elegir($id){
        $this->estudiante_id=$id;
    }

    private function especiales(){

        $consulta = User::query()
                        ->where('caso_especial', '>', 0);

        if($this->buscamin){
            $consulta = $consulta->Where('documento', 'like', "%".$this->buscamin."%");
        }

        return $consulta->orderBy($this->ordena, $this->ordenado)
                        ->paginate($this->pages);

    }

    public function render()
    {
        return view('livewire.academico.estudiante.caso-esp-matr',[
            'especiales'=>$this->especiales()
        ]);
    }
}
