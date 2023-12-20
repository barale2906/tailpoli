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

    public function certificado($id){

        $this->docubase($id,$this->certiestudios);
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

    public function estado($id){

        $this->docubase($id,$this->estadoCuen);
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

    public function cobro($id){

        $this->docubase($id,$this->cartaCobro);
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

    public function contrato($id){

        $this->docubase($id,$this->contrat);
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

    public function pagaret($id){

        $this->docubase($id,$this->pagare);
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

    public function cartapag($id){

        $this->docubase($id,$this->carta);
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

    public function actap($id){

        $this->docubase($id,$this->actapago);
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

    public function comprocred($id){

        $this->docubase($id,$this->comprocredito);
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

    public function comproent($id){

        $this->docubase($id,$this->comproentrega);
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

    public function gastocert($id){

        $this->docubase($id,$this->gastocertifinal);
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

    public function matricul($id){

        $this->docubase($id,$this->matricula);
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
