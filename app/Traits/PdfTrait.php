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
}
