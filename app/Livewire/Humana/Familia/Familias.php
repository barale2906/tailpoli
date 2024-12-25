<?php

namespace App\Livewire\Humana\Familia;

use App\Models\Humana\Funcionariofamilia;
use App\Traits\CrtStatusTrait;
use App\Traits\FuncionariosTrait;
use Livewire\Component;

class Familias extends Component
{
    use CrtStatusTrait;
    use FuncionariosTrait;

    public $actual;
    public $name;
    public $edad;
    public $telefono;
    public $relacion;
    public $beneficiario;

    public function mount($elegido){
        $this->detalle($elegido);
    }

    /**
     * Reglas de validación
     */
    protected $rules = [
        'name'=>'required',
        'edad'=>'required',
        'relacion'=>'required',
        'beneficiario'=>'required',
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
                    'name',
                    'edad',
                    'telefono',
                    'relacion',
                    'beneficiario',
                    );
    }

    public function new(){

        // validate
        $this->validate();

        Funcionariofamilia::create([
                        'funcionario_id' => $this->actual->id,
                        'name' => $this->name,
                        'edad' => $this->edad,
                        'telefono' => $this->telefono,
                        'relacion' => $this->relacion,
                        'beneficiario' => $this->beneficiario,
        ]);

        // Notificación
        $this->dispatch('alerta', name:'Se cargo correctamente familiar: '.$this->name);
        $this->resetFields();
        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');
    }

    private function familiares(){
        return Funcionariofamilia::where('funcionario_id', $this->actual->id)
                                    ->orderBy('name','ASC')
                                    ->get();
    }

    public function render()
    {
        return view('livewire.humana.familia.familias',[
            'familiares'    =>$this->familiares(),
        ]);
    }
}
