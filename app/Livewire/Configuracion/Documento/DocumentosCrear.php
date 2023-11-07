<?php

namespace App\Livewire\Configuracion\Documento;

use App\Models\Configuracion\Documento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DocumentosCrear extends Component
{
    public $fecha;
    public $tipo;
    public $titulo;
    public $detalles=false;
    public $actual;


    /**
     * Reglas de validación
     */
    protected $rules = [
        'fecha'        => 'required',
        'tipo'         => 'required',
        'titulo'       => 'required|unique:documentos|max:255',
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
                        'fecha',
                        'tipo',
                        'titulo'
                    );
    }

    // Crear Regimen de Salud
    public function new(){

        // validate
        $this->validate();

        //Crear documento
        $this->actual=Documento::create([
                                    'fecha'     =>$this->fecha,
                                    'tipo'      =>$this->tipo,
                                    'titulo'    =>$this->titulo,
                                    'creador_id'=>Auth::user()->id,
                                ]);


        // Notificación
        $this->dispatch('alerta', name:'Se ha creado correctamente el documento especifique sus componentes');
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->detalles=!$this->detalles;
    }

    private function palabras(){

        return DB::table('palabras_clave')
                    ->where('status', true)
                    ->orderBy('palabra')
                    ->get();
    }

    public function render()
    {

        return view('livewire.configuracion.documento.documentos-crear',[
            'palabras'=>$this->palabras(),
        ]);
    }
}
