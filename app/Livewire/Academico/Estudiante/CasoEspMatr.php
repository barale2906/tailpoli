<?php

namespace App\Livewire\Academico\Estudiante;

use App\Models\User;
use App\Traits\FiltroTrait;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class CasoEspMatr extends Component
{
    use WithPagination;
    use FiltroTrait;

    public $estudiante_id;

    public $ordena='name';
    public $ordenado='ASC';
    public $pages = 15;


    public $buscar='';
    public $buscamin='';
    public $fechareferencia;

    public function mount(){
        $this->claseFiltro(8);
        $fecha=Carbon::today()->subMonths(12)->subDay();
        $this->fechareferencia=$fecha;
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
        $ultima=DB::table('asistencia_detalle')
                    ->where('alumno_id', $id)
                    ->orderBy('updated_at', 'DESC')
                    ->first();

        if($ultima){

            if($ultima<$this->fechareferencia){
                $this->dispatch('alerta', name:'última asistencia hace mas de un año, debe ir a coordinación.');
            }else{
                $this->estudiante_id=$id;
            }

        }else{
            $this->dispatch('alerta', name:'No registra asistencia, debe ir a coordinación');
        }
    }

    private function usuarios(){

        $consulta = User::query();

        if($this->buscamin){
            $consulta = $consulta->where('name', 'like', "%".$this->buscamin."%")
                                ->orWhere('documento', 'like', "%".$this->buscamin."%");
        }

        return $consulta->where('caso_especial', '>', 0)
                        ->orderBy($this->ordena, $this->ordenado)
                        ->paginate($this->pages);

    }

    public function render()
    {
        return view('livewire.academico.estudiante.caso-esp-matr',[
            'usuarios'=>$this->usuarios()
        ]);
    }
}
