<?php

namespace App\Livewire\Humana\Salario;

use App\Models\Humana\Funcionariosalario;
use App\Traits\CrtStatusTrait;
use App\Traits\FuncionariosTrait;
use Livewire\Component;

class Salarios extends Component
{
    use FuncionariosTrait;
    use CrtStatusTrait;

    public $actual;
    public $basico;
    public $subsidio_transporte;
    public $otros_subisidios;
    public $bonificacion;
    public $observaciones;

    public function mount($elegido){
        $this->detalle($elegido);
    }

    /**
     * Reglas de validación
     */
    protected $rules = [
        'basico'=>'required|numeric',
        'subsidio_transporte'=>'required|numeric',
        'otros_subisidios'=>'required|numeric',
        'bonificacion'=>'required|numeric',
        'observaciones'=>'required',
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
                        'basico',
                        'subsidio_transporte',
                        'otros_subisidios',
                        'bonificacion',
                        'observaciones',
                    );
    }

    public function new(){

        // validate
        $this->validate();

        Funcionariosalario::create([
                        'funcionario_id' => $this->actual->id,
                        'basico' => $this->basico,
                        'subsidio_transporte' => $this->subsidio_transporte,
                        'otros_subisidios' => $this->otros_subisidios,
                        'bonificacion' => $this->bonificacion,
                        'observaciones' => $this->observaciones,
        ]);

        // Notificación
        $this->dispatch('alerta', name:'Se asigno correcto el salario: '.$this->basico);
        $this->resetFields();
        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');
    }

    private function salarios(){
        return Funcionariosalario::where('funcionario_id', $this->actual->id)
                                    ->orderBy('id', 'DESC')
                                    ->get();
    }

    public function render()
    {
        return view('livewire.humana.salario.salarios',[
            'salarios'  => $this->salarios(),
        ]);
    }
}
