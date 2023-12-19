<?php

namespace App\Http\Controllers;

use App\Traits\RenderDocTrait;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    use RenderDocTrait;

    public function matri($id){

        $this->docubase($id,'contrato');
        $matr=$this->impresion;
        $id=$id;
        //$hoy=Carbon::today();
        $pdf = Pdf::loadView('pdfs.matricular', compact('matr','id'));

        return $pdf->stream();

    }
}
