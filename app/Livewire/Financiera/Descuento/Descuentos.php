<?php

namespace App\Livewire\Financiera\Descuento;

use App\Models\Financiera\Descuento;
use App\Traits\CrtStatusTrait;
use Livewire\Attributes\On;
use Livewire\Component;

class Descuentos extends Component
{
    use CrtStatusTrait;

    public $ordena='status';
    public $ordenado='DESC';
    public $pages = 15;
    public $elegido;

    public $is_modify = true;
    public $is_descuenuevo=false;

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

    public function show($esta, $act){

        $this->is_modify = false;
        $this->reset('elegido');

        switch ($act) {
            case 0:
                $this->elegido=$esta;
                $this->is_descuenuevo=true;
                break;

            case 1:
                $this->is_descuenuevo=true;
                break;
        }
    }

    #[On('volviendo')]

    public function volver()
    {
        $this->reset(
                        'is_modify',
                        'is_descuenuevo'
                    );
    }

    private function listdescuentos(){
        return Descuento::orderBy($this->ordena, $this->ordenado)
                        ->paginate($this->pages);
    }



    public function render()
    {
        return view('livewire.financiera.descuento.descuentos',[
            'listdescuentos' => $this->listdescuentos(),
        ]);
    }
}
