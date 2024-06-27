<?php

namespace App\Livewire\Academico\Grupo;

use App\Models\Academico\Grupo;
use App\Models\Academico\Modulo;
use App\Models\Configuracion\Sede;
use App\Models\User;
use Livewire\Component;

class GruposEditar extends Component
{
    public $name = '';/*
    public $start_date='';
    public $finish_date=''; */
    public $quantity_limit='';
    public $sede_id='';
    public $profesor_id='';
    public $modulo_id = '';
    public $id = '';
    public $elegido;

    /**
     * Reglas de validación
     */
    protected $rules = [
        'name' => 'required|max:100',/*
        'start_date'=>'required',
        'finish_date'=>'required', */
        'quantity_limit'=>'required|integer',
        'sede_id'=>'required|integer',
        'modulo_id'=>'required|integer',
        'profesor_id'=>'required|integer',
        'id'    => 'required'
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
                    'name',/*
                    'start_date',
                    'finish_date', */
                    'quantity_limit',
                    'modulo_id',
                    'sede_id',
                    'profesor_id',
                    'id'
                );
    }

    public function mount($elegido = null)
    {
        $this->id=$elegido['id'];
        $this->name=$elegido['name'];/*
        $this->start_date=$elegido['start_date'];
        $this->finish_date=$elegido['finish_date']; */
        $this->quantity_limit=$elegido['quantity_limit'];
        $this->sede_id=$elegido['sede_id'];
        $this->modulo_id=$elegido['modulo_id'];
        $this->profesor_id=$elegido['profesor_id'];

    }

    //Actualizar Regimen de Salud
    public function edit()
    {
        // validate
        $this->validate();

        //Actualizar registros
        Grupo::whereId($this->id)->update([
            /*'name'=>strtolower($this->name),
            'start_date'        =>$this->start_date,
            'finish_date'       =>$this->finish_date,
            'modulo_id'         =>$this->modulo_id,
            'sede_id'           =>$this->sede_id,*/
            'quantity_limit'    =>$this->quantity_limit,
            'profesor_id'       =>$this->profesor_id
        ]);

        $this->dispatch('alerta', name:'Se ha modificado correctamente el grupo: '.$this->name);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('Editando');
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
                    ->where('rol_id', 5)
                    ->orderBy('name')
                    ->get();
    }

    public function render()
    {
        return view('livewire.academico.grupo.grupos-editar', [
            'modulos'   => $this->modulos(),
            'sedes'      => $this->sedes(),
            'profesores'=> $this->profesores()
        ]);
    }
}
