<?php

namespace App\Http\Controllers;

use App\Traits\RenderDocTrait;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    use RenderDocTrait;

    public $documentos=['contrato','pagare','cartapagare','actaPago'];

    public function matri($id){

        $this->docubase($id,$this->documentos);
        $matr=$this->docuTipo;
        $detalles=$this->impresion;
        $id=$id;
        $pdf = Pdf::loadView('pdfs.matricular', compact('matr','id','detalles'));

        return $pdf->stream();

    }
}
