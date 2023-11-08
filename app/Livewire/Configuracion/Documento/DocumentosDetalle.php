<?php

namespace App\Livewire\Configuracion\Documento;

use App\Models\Configuracion\Documento;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DocumentosDetalle extends Component
{
    public $id;
    public $actual;
    public $tipodetalle;
    public $contenido;
    public $orden=1;
    public $modifica;
    public $registrados;

    public function mount($actual=null){
        $this->id=$actual['id'];
        $this->actual=Documento::find($actual['id']);
        $this->resultado();
    }

    public function resultado(){
        $this->registrados = DB::table('detalle_documento')
                                ->where('documento_id', $this->id)
                                ->orderBy('orden', 'ASC')
                                ->get();
        if($this->registrados->count()>0){
            $this->orden = $this->registrados->count()+1;
        }
    }

    /**
     * Reglas de validación
     */
    protected $rules = [
        'tipodetalle'       => 'required',
        'contenido'         => 'required',
        'orden'             => 'required',
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
            'tipodetalle',
            'contenido',
            'orden'
                    );
    }

    public function new(){
        // validate
        $this->validate();

        if($this->modifica){

            DB::table('detalle_documento')
                ->whereId($this->modifica->id)
                ->update([
                    'tipodetalle'   =>$this->tipodetalle,
                    'contenido'     =>$this->contenido,
                    'orden'         =>$this->orden,
                    'updated_at'    =>now()
                ]);

        }else{
            DB::table('detalle_documento')
            ->insert([
                'tipodetalle'   =>$this->tipodetalle,
                'contenido'     =>$this->contenido,
                'orden'         =>$this->orden,
                'documento_id'  => $this->id,
                'created_at'    =>now(),
                'updated_at'    =>now()
            ]);
        }




        $this->resetFields();
        $this->resultado();
    }

    public function editar($item){

        $this->modifica=DB::table('detalle_documento')->whereId($item)->first();

        $this->tipodetalle=$this->modifica->tipodetalle;
        $this->contenido=$this->modifica->contenido;
        $this->orden=$this->modifica->orden;
    }

    private function palabras(){

        return DB::table('palabras_clave')
                    ->where('status', true)
                    ->get();
    }


    public function render()
    {
        return view('livewire.configuracion.documento.documentos-detalle',[
            'palabras'=>$this->palabras(),
        ]);
    }
}
