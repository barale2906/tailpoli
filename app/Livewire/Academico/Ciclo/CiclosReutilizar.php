<?php

namespace App\Livewire\Academico\Ciclo;

use App\Models\Academico\Ciclo;
use App\Models\Academico\Ciclogrupo;
use App\Models\Configuracion\Sector;
use App\Models\Configuracion\Sede;
use Carbon\Carbon;
use Livewire\Component;

class CiclosReutilizar extends Component
{
    public $actual;
    public $duracion;
    public $inicio;
    public $fin;
    public $name;

    public function mount($elegido){
        $this->actual=Ciclo::find($elegido);
    }

    public function reutilizar(){
        $this->duracion=$this->actual->curso->duracion_meses;
        $inicio=Carbon::create($this->actual->inicia)->addMonths($this->duracion)->addDay();
        $this->inicio=$inicio;
        $fin=Carbon::create($this->actual->finaliza)->addMonths($this->duracion)->addDay();
        $this->fin=$fin;
        $this->nombrar();
    }

    public function nombrar(){
        $sede=Sede::where('id', $this->actual->sede_id)
                    ->select('slug','id','sector_id')
                    ->first();

        $sector=Sector::where('id', $sede->sector_id)
                        ->select('slug')
                        ->first();

        switch ($this->actual->jornada) {
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


        $this->name=$sector->slug." ".$sede->slug." ".$this->actual->curso->slug." ".$jor." ".$this->inicio;
        $this->new();
    }

    public function new(){

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

        foreach ($this->actual->ciclogrupos as $value) {

            $fechain=Carbon::create($value->fecha_inicio)->addDay();
            $fechain=$fechain->addMonths($this->duracion);

            $fechafin=Carbon::create($value->fecha_in)->addDay();
            $fechafin=$fechafin->addMonths($this->duracion);

            Ciclogrupo::create([
                            'ciclo_id'       =>$ciclo->id,
                            'grupo_id'       =>$value->grupo_id,
                            'fecha_inicio'   =>$fechain,
                            'fecha_fin'      =>$fechafin,
                        ]);

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
