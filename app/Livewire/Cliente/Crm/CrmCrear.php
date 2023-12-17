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
        );
    }

    public function new(){

        // validate
        $this->validate();

        $this->fecha=now();
        $this->fecha=date('m');

        Crm::create([
            'name' => strtolower($this->name),
            'fecha'=>now(),
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
