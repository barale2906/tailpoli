<?php

namespace App\Livewire\Configuracion\Sede;

use App\Models\Academico\Horario;
use App\Models\Configuracion\Area;
use App\Models\Configuracion\Country;
use App\Models\Configuracion\Sector;
use App\Models\Configuracion\Sede;
use App\Models\Configuracion\State;
use Database\Seeders\HorarioSeeder;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class SedesEditar extends Component
{
    public $id = '';
    public $name = '';
    public $address = '';
    public $phone = '';
    public $nit = '';
    public $portfolio_assistant_name = '';
    public $portfolio_assistant_phone = '';
    public $portfolio_assistant_email = '';

    public $start = '';
    public $finish = '';
    public $startmar = '';
    public $finishmar = '';
    public $startmie = '';
    public $finishmie = '';
    public $startjue = '';
    public $finishjue = '';
    public $startvie = '';
    public $finishvie = '';
    public $startsab = '';
    public $finishsab = '';
    public $startdom = '';
    public $finishdom = '';

    public $pais = '';
    public $depto = '';
    public $pobla = '';

    public $paisName = '';
    public $deptoName = '';
    public $poblaName = '';

    public $cambia=false;

    public $states;
    public $ciudades;

    public $elegido;

    public $areas = 0;
    public $areaSede;
    public $areasDefault;

    public function mount($elegido = null)
    {
        $this->name=$elegido['name'];
        $this->id=$elegido['id'];
        $this->address=$elegido['address'];
        $this->phone=$elegido['phone'];
        $this->nit=$elegido['nit'];
        $this->portfolio_assistant_name=$elegido['portfolio_assistant_name'];
        $this->portfolio_assistant_phone=$elegido['portfolio_assistant_phone'];
        $this->portfolio_assistant_email=$elegido['portfolio_assistant_email'];
        $this->start=$elegido['start'];
        $this->finish=$elegido['finish'];
        $this->ubicacion($elegido['sector_id']);
        $this->obteHorario();
    }

    public function obteHorario(){
        $horarios=Horario::where('sede_id', $this->id)
                            ->where('status', true)
                            ->where('tipo', true)
                            ->orderBy('dia')
                            ->get();

        foreach ($horarios as $value) {

            if($value->periodo){
                switch ($value->dia) {
                    case "lunes":
                        $this->start=$value->hora;
                        break;

                    case "martes":
                        $this->startmar=$value->hora;
                        break;

                    case "miercoles":
                        $this->startmie=$value->hora;
                        break;

                    case "jueves":
                        $this->startjue=$value->hora;
                        break;

                    case "viernes":
                        $this->startvie=$value->hora;
                        break;

                    case "sabado":
                        $this->startsab=$value->hora;
                        break;

                    case "domingo":
                        $this->startdom=$value->hora;
                        break;

                }
            }else{
                switch ($value->dia) {
                    case "lunes":
                        $this->finish=$value->hora;
                        break;

                    case "martes":
                        $this->finishmar=$value->hora;
                        break;

                    case "miercoles":
                        $this->finishmie=$value->hora;
                        break;

                    case "jueves":
                        $this->finishjue=$value->hora;
                        break;

                    case "viernes":
                        $this->finishvie=$value->hora;
                        break;

                    case "sabado":
                        $this->finishsab=$value->hora;
                        break;

                    case "domingo":
                        $this->finishdom=$value->hora;
                        break;

                }
            }
        }
    }

    public function ubicacion($id){
        $poblacio=Sector::where('id', $id)->first();
        $ubica=State::find($poblacio->state_id);
        $ubicados=$ubica->country()->first();
        $this->poblaName=$poblacio->name;

        $this->pais=$ubicados->id;
        $this->paisName=$ubicados->name;
        $this->depto=$ubica->id;
        $this->deptoName=$ubica->name;
        $this->pobla=$id;
    }

    public function changeUbicacion(){
        $this->pais='';
        $this->depto='';
        $this->pobla='';
        $this->cambia=true;
    }


    public function country($valor){
        $this->depto='';
        $this->pobla='';
        $this->pais=$valor;
        $this->departamentos();
    }

    //Mostrar depa
    public function departamentos(){
        $this->states = State::where('country_id', $this->pais)
                            ->orderBy('name')
                            ->get();
    }

    public function depart($valor){
        $this->pobla='';
        $this->depto=$valor;
        $this->poblaciones();
    }

    // Mostrar poblaciones
    public function poblaciones(){
        $this->ciudades = Sector::where('state_id', $this->depto)
                                ->orderBy('name')
                                ->get();
    }

    //Elegir población
    public function poblacion($valor){
        $this->pobla=$valor;
    }


    /**
     * Reglas de validación
     */
    protected $rules = [
        'name' => 'required|max:100',
        'address' => 'required|max:150',
        'phone' => 'required|max:50',
        'nit' => 'required|max:50',
        'portfolio_assistant_name' => 'required|max:100',
        'portfolio_assistant_phone' => 'required|max:50',
        'portfolio_assistant_email' => 'required|email|max:50',
        'start' => 'required',
        'finish' => 'required',
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
            'name',
            'address',
            'phone',
            'nit',
            'portfolio_assistant_name',
            'portfolio_assistant_phone',
            'portfolio_assistant_email',
            'start',
            'finish',
            'startmar',
            'finishmar',
            'startmie',
            'finishmie',
            'startjue',
            'finishjue',
            'startvie',
            'finishvie',
            'startsab',
            'finishsab',
            'startdom',
            'finishdom',
    );
    }

    //Actualizar Regimen de Salud
    public function edit()
    {
        // validate
        $this->validate();

        if($this->pais==='' || $this->depto==='' || $this->pobla==='')
        {
            $this->dispatch('alerta', name:'Se debe seleccionar la ubicación de la sede: '.$this->name);
        }

        //Actualizar registros
        Sede::whereId($this->id)->update([
            'sector_id'=>$this->pobla,
            'name'=>strtolower($this->name),
            'address' => strtolower($this->address),
            'phone' => strtolower($this->phone),
            'nit' => strtolower($this->nit),
            'portfolio_assistant_name' => strtolower($this->portfolio_assistant_name),
            'portfolio_assistant_phone' => strtolower($this->portfolio_assistant_phone),
            'portfolio_assistant_email' => strtolower($this->portfolio_assistant_email),
            'start' => $this->start,
            'finish' => $this->finish,
        ]);

        //Editar horarios
        //eliminar horarios actuales
        Horario::where('sede_id', $this->id)
                ->where('status', true)
                ->where('tipo', true)
                ->delete();

        //Buscar área ejemplo
        $area=DB::table('area_sede')
                    ->where('sede_id', $this->id)
                    ->select('area_id')
                    ->first();


        //Crear horarios de cierre
        for ($i=1; $i <= 7; $i++) {

            switch ($i) {
                case 1:
                    $dia="lunes";
                    $horai=$this->start;
                    $horaf=$this->finish;
                    break;

                case 2:
                    $dia="martes";
                    $horai=$this->startmar;
                    $horaf=$this->finishmar;
                    break;

                case 3:
                    $dia="miercoles";
                    $horai=$this->startmie;
                    $horaf=$this->finishmie;
                    break;

                case 4:
                    $dia="jueves";
                    $horai=$this->startjue;
                    $horaf=$this->finishjue;
                    break;

                case 5:
                    $dia="viernes";
                    $horai=$this->startvie;
                    $horaf=$this->finishvie;
                    break;

                case 6:
                    $dia="sabado";
                    $horai=$this->startsab;
                    $horaf=$this->finishsab;
                    break;

                case 7:
                    $dia="domingo";
                    $horai=$this->startdom;
                    $horaf=$this->finishdom;
                    break;

            }

            if($horai){
                //inicia
                Horario::create([
                    'sede_id'       =>$this->id,
                    'area_id'       =>$area->area_id,
                    'tipo'          =>true,
                    'periodo'       =>true,
                    'dia'           =>$dia,
                    'hora'          =>$horai,
                ]);

                //fin
                Horario::create([
                    'sede_id'       =>$this->id,
                    'area_id'       =>$area->area_id,
                    'tipo'          =>true,
                    'periodo'       =>false,
                    'dia'           =>$dia,
                    'hora'          =>$horaf,
                ]);
            }
        }

        $this->dispatch('alerta', name:'Se ha modificado correctamente la sede: '.$this->name);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('Editando');
    }

    //Mostrar áreas
    public function areaShow()
    {
        $this->areasDefault=Area::where('status', true)
                            ->orderBy('name')
                            ->get();

        $this->areas=$this->id;
        $areaasigna=Sede::whereid($this->id)->first();
        $this->areaSede=$areaasigna->areas()->orderBy('name')->get();
    }

    //ASignar área
    public function asignArea($idArea){
        //Buscar si ya esta asignado
        $esta=DB::table('area_sede')
                ->where('area_id', '=', $idArea['id'])
                ->where('sede_id', '=', $this->id)
                ->count();

        if($esta>0){
            $this->dispatch('alerta', name:$idArea['name'].' YA asignada.');
        }else{
            DB::table('area_sede')
                ->insert([
                    'area_id'=>$idArea['id'],
                    'sede_id'=>$this->id,
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ]);

            //$this->dispatch('alerta', name:$idArea['name'].' asignada correctamente.');
            $this->areaShow();
        }
    }

    //Eliminar área
    public function eliminarArea($idAsig){
        DB::table('area_sede')
            ->where('area_id', $idAsig['id'])
            ->where('sede_id', $this->id)
            ->delete();

        //$this->dispatch('alerta', name:$idAsig['name'].' ELIMINADA correctamente.');
        $this->areaShow();
    }

    //Consultar países
    private function paises(){
        return Country::where('status', true)
                        ->orderBy('name', 'ASC')
                        ->get();
    }

    public function render()
    {
        return view('livewire.configuracion.sede.sedes-editar',[
            'paises' => $this->paises()
        ]);
    }
}
