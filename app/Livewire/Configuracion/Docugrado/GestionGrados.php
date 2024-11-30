<?php

namespace App\Livewire\Configuracion\Docugrado;

use App\Models\Configuracion\Docugrado;
use App\Models\Configuracion\Documento;
use App\Traits\FiltroTrait;
use Livewire\Component;

class GestionGrados extends Component
{
    use FiltroTrait;

    public $filtrotipo_curso;
    public $filtroacta;

    public function mount(){
        $this->claseFiltro(16);
    }

    private function actas(){
        return Docugrado::where('tipo_curso',$this->filtrotipo_curso)
                        ->select('acta', 'titulo')
                        ->groupBy('acta','titulo')
                        ->get();
    }

    private function documentos(){
        return Documento::where('tipo_curso',$this->filtrotipo_curso)
                            ->where('status',3)
                            ->orderBy('titulo','ASC')
                            ->get();
    }

    public function render()
    {
        return view('livewire.configuracion.docugrado.gestion-grados',[
            'actas'         => $this->actas(),
            'documentos'    => $this->documentos()
        ]);
    }
}
