<?php

namespace App\Traits;

use App\Models\Academico\Cronograma;
use App\Models\Academico\Grupo;
use App\Models\Academico\Horario;
use App\Models\Academico\Unidade;
use App\Models\Academico\Unidtema;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
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
    public $periodo;
    public $dias=[];
    public $ids=[];

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

    public function cronocrea($ciclo,$inicia,$finaliza,$grupo){
        $examenfinal = Carbon::create($finaliza)->addMonths(1);
        $notas = Carbon::create($finaliza)->addDays(45);
        $inicio=Carbon::create($inicia);
        $fin=Carbon::create($finaliza);
        $this->periodo=CarbonPeriod::create($inicio,$fin);
        $cronograma=Cronograma::create([
                                    'grupo_id'      =>$grupo,
                                    'ciclo_id'      =>$ciclo,
                                    'fecha_final'   =>$examenfinal,
                                    'fecha_notas'   =>$notas
                                ]);

        $this->generadias($cronograma->id,$grupo);
    }

    public function generadias($cronograma,$grupo){
        $this->reset('dias');
        $diaclases=Horario::where('grupo_id', $grupo)
                        ->select('dia', DB::raw('COUNT(*) as total'))
                        ->groupBy('dia')
                        ->get();

        foreach ($this->periodo as $item) {
            $crt=true;
            foreach ($diaclases as $value) {
                if ($crt && $item->isMonday() && $value->dia==='lunes') {
                    $arr=[
                        'dia'           => $value->dia,
                        'intensidad'    => $value->total,
                        'fecha'         => $item->toDateString()
                    ];

                    array_push($this->dias,$arr);
                    $crt=false;
                }

                if ($crt && $item->isTuesday() && $value->dia==='martes') {
                    $arr=[
                        'dia'           => $value->dia,
                        'intensidad'    => $value->total,
                        'fecha'         => $item->toDateString()
                    ];

                    array_push($this->dias,$arr);
                    $crt=false;
                }

                if ($crt && $item->isWednesday() && $value->dia==='miercoles') {
                    $arr=[
                        'dia'           => $value->dia,
                        'intensidad'    => $value->total,
                        'fecha'         => $item->toDateString()
                    ];

                    array_push($this->dias,$arr);
                    $crt=false;
                }

                if ($crt && $item->isThursday() && $value->dia==='jueves') {
                    $arr=[
                        'dia'           => $value->dia,
                        'intensidad'    => $value->total,
                        'fecha'         => $item->toDateString()
                    ];

                    array_push($this->dias,$arr);
                    $crt=false;
                }

                if ($crt && $item->isFriday() && $value->dia==='viernes') {
                    $arr=[
                        'dia'           => $value->dia,
                        'intensidad'    => $value->total,
                        'fecha'         => $item->toDateString()
                    ];

                    array_push($this->dias,$arr);
                    $crt=false;
                }

                if ($crt && $item->isSaturday() && $value->dia==='sabado') {
                    $arr=[
                        'dia'           => $value->dia,
                        'intensidad'    => $value->total,
                        'fecha'         => $item->toDateString()
                    ];

                    array_push($this->dias,$arr);
                    $crt=false;
                }

                if ($crt && $item->isSunday() && $value->dia==='domingo') {
                    $arr=[
                        'dia'           => $value->dia,
                        'intensidad'    => $value->total,
                        'fecha'         => $item->toDateString()
                    ];

                    array_push($this->dias,$arr);
                    $crt=false;
                }
            }
        }


        $this->cronounidades($cronograma,$grupo);
    }

    public function cronounidades($id,$grupo){
        $this->reset('ids');
        $gru=Grupo::where('id',$grupo)->select('modulo_id')->first();
        $unidades=Unidade::where('modulo_id',$gru->modulo_id)->select('id')->get();
        foreach ($unidades as $value) {
            array_push($this->ids,$value->id);
        }

        $this->cronodetalles($id,$grupo);
    }

    public function cronodetalles($id,$grupo){
        $temas=Unidtema::whereIn('unidade_id',$this->ids)->get();

        //REcorrer los temas y compararlo con las fechas encontradas
        //Puede pasar que las fechas no coincidan o no den los tiempos.
    }

    private function cronogramas(){
        return Cronograma::buscar($this->buscamin)
                            ->profesor($this->filtro_profesor)
                            ->orderBy($this->ordena, $this->ordenado)
                            ->paginate($this->pages);
    }

}
