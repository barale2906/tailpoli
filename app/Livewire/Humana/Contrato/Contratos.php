<?php

namespace App\Livewire\Humana\Contrato;

use App\Models\Humana\Funcionariosoporte;
use App\Traits\CrtStatusTrait;
use App\Traits\FuncionariosTrait;
use Livewire\Component;

class Contratos extends Component
{
    use CrtStatusTrait;
    use FuncionariosTrait;
    public $ids=[];
    public $actual;

    public function mount($elegido){
        $this->detalle($elegido);
        $this->docum();
    }

    public function docum(){
        $this->reset('ids');
        for ($i=0; $i < count($this->documentosFuncionarios); $i++) {
            if($this->documentosFuncionarios[$i]==="Contrato"||$this->documentosFuncionarios[$i]==="Otrosí"){
                array_push($this->ids,$i);
            }
        }
    }

    private function docucontras(){
        return Funcionariosoporte::where('funcionario_id', $this->actual->id)
                                    ->whereIn('tipo', $this->ids)
                                    ->orderBy('fecha_documento','DESC')
                                    ->orderBy('tipo','ASC')
                                    ->get();
    }

    public function render()
    {
        return view('livewire.humana.contrato.contratos',[
            'docucontras' => $this->docucontras(),
        ]);
    }
}
