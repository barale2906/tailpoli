<?php

namespace App\Http\Controllers;

use App\Traits\docugradosTrait;
use App\Traits\RenderDocTrait;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    use RenderDocTrait;
    use docugradosTrait;

    public $documentos=['contrato','pagare','cartapagare','actaPago','comproCredito','comproEntrega','gastocertifinal','matricula'];
    public $contrat=['contrato'];
    public $pagare=['pagare'];
    public $carta=['cartapagare'];
    public $actapago=['actaPago'];
    public $comprocredito=['comproCredito'];
    public $comproentrega=['comproEntrega'];
    public $gastocertifinal=['gastocertifinal'];
    public $matricula=['matricula'];
    public $certiestudios=['certiEstudio'];
    public $estadoCuen=['estadoCuenta'];
    public $cartaCobro=['cartaCobro'];
    public $formPractica=['formuPractica'];



    public function documento($id,$doc){
        $this->docubase($id,$doc);
        $matr=$this->docuTipo;
        $detalles=$this->impresion;
        $id=$id;
        $docuMatricula=$this->docuMatricula;
        $fecha=Carbon::now();
        $fechaMes=Carbon::now()->locale('es')->isoFormat('dddd D \d\e MMMM \d\e\l Y');
        $docuFormaP=$this->docuFormaP;
        $docuCartera=$this->docuCartera;
        $edad=$this->edad;
        $matricula=1;
        $modulos=$this->Modulos;
        $plantilla=$this->plantilla;
        $horarios=$this->horarios;
        $pdf = Pdf::loadView('pdfs.matricular', compact('matr','id','detalles','docuMatricula','fecha','fechaMes','docuFormaP','docuCartera','edad','matricula','modulos','plantilla','horarios'));

        return $pdf->stream();
    }

    public function matri($id){

        $this->documatri($id,$this->documentos);
        $matr=$this->docuTipo;
        $detalles=$this->impresion;
        $id=$id;
        $docuMatricula=$this->docuMatricula;
        $fecha=Carbon::now();
        $fechaMes=Carbon::now()->locale('es')->isoFormat('dddd D \d\e MMMM \d\e\l Y');
        $docuFormaP=$this->docuFormaP;
        $docuCartera=$this->docuCartera;
        $edad=$this->edad;
        $matricula=2;
        $modulos=$this->Modulos;
        $plantilla=$this->plantilla;
        $pdf = Pdf::loadView('pdfs.matricular', compact('matr','id','detalles','docuMatricula','fecha','fechaMes','docuFormaP','docuCartera','edad','matricula','modulos','plantilla'));

        return $pdf->stream();

    }

    public function grados($acta,$doc){

        $this->iniciaregistros($acta,$doc);

        $cuerpodocu=$this->cuerpodocu;
        $margensup=$this->margensup;
        $titulotec=$this->titulotec;
        $temas=$this->temas;
        $acta=$this->acta;
        $ciudad=$this->ciudad;
        $fechagrado=$this->fechagrado;
        $folio=$this->folio;
        $libro=$this->libroregistro;
        $fechacta=$this->fechacta;
        $diplomas=$this->diplomas;
        $fechalarga=$this->fechalarga;


        $pdf = Pdf::loadView('pdfs.graduacion', compact(
            'cuerpodocu',
            'margensup',
            'titulotec',
            'temas',
            'ciudad',
            'fechagrado',
            'acta',
            'folio',
            'libro',
            'fechacta',
            'fechalarga',
            'diplomas'
        ));

        /* $pdf->setOptions([
            'margin-top' => $this->margensup,  // Margen superior en milímetros
        ]); */

        $pdf->setPaper($this->tamano, $this->orientacion);

        return $pdf->stream();
    }
}
