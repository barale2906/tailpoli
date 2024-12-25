<?php

namespace App\Livewire\Humana\Documento;

use App\Models\Humana\Funcionariosoporte;
use App\Traits\CrtStatusTrait;
use App\Traits\FuncionariosTrait;
use Livewire\Component;

class Documentos extends Component
{
    use CrtStatusTrait;
    use FuncionariosTrait;

    public $fecha_documento;
    public $name;
    public $ruta;
    public $tipo;
    public $actual;

    public function mount($elegido){
        $this->detalle($elegido);
    }

    /**
     * Reglas de validación
     */
    protected $rules = [
        'fecha_documento'=>'required',
        'name'=>'required',
        'tipo'=>'required',
        'archivo'=>'required'
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
                        'fecha_documento',
                        'name',
                        'tipo',
                        'ruta',
                        'archivo'
                    );
    }

    public function new(){

        // validate
        $this->validate();

        $this->ruta='funcionarios/'.$this->actual->id."-".uniqid().".".$this->archivo->extension();
        $this->archivo->storeAs($this->ruta);

        Funcionariosoporte::create([
                        'funcionario_id' => $this->actual->id,
                        'user_id' => $this->actual->user_id,
                        'fecha_documento' => $this->fecha_documento,
                        'name' => $this->name,
                        'tipo' => $this->tipo,
                        'ruta' => $this->ruta,
        ]);

        // Notificación
        $this->dispatch('alerta', name:'Se cargo correctamente el registro: '.$this->name);
        $this->resetFields();
        //refresh
        $this->dispatch('refresh');
        $this->dispatch('cancelando');
    }

    private function documentos(){
        return Funcionariosoporte::where('funcionario_id', $this->actual->id)
                                    ->orderBy('fecha_documento','DESC')
                                    ->orderBy('tipo','ASC')
                                    ->get();
    }

    public function render()
    {
        return view('livewire.humana.documento.documentos',[
            'documentos'    => $this->documentos(),
        ]);
    }
}
