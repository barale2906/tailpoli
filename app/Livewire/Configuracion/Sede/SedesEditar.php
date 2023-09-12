<?php

namespace App\Livewire\Configuracion\Sede;

use App\Models\Configuracion\Country;
use App\Models\Configuracion\Sector;
use App\Models\Configuracion\Sede;
use App\Models\Configuracion\State;
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
            'finish'
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

        $this->dispatch('alerta', name:'Se ha modificado correctamente el departamento: '.$this->name);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('Editando');
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
