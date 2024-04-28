<?php

namespace App\Livewire\Academico\Matricula;

use App\Models\Academico\Matricula;
use App\Models\Configuracion\Documento;
use App\Models\Configuracion\DocumentoFirmado as ConfiguracionDocumentoFirmado;
use Livewire\Component;
use Livewire\WithFileUploads;

class DocumentoFirmado extends Component
{
    use WithFileUploads;

    public $actual;
    public $is_nuevo=false;
    public $documento;
    public $name;
    public $archivo;
    public $ruta;


    public function mount($id){
        $this->actual=Matricula::find($id);
    }

    public function carga(){
        $this->is_nuevo=true;
    }

    /**
     * Reglas de validación
     */
    protected $rules = [
        'documento' =>'required|integer',
        'name'      => 'required',
        'archivo'   => 'nullable|mimes:jpg,bmp,png,pdf,jpeg',
    ];

    /**
     * Reset de todos los campos
     * @return void
     */
    public function resetFields(){
        $this->reset(
            'documento',
            'name',
            'archivo',
            'is_nuevo'
        );
    }

    public function new(){

        // validate
        $this->validate();

        $this->name=$this->name.'-'.now().'-'.$this->actual->alumno->documento;

        if($this->archivo){

            $this->ruta='docu_firmado/'.$this->actual->id."-".uniqid().".".$this->archivo->extension();
            $this->archivo->storeAs($this->ruta);
        }


        ConfiguracionDocumentoFirmado::create([
            'estudiante_id' => $this->actual->alumno_id,
            'documento_id'  => $this->documento,
            'matricula_id'  => $this->actual->id,
            'name'          => $this->name,
            'ruta'          => $this->ruta
        ]);

        // Notificación
        $this->dispatch('alerta', name:'Se ha cargado correctamente el documento');
        $this->resetFields();
    }

    private function documentos(){
        return Documento::where('status', 3)
                            ->orderBy('titulo')
                            ->get();
    }

    public function render()
    {
        return view('livewire.academico.matricula.documento-firmado',[
            'documentos'=>$this->documentos()
        ]);
    }
}
