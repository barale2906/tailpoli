<?php

namespace App\Livewire\Academico\Ciclo;

use App\Models\Academico\Ciclo;
use App\Models\Academico\Ciclogrupo;
use App\Models\Academico\Curso;
use App\Models\Academico\Grupo;
use App\Models\Academico\Horario;
use App\Models\Academico\Modulo;
use App\Models\Configuracion\Sector;
use App\Models\Configuracion\Sede;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CiclosCrear extends Component
{
    public $sede_id;
    public $curso_id;
    public $curso;
    public $grupos=[];
    public $seleccionados;
    public $name;
    public $inicia;
    public $finaliza;
    public $finalizaej;
    public $jornada;
    public $desertado;
    public $contar=0;
    public $maximo;
    public $modulos;
    public $modulo_id;
    public $lapso;

    public $fechaRegistro;

    public $is_date=false;
    public $fechaModulo;
    public $fechaFin;
    public $fechafinsugerida;
    public $grupoId;
    public $moduloId;

    public function mount(){
        $this->fechaRegistro=Carbon::now()->subDays(3);
        DB::table('apoyo_recibo')
            ->where('id_creador', Auth::user()->id)
            ->delete();
    }


    public function updatedCursoId(){

        $this->reset('grupos', 'seleccionados', 'curso', 'contar', 'jornada', 'name');

        $this->curso=Curso::find($this->curso_id);
        $this->modulos=Modulo::where('curso_id', $this->curso_id)
                                ->where('status', true)
                                ->orderBy('name', 'ASC')
                                ->get();


        $this->maximo=$this->modulos->count();
        $lapso=$this->curso->duracion_meses/$this->maximo;
        $lapdia=30*$lapso;
        $this->lapso=round($lapdia);


        foreach ($this->curso->modulos as $value) {

            $grupo=Grupo::where('modulo_id', $value->id)
                        ->where('sede_id', $this->sede_id)
                        ->where('status', true)
                        ->orderBy('modulo_id')
                        ->get();

            if($grupo->count()>0){

                foreach ($grupo as $value) {

                    /* $nuevo=[
                        'id'            =>$value->id,
                        'name'          =>$value->name,
                        'profesor_id'   =>$value->profesor_id,
                        'profesor'      =>$value->profesor->name,
                        'inscritos'     =>$value->inscritos,
                        'limit'         =>$value->quantity_limit,
                        'modulo'        =>$value->modulo->id,
                    ];

                    if(in_array($nuevo, $this->grupos)){

                    }else{
                        array_push($this->grupos, $nuevo);

                    } */

                    $this->contar=$this->contar+1;
                }

            }


        }

        if($this->contar===0){
            $this->dispatch('alerta', name:'No hay grupos para el curso: '.$this->curso->name.', generelos antes.');
        }

    }

    public function updatedInicia(){

        $ini=new Carbon($this->inicia);
        $fin=$ini->addMonths($this->curso->duracion_meses);
        $fin->format('Y-m-d');
        $this->finalizaej=$fin;
    }

    public function updatedJornada(){
        if($this->jornada<4){
            $this->desertado=config('instituto.desertado_entresemana');
        }else{
            $this->desertado=config('instituto.desertado_fin');
        }
    }

    public function updatedModuloId(){
        $this->reset('fechaModulo','fechaFin' , 'grupoId', 'moduloId', 'grupos', 'is_date');

        $this->grupos=Grupo::where('sede_id', $this->sede_id)
                            ->where('jornada', $this->jornada)
                            ->where('modulo_id', $this->modulo_id)
                            ->where('status', true)
                            ->get();
    }

    public function updatedFechaModulo(){
        $fechaFin=Carbon::create($this->fechaModulo)->addDays($this->lapso);
        $this->fechaFin=$fechaFin->format('Y-m-d');
        $this->fechafinsugerida=$fechaFin->format('Y-m-d');
    }

    public function nombrar(){
        $sedesel=Sede::where('id', $this->sede_id)
                    ->select('name','id','sector_id')
                    ->first();

        $sectorsel=Sector::where('id', $sedesel->sector_id)
                        ->select('name')
                        ->first();

        switch ($this->jornada) {
            case "1":
                $jor="Mañana";
                break;

            case "2":
                $jor="Tarde";
                break;

            case "3":
                $jor="Noche";
                break;

            case "4":
                $jor="Fin Semana";
                break;
        }


        $sede=explode(" ",$sedesel->name);
        $ciudad=explode(" ",$sectorsel->name);
        //$curso=explode(" ",$this->curso->name);

            $sedeBase="";

            for ($i=0; $i < count($sede); $i++) {

                $lon=strlen($sede[$i]);


                if($lon>3){
                    $text=substr($sede[$i], 0, 4);
                    $sedeBase=$sedeBase."-".$text;
                    //Log::info('Line: ' . $i . ' Longitud: '.$lon.', texto. '.$text.' Original: '.$sede[$i]);
                }else{
                    $text=substr($sede[$i], 0, $lon);
                    $sedeBase=$sedeBase."-".$text;
                    //Log::info('Line: ' . $i . ' Longitud: '.$lon.', texto. '.$text.' Original: '.$sede[$i]);
                }
            }

            $ciudadBase="";

            for ($i=0; $i < count($ciudad); $i++) {

                $lon=strlen($ciudad[$i]);


                if($lon>3){
                    $text=substr($ciudad[$i], 0, 4);
                    $ciudadBase=$ciudadBase."-".$text;
                    //Log::info('Line: ' . $i . ' Longitud: '.$lon.', texto. '.$text.' Original: '.$sede[$i]);
                }else{
                    $text=substr($ciudad[$i], 0, $lon);
                    $ciudadBase=$ciudadBase."-".$text;
                    //Log::info('Line: ' . $i . ' Longitud: '.$lon.', texto. '.$text.' Original: '.$sede[$i]);
                }
            }

            //Seleccionar el primer grupo
            $elegido=DB::table('apoyo_recibo')
                        ->where('id_creador', Auth::user()->id)
                        ->select('id_concepto')
                        ->orderBy('fecha_movimiento', 'ASC')
                        ->first();

            $horar=Horario::where('grupo_id',$elegido->id_concepto)
                                ->where('status', true)
                                //->orderBy('dia','ASC')
                                ->orderBy('hora','ASC')
                                ->get();

            $horarios="";
            $dias="";

            foreach ($horar as $value) {

                if (strpos($dias, $value->dia) === false) {
                    $dias=$dias." ".$value->dia;
                }

                if(empty($horarios)){
                    $horarios=$value->hora;
                }

            }

        $this->name=$this->curso->name." -- ".$jor." -- ".$this->inicia." - ".$dias." - ".$horarios." -- ".$sedeBase." -- ".$ciudadBase;
    }

    public function activFecha($id, $mod){

        $this->grupoId=$id;
        $this->moduloId=$mod;
        $this->is_date=!$this->is_date;
    }

    public function volver(){
        $this->is_date=!$this->is_date;
        $this->reset('is_date', 'fechaModulo','fechaFin' , 'grupoId');
    }

    public function selGrupo(){

        if($this->fechaModulo<$this->fechaFin){
            $esta=DB::table('apoyo_recibo')
                    ->where('id_cartera', $this->moduloId)
                    ->orwhereBetween('fecha_movimiento', [$this->fechaModulo,$this->fechaFin])
                    ->orwhereBetween('fecha_fin', [$this->fechaModulo,$this->fechaFin])
                    ->count();

            if($esta===0){

                $ele=Grupo::where('id',$this->grupoId)->first();

                DB::table('apoyo_recibo')
                        ->insert([
                            'id_creador'        =>Auth::user()->id,
                            'id_concepto'       =>$ele->id,
                            'tipo'              =>$ele->name,
                            'id_producto'       =>$ele->profesor_id,
                            'producto'          =>$ele->profesor->name,
                            'valor'             =>$ele->inscritos,
                            'id_ultimoreg'      =>$ele->quantity_limit,
                            'id_cartera'        =>$ele->modulo_id,
                            'fecha_movimiento'  =>$this->fechaModulo,
                            'fecha_fin'         =>$this->fechaFin
                        ]);

                $this->reset('is_date', 'fechaModulo','fechaFin' , 'grupoId', 'modulo_id', 'moduloId','grupos');
                $this->ordenarrender();
            }else{
                $this->dispatch('alerta', name:'modulo ya cargado o traslape de fechas');
            }


        }else{
            $this->dispatch('alerta', name:'La fecha de inicio debe ser menor a la de finalización');
        }


    }


    public function ordenarrender(){

        $this->seleccionados=DB::table('apoyo_recibo')
                                ->where('id_creador', Auth::user()->id)
                                ->orderBy('fecha_movimiento', 'ASC')
                                ->get();
    }

    public function elimGrupo($id){
        DB::table('apoyo_recibo')
            ->where('id', $id)
            ->delete();

        $this->ordenarrender();
    }

    /**
     * Reglas de validación
     */
    protected $rules = [
        'sede_id'=>'required|integer',
        'curso_id'=>'required|integer',
        'name' => 'required|max:200',
        //'inicia'=>'required|date|after:fechaRegistro',
        'finaliza'=>'required|date',
        'jornada'=>'required|integer',
        'desertado'=>'required'
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
                        'sede_id',
                        'curso_id',
                        'name',
                        'inicia',
                        'finaliza',
                        'jornada',
                        'desertado'
                    );
    }

    // Crear
    public function new(){

        $this->nombrar();

        // validate
        $this->validate();

        $primera=DB::table('apoyo_recibo')
                                ->where('id_creador', Auth::user()->id)
                                ->orderBy('fecha_movimiento', 'ASC')
                                ->first();

        if($primera->fecha_movimiento===$this->inicia){
            if($this->inicia<$this->finaliza){
                //Crear ciclo
                $ciclo=Ciclo::create([
                    'sede_id'       =>$this->sede_id,
                    'curso_id'      =>$this->curso_id,
                    'name'          =>$this->name,
                    'inicia'        =>$this->inicia,
                    'finaliza'      =>$this->finaliza,
                    'jornada'       =>$this->jornada,
                    'desertado'     =>$this->desertado
                ]);

                foreach ($this->seleccionados as $value) {

                    Ciclogrupo::create([
                        'ciclo_id'       =>$ciclo->id,
                        'grupo_id'       =>$value->id_concepto,
                        'fecha_inicio'   =>$value->fecha_movimiento,
                        'fecha_fin'      =>$value->fecha_fin,
                    ]);

                }

                // Notificación
                $this->dispatch('alerta', name:'Se ha creado correctamente el ciclo: '.$this->name);
                $this->resetFields();

                //refresh
                $this->dispatch('refresh');
                $this->dispatch('cancelando');
            }else{
                $this->dispatch('alerta', name:'La fecha de inicio debe ser inferior a la de finalización');
            }
        }else{
            $this->dispatch('alerta', name:'La fecha de inicio debe ser igual a la del primer modulo');
        }






    }

    private function cursos(){
        return Curso::where('status', true)
                    ->orderBy('name')
                    ->get();
    }

    private function sedes(){
        return Sede::where('status', true)
                    ->orderBy('name')
                    ->get();
    }

    public function render(){
        return view('livewire.academico.ciclo.ciclos-crear',[
            'cursos'=>$this->cursos(),
            'sedes'=>$this->sedes(),
        ]);
    }
}
