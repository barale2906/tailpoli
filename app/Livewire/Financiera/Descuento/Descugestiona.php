<?php

namespace App\Livewire\Financiera\Descuento;

use App\Models\Financiera\Descuento;
use App\Traits\CrtStatusTrait;
use Livewire\Component;

class Descugestiona extends Component
{
    use CrtStatusTrait;

    public $name;
    public $valor;
    public $tipo;
    public $aplica;
    public $actual;

    public function mount($elegido=null){
        $this->resetFields();
        if($elegido){
            $this->actual=Descuento::find($elegido);
            $this->valores();
        }
    }

    public function valores(){
        $this->name = $this->actual->name;
        $this->valor = $this->actual->valor;
        $this->tipo = $this->actual->tipo;
        $this->aplica = $this->actual->aplica;
    }

    /**
     * Reglas de validación
     */
    protected $rules = [
        'name'         => 'required',
        'valor'        => 'required|numeric|min:0',
        'tipo'         => 'required',
        'aplica'       => 'required',
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
                        'name',
                        'valor',
                        'tipo',
                        'aplica',
                        'actual'
                    );
    }

    public function regresar(){
        $this->resetFields();
        $this->dispatch('volviendo');
    }

    public function new(){
        // validate
        $this->validate();

        //Inactiva descuento anterior
        Descuento::where('aplica',$this->aplica)
                    ->update([
                        'status' => 0
                    ]);

        Descuento::create([
                        'name' => strtolower($this->name),
                        'valor' => $this->valor,
                        'tipo' => $this->tipo,
                        'aplica' => $this->aplica,
                        'status' => 1
                    ]);



        // Notificación
        $this->dispatch('alerta', name:'Se ha creado correctamente el descuento: '.$this->name);
        $this->resetFields();

        //refresh
        $this->dispatch('volviendo');
    }

    public function editar(){
        // validate
        $this->validate();

        Descuento::where('id', $this->actual->id)
                    ->update([
                        'name' => strtolower($this->name),
                        'valor' => $this->valor,
                        'tipo' => $this->tipo,
                        'aplica' => $this->aplica,
                    ]);

        // Notificación
        $this->dispatch('alerta', name:'Se ha modificado correctamente el descuento: '.$this->name);
        $this->resetFields();

        //refresh
        $this->dispatch('volviendo');
    }

    public function render()
    {
        return view('livewire.financiera.descuento.descugestiona');
    }
}
