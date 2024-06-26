<?php

namespace App\Livewire\Academico\Ciclo;

use App\Models\Academico\Ciclo;
use App\Models\Academico\Ciclogrupo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Livewire\Component;

class CiclosReutilizar extends Component
{
    public $actual;
    public $duracion;
    public $inicio;
    public $fin;
    public $name;
    public $modulos;
    public $orden;
    public $cantidad;
    public $cantidiscre;
    public $distancia;
    public $absoluto;
    public $fechainicia;
    public $fechafinaliza;
    public $fechain;
    public $fechafin;
    public $lapso;

    public $is_discre=true;

    public function mount($elegido){
        $this->actual=Ciclo::find($elegido);
        $this->orden();
    }

    public function orden(){
        DB::table('apoyo_recibo')
                ->where('tipo', 'ciclos')
                ->where('id_creador', Auth::user()->id)
                ->delete();

        $ciclos=Ciclogrupo::where('ciclo_id', $this->actual->id)
                            ->orderBy('fecha_inicio', 'ASC')
                            ->get();

        $a=1;
        foreach ($ciclos as $value) {
            DB::table('apoyo_recibo')->insert([
                'tipo'          =>'ciclos',
                'id_creador'    =>Auth::user()->id,
                'valor'         =>$a, //Orden en que aparece
                'producto'      =>$value->grupo->name,
                'id_producto'   =>$value->grupo_id
            ]);
            $a++;
        }
        $this->cantidad=$a-1;
        $this->obtener();
    }

    public function ordenar($id,$oractu){

        if($this->orden>$this->cantidad || $this->orden<=0){

            $this->reset('orden');
            $this->dispatch('corto', name:'Debe estar entre 1 y '.$this->cantidad);

        }else{
            $diferencia=$this->orden-$oractu;


            foreach ($this->modulos as $value) {

                $this->reset('distancia','absoluto');
                $ubica=$value->valor+$diferencia;


                if($ubica>$this->cantidad){
                    $this->distancia=$ubica-$this->cantidad;
                }else{
                    $this->distancia=$ubica+$this->cantidad;
                }

                if($this->distancia>$this->cantidad){
                    $this->absoluto=$this->distancia-$this->cantidad;
                }else{
                    $this->absoluto=$this->distancia;
                }

                DB::table('apoyo_recibo')
                    ->where('id', $value->id)
                    ->update([
                        'valor' =>$this->absoluto
                    ]);
            }

            $this->reset('orden');

            $this->obtener();
        }


    }

    public function ordendiscre($id){

        if(!$this->orden){
            DB::table('apoyo_recibo')
                    ->where('id', $id)
                    ->update([
                        'id_almacen' =>null
                    ]);

            $this->reset('orden');
            $this->obtener();
        }

        if($this->orden>$this->cantidad || $this->orden<=0){

            $this->reset('orden');
            $this->dispatch('corto', name:'Anulado el orden y/o Debe estar entre 1 y '.$this->cantidad);

        }else{

            $esta=DB::table('apoyo_recibo')
                        ->where('id_almacen', $this->orden)
                        ->where('id_creador', Auth::user()->id)
                        ->count('id');

            if($esta>0){
                $this->reset('orden');
                $this->dispatch('corto', name:'Ya esta asignado ese orden');
            }else{
                $this->cargadiscre($id);
            }
        }
    }

    public function cargadiscre($id){

        $this->is_discre=false;
        DB::table('apoyo_recibo')
            ->where('id', $id)
            ->update([
                'id_almacen' =>$this->orden
            ]);

        $this->reset('orden');

        $this->obtener();

    }

    public function obtener(){
        $this->modulos=DB::table('apoyo_recibo')
                            ->where('tipo', 'ciclos')
                            ->where('id_creador', Auth::user()->id)
                            ->orderBy('valor', 'ASC')
                            ->get();

        $this->dispatch('refresh');

        if(!$this->is_discre){
            $this->crtdiscre();
        }
    }

    public function crtdiscre(){

        $this->cantidiscre=DB::table('apoyo_recibo')
                        ->where('tipo', 'ciclos')
                        ->where('id_creador', Auth::user()->id)
                        ->where('id_almacen', '>', 0)
                        ->count('id_almacen');
        if($this->cantidad===$this->cantidiscre){
            $this->is_discre=true;
        }
    }

    public function reutilizar(){
        $this->duracion=$this->actual->curso->duracion_meses;

        $fin=Carbon::create($this->inicio)->addMonths($this->duracion)->addDay();
        $this->fin=$fin;
        $this->nombrar();
    }

    public function nombrar(){

        $name=explode("--",$this->actual->name);
        $detalle=explode("-",$name[2]);

        $this->name=$name[0]." -- ".$name[1]." -- ".$this->inicio." - ".$detalle[3]." - ".$detalle[4]." -- ".$name[3]." -- ".$name[4];
        $this->new();
    }

    public function new(){

        $lapso=$this->duracion/$this->cantidad;
        $lapdia=30*$lapso;
        $this->lapso=round($lapdia);

        //Crear ciclo
        $ciclo=Ciclo::create([
                        'sede_id'       =>$this->actual->sede_id,
                        'curso_id'      =>$this->actual->curso_id,
                        'name'          =>$this->name,
                        'inicia'        =>$this->inicio,
                        'finaliza'      =>$this->fin,
                        'jornada'       =>$this->actual->jornada,
                        'desertado'     =>$this->actual->desertado
                    ]);


        if($this->cantidiscre){

            $this->modulos=DB::table('apoyo_recibo')
                                ->where('tipo', 'ciclos')
                                ->where('id_creador', Auth::user()->id)
                                ->orderBy('id_almacen', 'ASC')
                                ->get();
        }

        $a=0;
        foreach ($this->modulos as $value) {
            $this->reset(
                'fechainicia',
                'fechafinaliza',
                'fechain',
                'fechafin',
            );

            if($a===0){
                $this->fechain=Carbon::create($this->inicio);

                $this->fechainicia=$this->inicio;
                $this->fechafinaliza=$this->fechain->addDays($this->lapso);
            }else{
                $ant=DB::table('apoyo_recibo')
                        ->where('id', $a)
                        ->first();

                $this->fechain=Carbon::create($ant->fecha_fin)->addDay();
                $this->fechafin=Carbon::create($ant->fecha_fin)->addDays($this->lapso);

                $this->fechainicia=$this->fechain;
                $this->fechafinaliza=$this->fechafin;
            }

            Ciclogrupo::create([
                            'ciclo_id'       =>$ciclo->id,
                            'grupo_id'       =>$value->id_producto,
                            'fecha_inicio'   =>$this->fechainicia,
                            'fecha_fin'      =>$this->fechafinaliza,
                        ]);

            DB::table('apoyo_recibo')
                ->where('id', $value->id)
                ->update([
                    'fecha_fin' =>$this->fechafinaliza,
                ]);


            $a=$value->id;
        }

        // Notificación
        $this->dispatch('alerta', name:'Se ha creado correctamente el ciclo: '.$this->name);

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');
    }


    public function render()
    {
        return view('livewire.academico.ciclo.ciclos-reutilizar');
    }
}
