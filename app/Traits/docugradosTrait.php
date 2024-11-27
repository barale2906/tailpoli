<?php

namespace App\Traits;

use App\Models\Configuracion\Docugrado;
use App\Models\Configuracion\Documento;
use Illuminate\Support\Facades\DB;

trait docugradosTrait
{

    public $diplomas;
    public $cuerpodocu=[];
    public $componentes;
    public $palab=[];
    public $reempla=[];
    public $docugrado;
    public $orientacion;


    public function iniciaregistros($acta,$doc){

        $documento=Documento::find($doc);
        $this->orientacion=$documento->orientacion;

        $this->componentes=$this->detalles=DB::table('detalle_documento')
                                            ->where('status', true)
                                            ->where('documento_id', $doc)
                                            ->select('contenido','tipodetalle','documento_id')
                                            ->orderBy('orden', 'ASC')
                                            ->get();

        $seleccionados=Docugrado::where('acta',$acta)
                                ->select('id')
                                ->get();

        foreach ($seleccionados as $value) {
            $this->docugrado=Docugrado::find($value->id);
            $this->cargaPalabras();
        }
    }




    public function cargaPalabras(){

        $this->palab=[

            'matriculaEstu',
            'matriculaInicia',
            'matriSede',
            'matriSector',
            'matriState',
            'nombreEstu',
            'documentoEstu',
            'tipodocuEstu',
            'docuExpedi',
            'cursoEstu',
            'nitInsti',
            'nombreInsti'
        ];

        $this->equi();

    }

    public function equi(){

        $matriculaEstu=$this->docugrado->matricula->id; //matriculaEstu	Numero de matricula del estudiante
        $matriculaInicia=$this->docugrado->matricula->fecha_inicia; //matriculaInicia	Fecha de inicio del estudiante
        $matriSede=$this->docugrado->matricula->sede->name; // matriSede Nombre d ela sede donde se matriculo.
        $matriSector=$this->docugrado->matricula->sede->sector->name; //Ciudad donde se matricula
        $matriState=$this->docugrado->matricula->sede->sector->state->name; // matriState Departamento en el que se matriculo.
        $nombreEstu=strtoupper($this->docugrado->matricula->alumno->name); //nombreEstu	Nombre del estudiante
        $documentoEstu=number_format($this->docugrado->matricula->alumno->documento, 0, '.', '.'); //documentoEstu	documento del estudiante
        $tipodocuEstu=strtoupper($this->docugrado->matricula->alumno->perfil->tipo_documento); //tipodocuEstu	tipo de documento del estudiante
        $docuExpedi=strtoupper($this->docugrado->matricula->alumno->perfil->lugar_expedicion); //docuExpedi	expedición del documento
        $cursoEstu=strtoupper($this->docugrado->matricula->curso->name); //cursoEstu	Curso al que se inscribio estudiante
        $nitInsti=config('instituto.nit'); //nitInsti	NIT del poliandino
        $nombreInsti=strtoupper(config('instituto.nombre_empresa')); //nombreInsti	Nombre del poliandino

        $this->reempla=[
            $matriculaEstu,
            $matriculaInicia,
            $matriSede,
            $matriSector,
            $matriState,
            $nombreEstu,
            $documentoEstu,
            $tipodocuEstu,
            $docuExpedi,
            $cursoEstu,
            $nitInsti,
            $nombreInsti,
        ];

        $this->doccrea();
    }

    public function doccrea(){

        foreach ($this->componentes as $value) {

            $dato=$value->contenido;

            $datos = str_replace($this->palab, $this->reempla, $dato);

            $nuevo=[
                'contenido'     =>$datos,
                'tipo'          =>$value->tipodetalle,
                'documento_id'  =>$value->documento_id
            ];

            array_push($this->cuerpodocu, $nuevo);

        }
    }


}
