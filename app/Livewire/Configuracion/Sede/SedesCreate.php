<?php

namespace App\Livewire\Configuracion\Sede;

use App\Models\Academico\Horario;
use App\Models\Configuracion\Area;
use App\Models\Configuracion\Country;
use App\Models\Configuracion\Sector;
use App\Models\Configuracion\Sede;
use App\Models\Configuracion\State;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class SedesCreate extends Component
{
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
    public $area;

    public $states;
    public $ciudades;
    public $areaSele = [];

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
        'name' => 'unique:sedes,name|required|max:100',
        'address' => 'required|max:150',
        'phone' => 'required|max:50',
        'nit' => 'unique:sedes,nit|required|max:50',
        'portfolio_assistant_name' => 'required|max:100',
        'portfolio_assistant_phone' => 'required|max:50',
        'portfolio_assistant_email' => 'required|email|max:50',
        'start' => 'required',
        'finish' => 'required',
        'areaSele' => 'required'
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

    // Crear Regimen de Salud
    public function new(){
        // validate
        $this->validate();

        //Verificar que no exista el registro en la base de datos
        $existe=Sede::Where('name', '=',strtolower($this->name))->count();

        if($existe>0){
            $this->dispatch('alerta', name:'Ya existe esta sede: '.$this->name);
        } else {
            //Crear registro
            $nueva = Sede::create([
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


            //Asignar áreas
            foreach($this->areaSele as $item){
                $this->area=$item;
                DB::table('area_sede')
                ->insert([
                    'area_id'=>$item,
                    'sede_id'=>$nueva->id,
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ]);
            }

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
                        'sede_id'       =>$nueva->id,
                        'area_id'       =>$this->area,
                        'tipo'          =>true,
                        'periodo'       =>true,
                        'dia'           =>$dia,
                        'hora'          =>$horai,
                    ]);

                    //fin
                    Horario::create([
                        'sede_id'       =>$nueva->id,
                        'area_id'       =>$this->area,
                        'tipo'          =>true,
                        'periodo'       =>false,
                        'dia'           =>$dia,
                        'hora'          =>$horaf,
                    ]);
                }
            }

            //Asignar sedes a los superusuarios
            $superusuarios = User::where('status', true)
                                    ->with('roles')->get()->filter(
                                        fn ($user) => $user->roles->where('name', 'Superusuario')->toArray()
                                    );

            foreach($superusuarios as $item){

                DB::table('sede_user')
                ->insert([
                    'user_id'                   =>$item->id,
                    'sede_id'                   =>$nueva->id,
                    'created_at'                =>now(),
                    'updated_at'                =>now(),
                ]);

            }

            // Notificación
            $this->dispatch('alerta', name:'Se ha creado correctamente la sede: '.$this->name);
            $this->resetFields();

            //refresh
            $this->dispatch('refresh');
            $this->dispatch('created');
        }
    }

    //Consultar países
    private function paises(){
        return Country::where('status', true)
                        ->orderBy('name', 'ASC')
                        ->get();
    }

    //Consultar áreas
    private function areas(){
        return Area::where('status', true)
                    ->orderBy('name')
                    ->get();
    }

    public function render()
    {
        return view('livewire.configuracion.sede.sedes-create',[
            'paises'    => $this->paises(),
            'areas'     => $this->areas()
        ]);
    }
}
