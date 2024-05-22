<?php

namespace App\Livewire\Configuracion\Documento;

use App\Models\Configuracion\Documento;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Documentos extends Component
{
    use WithPagination;

    public $ordena='id';
    public $ordenado='DESC';
    public $pages=15;

    public $is_modify = true;
    public $is_creating = false;
    public $is_editing = false;

    public $actual;

    public $buscar='';
    public $buscamin='';

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
    #[On('created')]
    //Mostrar formulario de creación
    public function updatedIsCreating()
    {
        $this->is_modify = !$this->is_modify;
        $this->is_creating = !$this->is_creating;
    }

    //Activar evento
    #[On('Editando')]
    //Mostrar formulario de creación
    public function updatedIsEditing()
    {
        $this->is_modify = !$this->is_modify;
        $this->is_editing = !$this->is_editing;
    }

    //Activar evento
    #[On('volver')]
    //Mostrar formulario de creación
    public function vuelve()
    {
        $this->reset('is_modify', 'is_creating', 'is_editing');
    }

    // Mostrar Regimen de Salud
    public function show($esta){

        $this->actual=$esta;
        $this->is_modify = !$this->is_modify;
        $this->is_editing=!$this->is_editing;
    }

    //Reutilizar documento
    public function usar($item){

        $this->actual=$item;
        $this->vuelve();
        $this->is_modify = !$this->is_modify;
        $this->is_creating=!$this->is_creating;
    }

    private function documentos(){

        return Documento::where('fecha', 'like', "%".$this->buscamin."%")
                        ->orwhere('tipo', 'like', "%".$this->buscamin."%")
                        ->orwhere('titulo', 'like', "%".$this->buscamin."%")
                        ->orderBy($this->ordena, $this->ordenado)
                        ->paginate($this->pages);
    }


    public function render()
    {
        return view('livewire.configuracion.documento.documentos',[
            'documentos'=>$this->documentos(),
        ]);
    }
}
