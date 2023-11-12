<?php

namespace App\Traits;

use App\Models\Academico\Matricula;
use App\Models\Configuracion\Documento;
use App\Models\Financiera\Cartera;
use App\Models\Financiera\ConfiguracionPago;
use Illuminate\Support\Facades\DB;
use NumberFormatter;

trait RenderDocTrait
{
    public $docuTipo;
    public $docuMatricula;
    public $docuFormaP;
    public $docuCartera;
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
        $this->formaPago();
    }

    public function formaPago(){
        $this->docuFormaP=ConfiguracionPago::find($this->docuMatricula->configpago);

        if($this->docuFormaP->cuotas>0){
            $this->financiacion();
        }
    }

    public function financiacion(){
        $this->docuCartera=Cartera::where('matricula_id', $this->docuMatricula->id)
                                    ->get();
    }

    public function docuDetalle(){

        $this->detalles=DB::table('detalle_documento')
                            ->where('documento_id', $this->docuTipo->id)
                            ->select('contenido','tipodetalle')
                            ->orderBy('orden', 'ASC')
                            ->get();

        $this->obtePalabras();
    }

    public function obtePalabras(){

        $this->palabras=[

            'matriculaEstu',
            'matriculaInicia',
            'nombreEstu',
            'documentoEstu',
            'tipodocuEstu',
            'docuExpedi',
            'direccionEstu',
            'ciudadEstu',
            'telefonoEstu',
            'cursoEstu',
            'valorMatricula',
            'valorMatLetras',
            'nitInsti',
            'nombreIns',
            'rlInsti',
            'rldocInsti',
            'dirInsti',
            'telInsti'
        ];

        $this->equivale();

    }

    public function equivale(){
        $formatterES = new NumberFormatter("es", NumberFormatter::SPELLOUT);

        $matriculaId=$this->docuMatricula->id; //matriculaEstu	Numero de matricula del estudiante
        $matriculaInicia=$this->docuMatricula->fecha_inicia; //matriculaInicia	Fecha de inicio del estudiante
        $nombreEstud=strtoupper($this->docuMatricula->alumno->name); //nombreEstu	Nombre del estudiante
        $documEstu=number_format($this->docuMatricula->alumno->documento, 0, '.', '.'); //documentoEstu	documento del estudiante
        $tipodocu=strtoupper($this->docuMatricula->alumno->perfil->tipo_documento); //tipodocuEstu	tipo de documento del estudiante
        $docuExpedi=strtoupper($this->docuMatricula->alumno->perfil->tipo_documento); //docuExpedi	expedición del documento
        $direEstu=ucwords($this->docuMatricula->alumno->perfil->direccion); //direccionEstu	direccion del estudiante
        $ciudadEstu=ucwords($this->docuMatricula->alumno->perfil->state->name); //ciudadEstu	ciudad del estudiante
        $telEstu=$this->docuMatricula->alumno->perfil->celular; //telefonoEstu	teléfono del estudiante
        $curso=strtoupper($this->docuMatricula->curso->name); //cursoEstu	Curso al que se inscribio estudiante
        $valorMatricula=number_format($this->docuMatricula->valor, 0, '.', '.');
        $valorMatLetras=ucwords($formatterES->format($this->docuMatricula->valor))." Pesos M/L.";
        $nit=config('instituto.nit'); //nitInsti	NIT del poliandino
        $empresa=strtoupper(config('instituto.nombre_empresa')); //nombreInsti	Nombre del poliandino
        $rl=strtoupper(config('instituto.representante_legal')); //rlInsti	Representante Legal del poliandino
        $docRl=config('instituto.documento_rl'); //rldocInsti	Documento Representante Legal del poliandino
        $dirEmp=ucwords(config('instituto.direccion')); //dirInsti	dirección legal del poliandino
        $telEmp=config('instituto.telefono'); //telInsti	teléfono legal del poliandino

        $this->reemplazo=[
            $matriculaId,
            $matriculaInicia,
            $nombreEstud,
            $documEstu,
            $tipodocu,
            $docuExpedi,
            $direEstu,
            $ciudadEstu,
            $telEstu,
            $curso,
            $valorMatricula,
            $valorMatLetras,
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

            $dato=$value->contenido;

            $datos = str_replace($this->palabras, $this->reemplazo, $dato);

            $nuevo=[
                'contenido' =>$datos,
                'tipo'      =>$value->tipodetalle,
            ];

            array_push($this->impresion, $nuevo);

        }
    }
}
