<?php

namespace App\Livewire\Configuracion\Documento;

use App\Models\Configuracion\Documento;
use Carbon\Carbon;
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
    public $hoy;

    public $enviado;

    public function mount($actual=null){
        $this->reset('fecha', 'tipo', 'titulo');

        $this->hoy=Carbon::now();

        if($actual){
            $this->enviado=Documento::whereId($actual)->first();
            $this->cargar();
        }
    }

    public function cargar(){
        $this->fecha=$this->enviado->fecha;
        $this->tipo=$this->enviado->tipo;
        $this->titulo=$this->enviado->titulo;
    }


    /**
     * Reglas de validación
     */
    protected $rules = [
        'fecha'        => 'required|after:hoy',
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

        //Cargar detalles si es reutilizado
        if($this->enviado){
            $detalles=DB::table('detalle_documento')
                            ->where('documento_id', $this->enviado->id)
                            ->orderBy('orden', 'ASC')
                            ->get();

            foreach ($detalles as $value) {
                DB::table('detalle_documento')
                    ->insert([
                        'tipodetalle'   => $value->tipodetalle,
                        'contenido'     => $value->contenido,
                        'orden'         => $value->orden,
                        'documento_id'  => $this->actual->id,
                        'created_at'    =>now(),
                        'updated_at'    =>now()
                    ]);
            }
        }


        // Notificación
        $this->dispatch('alerta', name:'Se ha creado correctamente el documento especifique sus componentes');
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->detalles=!$this->detalles;
    }



    public function render()
    {

        return view('livewire.configuracion.documento.documentos-crear');
    }
}
