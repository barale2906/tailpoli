<?php

namespace App\Livewire\Academico\Matricula;

use App\Models\Academico\Matricula;
use App\Models\Configuracion\Documento;
use App\Traits\MailTrait;
use App\Traits\PdfTrait;
use Carbon\Carbon;
use Livewire\Component;

class Documentos extends Component
{
    use PdfTrait;
    use MailTrait;

    public $matricula;
    public $ruta;
    public $documentos=[];
    public $is_carnet=false;

    public function mount($elegido){
        $this->matricula=Matricula::find($elegido);
        $this->crearuta();
        $this->otrosD();
        $this->controlcarnet();

    }

    public function controlcarnet(){
        $crt=new Carbon($this->matricula->created_at);
        $hoy=Carbon::today();
        $registro=$hoy->diffInDays($crt);

        if($registro>1){
            $this->is_carnet=true;
        }

    }


    public function crearuta(){
        foreach ($this->matricula->documentos as $value) {

            $this->reset('ruta');

            /* switch ($value->tipo) {

                case 'contrato':
                    //$this->ruta="/impresiones/impcontrato?c=".$this->matricula->id;
                    $this->ruta="/pdfs/contrato/".$this->matricula->id;
                    break;

                case 'pagare':
                    //$this->ruta="/impresiones/imppagare?p=".$this->matricula->id;
                    $this->ruta="/pdfs/pagaret/".$this->matricula->id;
                    break;

                case 'cartaPagare':
                    //$this->ruta="/impresiones/impcartapagare?cp=".$this->matricula->id;
                    $this->ruta="/pdfs/cartapag/".$this->matricula->id;
                    break;

                case 'actaPago':
                    //$this->ruta="/impresiones/impactapago?ap=".$this->matricula->id;
                    $this->ruta="/pdfs/actap/".$this->matricula->id;
                    break;

                case 'comproCredito':
                    //$this->ruta="/impresiones/impcomprocredito?cc=".$this->matricula->id;
                    $this->ruta="/pdfs/comprocred/".$this->matricula->id;
                    break;

                case 'comproEntrega':
                    //$this->ruta="/impresiones/impcartaentregadoc?ced=".$this->matricula->id;
                    $this->ruta="/pdfs/comproent/".$this->matricula->id;
                    break;

                case 'gastocertifinal':
                    //$this->ruta="/impresiones/impgastocertifinal?gcf=".$this->matricula->id;
                    $this->ruta="/pdfs/gastocert/".$this->matricula->id;
                    break;

                case 'matricula':
                    //$this->ruta="/impresiones/impcartapagare?cp=".$this->matricula->id;
                    $this->ruta="/pdfs/matricul/".$this->matricula->id;
                    break;

            } */

            $this->ruta="/pdfs/documento/".$this->matricula->id."/".$value->id;

            $nuevo=[
                'titulo'=>$value->titulo,
                'tipo'=>$value->tipo,
                'ruta'=>$this->ruta
            ];

            if(in_array($nuevo, $this->documentos)){

            }else{
                array_push($this->documentos, $nuevo);
            }
        }

        $this->otrosD();
    }


    public function otrosD(){

        $docu=Documento::where('status', 3)
                                ->whereNotIn('tipo', ['contrato','pagare','cartapagare','actaPago','comproCredito','comproEntrega','gastocertifinal','matricula'])
                                ->orderBy('titulo')
                                ->get();

        foreach ($docu as $value) {

            $this->reset('ruta');

            /* switch ($value->tipo) {

                case 'certiEstudio':
                    //$this->ruta="/impresiones/impcertiestudio?ce=".$this->matricula->id;
                    $this->ruta="/pdfs/certificado/".$this->matricula->id;
                    break;

                case 'estadoCuenta':
                    //$this->ruta="/impresiones/impestadocuenta?ec=".$this->matricula->id;
                    $this->ruta="/pdfs/estado/".$this->matricula->id;
                    break;

                case 'cartaCobro':
                    //$this->ruta="/impresiones/impcartacobro?cco=".$this->matricula->id;
                    $this->ruta="/pdfs/cobro/".$this->matricula->id;
                    break;

                case 'formuPractica':
                    //$this->ruta="/impresiones/impformuPractica?fp=".$this->matricula->id;
                    $this->ruta="/pdfs/pagaret/".$this->matricula->id;
                    break;
            } */

            $this->ruta="/pdfs/documento/".$this->matricula->id."/".$value->id;
            $nuevo=[
                'titulo'=>$value->titulo,
                'tipo'=>$value->tipo,
                'ruta'=>$this->ruta
            ];

            if(in_array($nuevo, $this->documentos)){

            }else{
                array_push($this->documentos, $nuevo);
            }
        }
    }

    public function carnetgen(){
        //Genera carnet
        $this->carnet($this->matricula->id);

        //Enviar email
        $this->claseEmail(2,$this->matricula->id);

        $this->dispatch('alerta', name:'Se ha enviado el carnet al correo: '.$this->matricula->alumno->email);
    }

    public function render()
    {
        return view('livewire.academico.matricula.documentos');
    }
}
