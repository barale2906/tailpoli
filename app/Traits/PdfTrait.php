<?php

namespace App\Traits;

use App\Models\Academico\Matricula;
use App\Models\Clientes\Pqrs;
use App\Models\Financiera\Cobranza;
use App\Models\Financiera\Cobranzarchivo;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use NumberFormatter;

trait PdfTrait
{
    //Cobranza

    public $cobro;
    public $nombre;
    public $carpeta;
    public $vista;
    public $id;
    public $accion;

    public function carnet($id){

        $matricula=Matricula::find($id);
        $id=$id;
        $nombre=$matricula->alumno->documento."_carnet.pdf";
        $rutapdf='carnet/'.$nombre;
        $pdf = Pdf::loadView('pdfs.carnet', compact('matricula','id'))->download()->getOriginalContent();
        Storage::put($rutapdf, $pdf);
    }

    public function cobrapdf($id,$accion){

        $this->accion=$accion;
        $this->id=$id;

        switch ($accion) {
            case 1:
                $this->carpeta='gestioncobrar/cobrainicial/';
                $this->nombre='_cobranzainicial.pdf';
                $this->vista='pdfs.cobrainicial';
                break;

            case 2:
                $this->carpeta='gestioncobrar/cobranzanegocia/';
                $this->nombre='_cobranzanegocia.pdf';
                $this->vista='pdfs.cobranegocia';
                break;

            case 3:
                $this->carpeta='gestioncobrar/cobranreporte/';
                $this->nombre='_cobranreporte.pdf';
                $this->vista='pdfs.cobreporte';
                break;

            case 4:
                $this->carpeta='gestioncobrar/cobranzareporteneg/';
                $this->nombre='_cobranzareporteneg.pdf';
                $this->vista='pdfs.cobrareporteneg';
                break;
        }


        $this->generacobropdf();
    }

    public function generacobropdf(){
        $cobro=Cobranza::find($this->id);
        try {
            $nom=$cobro->alumno->documento."-".$this->id.$this->nombre;
            $rutapdf=$this->carpeta.$nom;
            $formapagoES = new NumberFormatter("es", NumberFormatter::SPELLOUT);
            $fopaLetVr=ucwords($formapagoES->format($cobro->saldo))." Pesos M/L."; //Valor en letras adeudado
            $fechaletras=Carbon::now()->locale('es')->isoFormat('dddd D \d\e MMMM \d\e\l Y');
            $pdf = Pdf::loadView($this->vista, compact('cobro','fopaLetVr','fechaletras'))->download()->getOriginalContent();
            Storage::put($rutapdf, $pdf);

            $this->cargasoporte($this->id,$rutapdf,$this->accion);
            $this->observa($cobro->alumno_id);
            Log::info('funcion generacobropdf Éxito N°: ' . $this->id);

            if($this->accion>1){
                $cobro->update([
                    'etapa'=>$this->accion,
                ]);
            }

            if($this->accion===4){
                $this->cobranzareportembargopdf();
            }

        } catch(Exception $exception){
            Log::info('Error funcion generacobropdf N°: ' . $this->id .' Error: ' . $exception->getMessage().' Línea: '.$exception->getLine());
        }
    }

    public function cobranzareportembargopdf(){
        $cobro=Cobranza::find($this->id);
        try {
            $nombre=$cobro->alumno->documento."-".$this->id."_cobranzareportemba.pdf";
            $rutapdf='cobranza/cobranzareportemba/'.$nombre;
            $formapagoES = new NumberFormatter("es", NumberFormatter::SPELLOUT);
            $fopaLetVr=ucwords($formapagoES->format($cobro->saldo))." Pesos M/L."; //Valor en letras adeudado
            $fechaletras=Carbon::now()->locale('es')->isoFormat('dddd D \d\e MMMM \d\e\l Y');
            $pdf = Pdf::loadView('pdfs.cobrareportemb', compact('cobro','fopaLetVr','fechaletras'))->download()->getOriginalContent();
            Storage::put($rutapdf, $pdf);

            $cobro->update([
                'etapa'=>4,
            ]);

            $this->cargasoporte($this->id,$rutapdf,5);
            Log::info('creaPdf reporte embargo cobro N°: ' . $cobro->id);

        } catch(Exception $exception){
            Log::info('creaPdf reporte embargo cobro N°: ' . $cobro->id .' Error: ' . $exception->getMessage().' Línea: '.$exception->getLine());
        }
    }

    /* public function cobranzapdf($id){
        //Carta de notificación de cobranza
        $cobro=Cobranza::find($id);

        try {
            $nombre=$cobro->alumno->documento."-".$id."_cobranzainicial.pdf";
            $rutapdf='cobrainicial/'.$nombre;
            $formapagoES = new NumberFormatter("es", NumberFormatter::SPELLOUT);
            $fopaLetVr=ucwords($formapagoES->format($cobro->saldo))." Pesos M/L."; //Valor en letras adeudado
            $fechaletras=Carbon::now()->locale('es')->isoFormat('dddd D \d\e MMMM \d\e\l Y');
            $pdf = Pdf::loadView('pdfs.cobrainicial', compact('cobro','fopaLetVr','fechaletras'))->download()->getOriginalContent();
            Storage::put($rutapdf, $pdf);

            $this->cargasoporte($id,$rutapdf,1);
            $this->observa($cobro->alumno_id);
            Log::info('creaPdf inicio cobranza cobro N°: ' . $cobro->id);

        } catch(Exception $exception){
            Log::info('creaPdf inicio cobranza cobro N°: ' . $cobro->id .' Error: ' . $exception->getMessage().' Línea: '.$exception->getLine());
        }

    }

    public function cobranzanegociacionpdf($id){
        //Invitación a negociar antes de reporte
        $cobro=Cobranza::find($id);
        try {
            $nombre=$cobro->alumno->documento."-".$id."_cobranzanegocia.pdf";
            $rutapdf='cobranzanegocia/'.$nombre;
            $formapagoES = new NumberFormatter("es", NumberFormatter::SPELLOUT);
            $fopaLetVr=ucwords($formapagoES->format($cobro->saldo))." Pesos M/L."; //Valor en letras adeudado
            $fechaletras=Carbon::now()->locale('es')->isoFormat('dddd D \d\e MMMM \d\e\l Y');
            $pdf = Pdf::loadView('pdfs.cobranegocia', compact('cobro','fopaLetVr','fechaletras'))->download()->getOriginalContent();
            Storage::put($rutapdf, $pdf);

            $cobro->update([
                'etapa'=>2,
            ]);

            $this->cargasoporte($id,$rutapdf,2);
            $this->observa($cobro->alumno_id);

        } catch(Exception $exception){
            Log::info('creaPdf negociacion cobro N°: ' . $cobro->id .' Error: ' . $exception->getMessage().' Línea: '.$exception->getLine());
        }

    }

    public function cobranzareportepdf($id){
        //Se le confirma envío de carta a centrales
        $cobro=Cobranza::find($id);

        try {

            $nombre=$cobro->alumno->documento."-".$id."_cobranreporte.pdf";
            $rutapdf='cobranreporte/'.$nombre;
            $formapagoES = new NumberFormatter("es", NumberFormatter::SPELLOUT);
            $fopaLetVr=ucwords($formapagoES->format($cobro->saldo))." Pesos M/L."; //Valor en letras adeudado
            $fechaletras=Carbon::now()->locale('es')->isoFormat('dddd D \d\e MMMM \d\e\l Y');
            $pdf = Pdf::loadView('pdfs.cobreporte', compact('cobro','fopaLetVr','fechaletras'))->download()->getOriginalContent();
            Storage::put($rutapdf, $pdf);

            $cobro->update([
                'etapa'=>3,
            ]);

            $this->cargasoporte($id,$rutapdf,3);
            $this->observa($cobro->alumno_id);

        } catch(Exception $exception){
            Log::info('creaPdf reporte cobro N°: ' . $cobro->id .' Error: ' . $exception->getMessage().' Línea: '.$exception->getLine());
        }
    }

    public function cobranzareportenegocipdf($id){
        //Invitación a negociar retiro reporte
        $cobro=Cobranza::find($id);

        try {
            $nombre=$cobro->alumno->documento."-".$id."_cobranzareporteneg.pdf";
            $rutapdf='cobranzareporteneg/'.$nombre;
            $formapagoES = new NumberFormatter("es", NumberFormatter::SPELLOUT);
            $fopaLetVr=ucwords($formapagoES->format($cobro->saldo))." Pesos M/L."; //Valor en letras adeudado
            $fechaletras=Carbon::now()->locale('es')->isoFormat('dddd D \d\e MMMM \d\e\l Y');
            $pdf = Pdf::loadView('pdfs.cobrareporteneg', compact('cobro','fopaLetVr','fechaletras'))->download()->getOriginalContent();
            Storage::put($rutapdf, $pdf);

            $cobro->update([
                'etapa'=>4,
            ]);

            $this->cargasoporte($id,$rutapdf,4);
            $this->observa($cobro->alumno_id);
            $this->cobranzareportembargopdf($id);

        } catch(Exception $exception){
            Log::info('creaPdf reporte negocia cobro N°: ' . $cobro->id .' Error: ' . $exception->getMessage().' Línea: '.$exception->getLine());
        }
    } */

    public function cargasoporte($id,$ruta,$etapa){
        $esta=Cobranzarchivo::where('ruta',$ruta)->count();
        if($esta===0){
            Cobranzarchivo::create([
                'cobranza_id'=>$id,
                'ruta'=>$ruta,
                'etapa'=>$etapa
            ]);
        }
    }

    public function observa($id){
        Pqrs::create([
            'estudiante_id' =>$id,
            'gestion_id'    =>$id,
            'fecha'         =>now(),
            'tipo'          =>2,
            'observaciones' =>'PAGO: Se realiza gestión de cobranza. ----- ',
            'status'        =>4
        ]);
    }

}
