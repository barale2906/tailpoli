<?php

namespace App\Livewire\Cliente\Crm;

use App\Models\Clientes\Crm;
use App\Models\Configuracion\Sector;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CrmCrear extends Component
{
    public $name;
    public $telefono;
    public $email;
    public $historial;
    public $curso;
    public $sector_id;
    public $fecha;
    public $mes;
    public $actual;
    public $editar=false;
    public $status;
    public $observaciones=[];

    public function mount($elegido=null){
        if($elegido){
            $this->resetFields();
            $this->editar=true;
            $this->actual=Crm::whereId($elegido)->first();
            $this->datos();
        }
    }

    public function datos(){

        $this->name=$this->actual->name;
        $this->telefono=$this->actual->telefono;
        $this->email=$this->actual->email;
        $this->curso=$this->actual->curso;
        $this->sector_id=$this->actual->sector_id;
        $this->status=$this->actual->status;
        $this->arraobserva();
    }

    public function arraobserva(){
        $this->observaciones=explode("-----", $this->actual->historial);
    }

    /**
     * Reglas de validación
     */
    protected $rules = [
        'name' => 'required',
        'telefono'=>'required',
        'email'=>'required|email',
        'historial'=>'required',
        'sector_id'=>'required|integer',
        'curso'=>'required',
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
            'name',
            'telefono',
            'email',
            'historial',
            'sector_id',
            'curso',
            'actual',
            'editar'
        );
    }

    public function new(){

        // validate
        $this->validate();

        $this->fecha=now();
        $this->fecha=date('m');

        Crm::create([
            'name' => strtolower($this->name),
            'fecha_gestion'=>now(),
            'fecha_registro'=>now(),
            'fecha_carga'=>now(),
            'telefono'=>$this->telefono,
            'email'=>$this->email,
            'historial'=>now()." ".Auth::user()->name."Creo el cliente con ests observaciones: ".strtolower($this->historial)." ----- ",
            'sector_id'=>$this->sector_id,
            'curso'=>strtolower($this->curso),
            'mes'=>$this->fecha,
            'gestiona_id'=>Auth::user()->id,

        ]);

        // Notificación
        $this->dispatch('alerta', name:'Se ha creado correctamente el cliente: '.$this->name);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');
    }

    public function edit(){

        // validate
        $this->validate();

        $this->actual->update([
            'name' => strtolower($this->name),
            'telefono'=>$this->telefono,
            'email'=>$this->email,
            'historial'=>now()." ".Auth::user()->name.": ".strtolower($this->historial)." ----- ".$this->actual->historial,
            'sector_id'=>$this->sector_id,
            'curso'=>strtolower($this->curso),
            'status'=>$this->status
        ]);

        // Notificación
        $this->dispatch('alerta', name:'Se ha actualizado correctamente el cliente: '.$this->name);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');
    }

    private function ciudades(){
        return Sector::where('status', true)
                        ->orderBy('name', 'ASC')
                        ->get();
    }

    public function render()
    {
        return view('livewire.cliente.crm.crm-crear', [
            'ciudades'=>$this->ciudades()
        ]);
    }
}
