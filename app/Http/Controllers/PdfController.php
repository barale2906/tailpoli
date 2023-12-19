<?php

namespace App\Http\Controllers;

use App\Traits\RenderDocTrait;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    use RenderDocTrait;

    public $documentos=['contrato','pagare','cartapagare','actaPago','comproCredito','comproEntrega','gastocertifinal','matricula'];
    public $certiestudios=['certiEstudio'];
    public $estadoCuen=['estadoCuenta'];
    public $cartaCobro=['cartaCobro'];
    public $formPractica=['formuPractica'];



    public function matri($id){

        $this->docubase($id,$this->documentos);
        $matr=$this->docuTipo;
        $detalles=$this->impresion;
        $id=$id;
        $docuMatricula=$this->docuMatricula;
        $fecha=Carbon::now();
        $fechaMes=Carbon::now()->locale('es')->isoFormat('dddd D \d\e MMMM \d\e\l Y');
        $docuFormaP=$this->docuFormaP;
        $docuCartera=$this->docuCartera;
        $pdf = Pdf::loadView('pdfs.matricular', compact('matr','id','detalles','docuMatricula','fecha','fechaMes','docuFormaP','docuCartera'));

        return $pdf->stream();

    }
}
