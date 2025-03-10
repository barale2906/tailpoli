<?php

namespace App\Livewire\Financiera\ConfiguracionPago;

use App\Models\Financiera\ConfiguracionPago;
use App\Models\Financiera\ConfPagOtros;
use App\Models\Academico\Curso;
use App\Traits\FiltroTrait;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ConfiguracionPagos extends Component
{
    use WithPagination;
    use FiltroTrait;

    public $ordena='id';
    public $ordenado='DESC';
    public $pages = 15;

    public $is_modify = true;
    public $is_creating = false;
    public $is_editing = false;
    public $is_deleting = false;
    public $is_otros=false;
    public $is_otrosEdit=false;
    public $is_otrosInactivar=false;
    public $is_descuentos=false;

    public $lpstate=true;
    public $otrostate=false;

    public $elegido;

    public $buscar='';
    public $buscamin='';
    public $filtrocurso;

    protected $listeners = ['refresh' => '$refresh'];

    public function mount(){
        $this->claseFiltro(12);
    }

    //Activar evento
    #[On('cancelando')]

    public function cancelar()
    {
        $this->reset('is_modify','is_creating','is_editing','is_deleting','is_otros', 'is_otrosEdit', 'is_otrosInactivar', 'is_descuentos');
    }

    public function cambiaVista(){
        $this->lpstate=!$this->lpstate;
        $this->otrostate=!$this->otrostate;
    }

    //Activar evento
    #[On('otros')]
    //Mostrar formulario de inactivación
    public function updatedIsOtros()
    {
        $this->is_modify = !$this->is_modify;
        $this->is_otros = !$this->is_otros;
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

    // Mostrar Regimen de Salud
    public function show($esta, $act){

        $this->elegido=$esta;
        $this->is_modify = !$this->is_modify;

        switch ($act) {
            case 0:
                $this->is_editing=!$this->is_editing;
                break;

            case 1:
                $this->is_deleting=!$this->is_deleting;
                break;

            case 2:
                $this->is_otrosEdit=!$this->is_otrosEdit;
                break;

            case 3:
                $this->is_otrosInactivar=!$this->is_otrosInactivar;
                break;
        }
    }

    //Activar evento
    #[On('Inactivando')]
    //Mostrar formulario de inactivación
    public function updatedIsDeleting()
    {
        $this->is_modify = !$this->is_modify;
        $this->is_deleting = !$this->is_deleting;
    }

    //Activar evento
    #[On('descuento')]
    //Mostrar formulario de inactivación
    public function descuentactiv()
    {
        $this->cancelar();
        $this->is_modify=false;
        $this->is_descuentos=true;
    }

    private function configuraciones()
    {
        return ConfiguracionPago::buscar($this->buscamin)
                        ->curso($this->filtrocurso)
                        ->orderBy($this->ordena, $this->ordenado)
                        ->orderBy('id', 'DESC')
                        ->paginate($this->pages);
    }

    private function otros()
    {
        return ConfPagOtros::where('descripcion', 'like', "%".$this->buscamin."%")
                                    ->orderBy($this->ordena, $this->ordenado)
                                    ->paginate($this->pages);
    }

    private function cursos(){
        return Curso::orderBy('name', 'ASC')
                        ->get();
    }

    public function render()
    {
        return view('livewire.financiera.configuracion-pago.configuracion-pagos', [
            'configuraciones'=>$this->configuraciones(),
            'otros'=>$this->otros(),
            'cursos'=>$this->cursos(),
        ]);
    }
}
