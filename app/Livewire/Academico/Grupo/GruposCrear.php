<?php

namespace App\Livewire\Academico\Grupo;

use App\Models\Academico\Grupo;
use App\Models\Academico\Modulo;
use App\Models\Configuracion\Sede;
use App\Models\User;
use Livewire\Component;

class GruposCrear extends Component
{
    public $name = '';
    public $start_date='';
    public $finish_date='';
    public $quantity_limit='';
    public $sede_id='';
    public $profesor_id='';
    public $modulo_id = '';

    public function modulo($item){
        $this->modulo_id=$item;
    }

    public function sede($item){
        $this->sede_id=$item;
    }

    public function profesor($item){
        $this->profesor_id=$item;
    }

    /**
     * Reglas de validación
     */
    protected $rules = [
        'name' => 'required|max:100',
        'start_date'=>'required',
        'finish_date'=>'required',
        'quantity_limit'=>'required'
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
                        'name',
                        'start_date',
                        'finish_date',
                        'quantity_limit',
                        'modulo_id',
                        'sede_id',
                        'profesor_id'
                    );
    }

    // Crear Regimen de Salud
    public function new(){
        // validate
        $this->validate();

        //Validar fechas
        if($this->start_date<$this->finish_date){
            //Crear registro
            Grupo::create([
                'name'=>strtolower($this->name),
                'start_date'        =>$this->start_date,
                'finish_date'       =>$this->finish_date,
                'quantity_limit'    =>$this->quantity_limit,
                'modulo_id'         =>$this->modulo_id,
                'sede_id'           =>$this->sede_id,
                'profesor_id'       =>$this->profesor_id
            ]);


            // Notificación
            $this->dispatch('alerta', name:'Se ha creado correctamente el grupo: '.$this->name);
            $this->resetFields();

            //refresh
            $this->dispatch('refresh');
            $this->dispatch('created');

        }else{
            $this->dispatch('alerta', name:'La fecha de inicio debe ser menor a la fecha de finalización.');
        }
    }

    private function modulos()
    {
        return Modulo::where('status', '=', true)
                    ->orderBy('name')
                    ->get();
    }

    private function sedes(){
        return Sede::where('status', true)
                    ->orderBy('name')
                    ->get();
    }

    private function profesores(){
        return User::where('status', true)
                    ->orderBy('name')
                    ->with('roles')->get()->filter(
                        fn ($user) => $user->roles->where('name', 'Profesor')->toArray()
                    );
    }

    public function render()
    {
        return view('livewire.academico.grupo.grupos-crear', [
            'modulos'   => $this->modulos(),
            'sedes'      => $this->sedes(),
            'profesores'=> $this->profesores()
        ]);
    }
}
