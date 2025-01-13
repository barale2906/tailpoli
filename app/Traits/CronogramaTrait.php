<?php

namespace App\Traits;

use App\Models\Academico\Ciclo;
use App\Models\Academico\Cronodeta;
use App\Models\Academico\Cronograma;
use App\Models\Academico\Grupo;
use App\Models\Academico\Horario;
use App\Models\Academico\Unidade;
use App\Models\Academico\Unidtema;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\WithPagination;

trait CronogramaTrait
{
    use WithPagination;
    use FiltroTrait;

    public $ordena='id';
    public $ordenado='ASC';
    public $pages = 15;

    public $buscar='';
    public $buscamin='';
    public $dias=[];
    public $ids=[];
    public $cronog;
    public $grupo;
    public $inicia;
    public $finaliza;

    public $elegido;

    public $is_modify = true;
    public $is_creating=false;

    public $filtroprofesor;
    public $filtrociclo;

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
                        'is_creating'
                    );
    }

    public function cronocrea($ciclo,$inicia,$finaliza,$grupo){

        $this->reset(
            'dias',
            'ids',
            'cronog',
            'grupo',
            'inicia',
            'finaliza',
        );

        $ultimo=Cronograma::join('cronodetas','cronogramas.id','=','cronodetas.cronograma_id')
                            ->where('cronogramas.ciclo_id',$ciclo)
                            ->select('cronodetas.fecha_programada')
                            ->orderBy('cronodetas.id','DESC')
                            ->first();

        if($ultimo && $ultimo->fecha_programada){
            //Log::info('inicia: '.$inicia.' ultimo: '.$ultimo->fecha_programada);
            /* if($ultimo->fecha_programada>$inicia){

                $ini=Carbon::create($inicia);
                $fin=Carbon::create($finaliza);

                $dif=$ini->diffInDays($fin);
                $fechaini=Carbon::create($ultimo->fecha_programada);
                $fechafin=$fechaini->addDays($dif);

                $examenfinal = Carbon::create($fechafin)->addMonths(1);
                $notas = Carbon::create($fechafin)->addDays(45);
                $this->inicia=$ultimo->fecha_programada;
                $this->finaliza=$fechafin;
                $this->grupo=$grupo;

                $this->cronog=Cronograma::create([
                                            'grupo_id'      =>$grupo,
                                            'ciclo_id'      =>$ciclo,
                                            'fecha_final'   =>$examenfinal,
                                            'fecha_notas'   =>$notas
                                        ]);
            }else{
                $examenfinal = Carbon::create($finaliza)->addMonths(1);
                $notas = Carbon::create($finaliza)->addDays(45);
                $this->inicia=$inicia;
                $this->finaliza=$finaliza;
                $this->grupo=$grupo;

                $this->cronog=Cronograma::create([
                                            'grupo_id'      =>$grupo,
                                            'ciclo_id'      =>$ciclo,
                                            'fecha_final'   =>$examenfinal,
                                            'fecha_notas'   =>$notas
                                        ]);
            } */

            $ini=Carbon::create($inicia);
                $fin=Carbon::create($finaliza);

                $dif=$ini->diffInDays($fin);
                $fechaini=Carbon::create($ultimo->fecha_programada);
                $fechafin=$fechaini->addDays($dif);

                $examenfinal = Carbon::create($fechafin)->addMonths(1);
                $notas = Carbon::create($fechafin)->addDays(45);
                $this->inicia=Carbon::create($ultimo->fecha_programada)->addDay(); // Evita sobre cargar una fecha y deja horas disponibles en la ultima fecha
                $this->finaliza=$fechafin;
                $this->grupo=$grupo;

                $this->cronog=Cronograma::create([
                                            'grupo_id'      =>$grupo,
                                            'ciclo_id'      =>$ciclo,
                                            'fecha_final'   =>$examenfinal,
                                            'fecha_notas'   =>$notas
                                        ]);

        }else{
            //Log::info('inicia: '.$inicia.' ultimo: nnn');
            $examenfinal = Carbon::create($finaliza)->addMonths(1);
            $notas = Carbon::create($finaliza)->addDays(45);
            $this->inicia=$inicia;
            $this->finaliza=$finaliza;
            $this->grupo=$grupo;

            $this->cronog=Cronograma::create([
                                        'grupo_id'      =>$grupo,
                                        'ciclo_id'      =>$ciclo,
                                        'fecha_final'   =>$examenfinal,
                                        'fecha_notas'   =>$notas
                                    ]);
        }



        $this->generadias();
    }

    public function generadias(){

        $inicio=Carbon::create($this->inicia);
        $fin=Carbon::create($this->finaliza)->addMonths(4);
        $periodo=CarbonPeriod::create($inicio,$fin);

        //Log::info('inicia: '.$inicio.' ultimo: '.$fin);

        $this->reset('dias');

        $diaclases=Horario::where('grupo_id', $this->grupo)
                        ->select('dia', DB::raw('COUNT(*) as total'))
                        ->groupBy('dia')
                        ->get();

        foreach ($periodo as $item) {
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


        $this->cronounidades();
    }

    public function cronounidades(){
        $this->reset('ids');
        $gru=Grupo::where('id',$this->grupo)->select('modulo_id')->first();
        $unidades=Unidade::where('modulo_id',$gru->modulo_id)->select('id')->get();
        foreach ($unidades as $value) {
            array_push($this->ids,$value->id);
        }

        $this->cronodetalles();
    }

    public function cronodetalles(){

        $temas=Unidtema::whereIn('unidade_id',$this->ids)->get();

        $asignaciones = [];
        foreach ($temas as $tema) {

            $tiempoRequerido = $tema->duracion;

            foreach ($this->dias as &$dia) {
                // Si hay horas disponibles ese día
                if ($dia['intensidad'] > 0) {
                    // Asignar las horas posibles al día actual
                    $horasAsignadas = min($dia['intensidad'], $tiempoRequerido);
                    $asignaciones[] = [
                        'tema_id' => $tema->id,
                        'fecha' => $dia['fecha'],
                        'horas_asignadas' => $horasAsignadas,
                    ];

                    // Reducir las horas disponibles y el tiempo requerido
                    $dia['intensidad'] -= $horasAsignadas;
                    $tiempoRequerido -= $horasAsignadas;

                    //Log::info('dia: '.$dia['intensidad'].' tema: '.$tema->id);

                    // Si la tema ya no necesita más tiempo, pasar a la siguiente tema
                    if ($tiempoRequerido <= 0) {
                        break;
                    }
                }
            }

            // Si al final de todas las fechas no hay tiempo suficiente, marcar como pendiente
            if ($tiempoRequerido > 0) {
                //Log::info('pendiente: '.$tema->id);
                $asignaciones[] = [
                    'tema_id' => $tema->id,
                    'fecha' => null,
                    'horas_asignadas' => -1,
                ];
            }
        }

        foreach ($asignaciones as $value) {

            if($value['horas_asignadas']>0){

                Cronodeta::create([
                    'cronograma_id'     => $this->cronog->id,
                    'unidtema_id'       => $value['tema_id'],
                    'fecha_programada'  => $value['fecha'],
                    'duracion'          => $value['horas_asignadas'],
                    'usuario'           => Auth::user()->id
                ]);
            }
        }


        //REcorrer los temas y compararlo con las fechas encontradas
        //Puede pasar que las fechas no coincidan o no den los tiempos.
    }

    public function fechascronograma(){
        $ultimo=Cronodeta::where('usuario', Auth::user()->id)
                            ->select('fecha_programada')
                            ->orderBy('id','DESC')
                            ->first();

        $crono=Cronograma::find($ultimo->cronograma_id);

        if($ultimo->fecha_programada>$crono->fecha_final){
            $ref=Carbon::create($ultimo->fecha_programada);
            $final=$ref->addDays(30);
            $notas=$ref->addDays(45);

            $crono->update([
                'fecha_final'   =>$final,
                'fecha_notas'   =>$notas
            ]);
        }
    }

    public function verifechas($id){

        /* $crono=Cronograma::where('ciclo_id',$id)
                            ->select('id')
                            ->orderBy('id','DESC')
                            ->first();

        $ultimo=Cronodeta::where('cronograma_id',$crono->id)
                            ->orderBy('id', 'DESC')
                            ->first(); */

        $ultimo=Cronodeta::where('usuario',Auth::user()->id)
                            ->orderBy('id', 'DESC')
                            ->first();

        $ciclofinal=Ciclo::find($id);

        if($ciclofinal->finaliza<$ultimo->fecha_programada){
            $ciclofinal->update([
                'finaliza'  => $ultimo->fecha_programada,
            ]);
        }


    }

    public function show($id){
        $this->is_creating=true;
        $this->is_modify=false;
        $this->elegido=$id;
    }

    private function cronogramas(){
        return Cronograma::buscar($this->buscamin)
                            ->profesor($this->filtroprofesor)
                            ->progra($this->filtrociclo)
                            ->orderBy($this->ordena, $this->ordenado)
                            ->paginate($this->pages);
    }

    private function profesores(){
        return User::where('rol_id', 5)
                    ->orderBy('name', 'ASC')
                    ->get();
    }

    private function ciclos(){
        return Cronograma::select('ciclo_id')
                            ->groupBy('ciclo_id')
                            ->get();
    }

}
