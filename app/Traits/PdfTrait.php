<?php

namespace App\Traits;

use App\Models\Academico\Matricula;
use App\Models\Financiera\Cobranza;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use NumberFormatter;

trait PdfTrait
{
    public function carnet($id){

        $matricula=Matricula::find($id);
        $id=$id;
        $nombre=$matricula->alumno->documento."_carnet.pdf";
        $rutapdf='carnet/'.$nombre;
        $pdf = Pdf::loadView('pdfs.carnet', compact('matricula','id'))->download()->getOriginalContent();
        Storage::put($rutapdf, $pdf);
    }

    public function cobranzapdf($id){
        //Carta de notificación de cobranza
        $cobro=Cobranza::find($id);
        $nombre=$cobro->alumno->documento."-".$id."_cobranzainicial.pdf";
        $rutapdf='cobranza/'.$nombre;
        $formapagoES = new NumberFormatter("es", NumberFormatter::SPELLOUT);
        $fopaLetVr=ucwords($formapagoES->format($cobro->saldo))." Pesos M/L."; //Valor en letras adeudado
        $fechaletras=Carbon::now()->locale('es')->isoFormat('dddd D \d\e MMMM \d\e\l Y');
        $pdf = Pdf::loadView('pdfs.cobrainicial', compact('cobro','fopaLetVr','fechaletras'))->download()->getOriginalContent();
        Storage::put($rutapdf, $pdf);
    }

    public function cobranzanegociacionpdf($id){
        //Invitación a negociar antes de reporte
        $cobro=Cobranza::find($id);
        $nombre=$cobro->alumno->documento."-".$id."_cobranzanegocia.pdf";
        $rutapdf='cobranzanegocia/'.$nombre;
        $formapagoES = new NumberFormatter("es", NumberFormatter::SPELLOUT);
        $fopaLetVr=ucwords($formapagoES->format($cobro->saldo))." Pesos M/L."; //Valor en letras adeudado
        $fechaletras=Carbon::now()->locale('es')->isoFormat('dddd D \d\e MMMM \d\e\l Y');
        $pdf = Pdf::loadView('pdfs.cobranegocia', compact('cobro','fopaLetVr','fechaletras'))->download()->getOriginalContent();
        Storage::put($rutapdf, $pdf);
    }

    public function cobranzareportepdf($id){
        //Se le confirma envío de carta a centrales
    }

    public function cobranzareportenegocipdf($id){
        //Invitación a negociar retiro reporte
    }
}
