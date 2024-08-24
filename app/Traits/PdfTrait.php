<?php

namespace App\Traits;

use App\Models\Academico\Matricula;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

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
    }

    public function cobranzanegociacionpdf($id){
        //Invitación a negociar antes de reporte
    }

    public function cobranzareportepdf($id){
        //Se le confirma envío de carta a centrales
    }

    public function cobranzareportenegocipdf($id){
        //Invitación a negociar retiro reporte
    }
}
