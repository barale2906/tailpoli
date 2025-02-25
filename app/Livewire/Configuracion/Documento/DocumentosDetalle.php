<?php

namespace App\Livewire\Configuracion\Documento;

use App\Models\Academico\Matricula;
use App\Models\Configuracion\Docugrado;
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
    public $docuanterior;
    public $alerta=false;
    public $ruta;

    public function mount($actual=null){
        $this->id=$actual['id'];
        $this->actual=Documento::find($actual['id']);
        $this->anterior();
        $this->resultado();
    }

    public function anterior(){
        $this->docuanterior=Documento::where('status', 2)
                                        ->where('tipo', $this->actual->tipo)
                                        ->first();
    }

    public function resultado(){
        $this->registrados = DB::table('detalle_documento')
                                ->where('documento_id', $this->id)
                                ->orderBy('orden', 'ASC')
                                ->get();
        if($this->registrados->count()>0){
            $this->orden = $this->registrados->count()+1;
        }

        $this->definRuta();
    }

    public function definRuta(){

        $matr=Matricula::where('status', true)->select('id')->orderBy('id', 'DESC')->first();

        if($this->actual->control!==2){
            $this->ruta="/pdfs/documento/".$matr->id."/".$this->actual->id;
        }else{
            $docus=Docugrado::where('tipo_curso',$this->actual->tipo_curso)->orderBy('id','DESC')->select('acta','curso_id')->first();
            $this->ruta="/pdfs/docugrado/".$docus->acta."/".$docus->curso_id."/".$this->actual->id;
        }



        /* switch ($this->actual->tipo) {

            case 'contrato':
                $this->ruta="/impresiones/impcontrato?o=1&c=".$this->actual->id;
                break;

            case 'pagare':
                $this->ruta="/impresiones/imppagare?o=1&p=".$this->actual->id;
                break;

            case 'cartaPagare':
                $this->ruta="/impresiones/impcartapagare?o=1&cp=".$this->actual->id;
                break;

            case 'certiEstudio':
                $this->ruta="/impresiones/impcertiestudio?o=1&ce=".$this->actual->id;
                break;

            case 'actaPago':
                $this->ruta="/impresiones/impactapago?o=1&ap=".$this->actual->id;
                break;

            case 'comproCredito':
                $this->ruta="/impresiones/impcomprocredito?o=1&cc=".$this->actual->id;
                break;

            case 'comproEntrega':
                $this->ruta="/impresiones/impcartaentregadoc?o=1&ced=".$this->actual->id;
                break;

            case 'estadoCuenta':
                $this->ruta="/impresiones/impestadocuenta?o=1&ec=".$this->actual->id;
                break;

            case 'cartaCobro':
                $this->ruta="/impresiones/impcartacobro?o=1&cco=".$this->actual->id;
                break;

            case 'gastocertifinal':
                    $this->ruta="/impresiones/impgastocertifinal?o=1&gcf=".$this->actual->id;
                    break;

            case 'formuPractica':
                $this->ruta="/impresiones/impformuPractica?o=1&fp=".$this->actual->id;
                break;
        } */
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

            $this->reset('modifica');

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

    public function eliminar($id){

        DB::table('detalle_documento')->whereId($id)->delete();
        $this->resultado();
    }

    public function finalizar(){
        $this->alerta=!$this->alerta;
    }

    public function culminar(){

        $this->actual->update([
            'status' => 2
        ]);

        // Notificación
        $this->dispatch('alerta', name:'Se ha activado correctamente el documento: '.$this->actual->titulo.', entrará en vigencia el: '.$this->actual->fecha);
        $this->resetFields();

        //refresh
        $this->dispatch('refresh');
        $this->dispatch('volver');
    }

    public function render()
    {
        return view('livewire.configuracion.documento.documentos-detalle');
    }
}
