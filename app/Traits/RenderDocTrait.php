<?php

namespace App\Traits;

use App\Models\Academico\Matricula;
use App\Models\Configuracion\Documento;
use Illuminate\Support\Facades\DB;

trait RenderDocTrait
{
    public $docuTipo;
    public $docuMatricula;
    public $palabras=[];
    public $reemplazo;
    public $nombre_empresa;
    public $detalles;
    public $impresion=[];

    public function docubase($id, $tipo, $ori=null){

        if($ori){

            $this->docuTipo=Documento::whereId($id)->first();

            $this->docuMatricula=Matricula::where('status', true)
                                        ->orderBy('id', 'DESC')
                                        ->first();
        }else{

            $this->docuTipo=Documento::where('status', 3)
                                        ->where('tipo', $tipo)
                                        ->first();

            $this->docuMatricula=Matricula::whereId($id)->first();
        }

        $this->docuDetalle();
    }

    public function docuDetalle(){

        $this->detalles=DB::table('detalle_documento')
                            ->where('documento_id', $this->docuTipo->id)
                            ->orderBy('orden', 'ASC')
                            ->get();

        $this->obtePalabras();
    }

    public function obtePalabras(){



        $datos= DB::table('palabras_clave')
                            ->where('status', true)
                            ->select('palabra')
                            ->get();

        foreach ($datos as $value) {

            array_push($this->palabras, $value);
        }

        $this->equivale();

    }

    public function equivale(){
        $matriculaId=$this->docuMatricula->id; //matriculaEstu	Numero de matricula del estudiante
        $nombreEstud=$this->docuMatricula->alumno->name; //nombreEstu	Nombre del estudiante
        $documEstu=$this->docuMatricula->alumno->documento; //documentoEstu	documento del estudiante
        $tipodocu=$this->docuMatricula->alumno->perfil->tipo_documento; //tipodocuEstu	tipo de documento del estudiante
        $direEstu=$this->docuMatricula->alumno->perfil->direccion; //direccionEstu	direccion del estudiante
        $ciudadEstu=$this->docuMatricula->alumno->perfil->state->name; //ciudadEstu	ciudad del estudiante
        $telEstu=$this->docuMatricula->alumno->perfil->celular; //telefonoEstu	teléfono del estudiante
        $curso=$this->docuMatricula->curso->name; //cursoEstu	Curso al que se inscribio estudiante
        $nit=config('instituto.nit'); //nitInsti	NIT del poliandino
        $empresa=config('instituto.nombre_empresa'); //nombreInsti	Nombre del poliandino
        $rl=config('instituto.representante_legal'); //rlInsti	Representante Legal del poliandino
        $docRl=config('instituto.documento_rl'); //rldocInsti	Documento Representante Legal del poliandino
        $dirEmp=config('instituto.direccion'); //dirInsti	dirección legal del poliandino
        $telEmp=config('instituto.telefono'); //telInsti	teléfono legal del poliandino

        $this->reemplazo=[
            $matriculaId,
            $nombreEstud,
            $documEstu,
            $tipodocu,
            $direEstu,
            $ciudadEstu,
            $telEstu,
            $curso,
            $nit,
            $empresa,
            $rl,
            $docRl,
            $dirEmp,
            $telEmp,
        ];

        $this->docFiltra();
    }

    public function docFiltra(){

        foreach ($this->detalles as $value) {

            $datos = str_replace($this->palabras, $this->reemplazo, $value);

            array_push($this->impresion, $datos);

        }
    }
}
