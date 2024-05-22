<?php

namespace App\Livewire\Configuracion\Documento;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class DocumentosTipo extends Component
{
    use WithPagination;

    public $ordena='id';
    public $ordenado='DESC';
    public $pages=15;


    protected $listeners = ['refresh' => '$refresh'];

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

    private function documentos(){
        return DB::table('tipo_documentos')
                    ->where('status', true)
                    ->orderBy('name')
                    ->orderBy($this->ordena, $this->ordenado)
                    ->paginate($this->pages);
    }

    public function render()
    {
        return view('livewire.configuracion.documento.documentos-tipo',[
            'documentos'=>$this->documentos()
        ]);
    }
}
