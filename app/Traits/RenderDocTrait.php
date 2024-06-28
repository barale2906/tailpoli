<?php

namespace App\Traits;

use App\Models\Academico\Matricula;
use App\Models\Academico\Modulo;
use App\Models\Configuracion\Documento;
use App\Models\Financiera\Cartera;
use App\Models\Financiera\ConfiguracionPago;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use NumberFormatter;

trait RenderDocTrait
{
    public $docuTipo;
    public $docuMatricula;
    public $Modulos;
    public $docuFormaP;
    public $cuotas;
    public $valormes;
    public $docuCartera;
    public $palabras=[];
    public $reemplazo;
    public $nombre_empresa;
    public $detalles;
    public $impresion=[];
    public $deuda;
    public $edad;


    //public function docubase($id, $tipo, $ori=null){
    public function docubase($id, $doc){

        $this->docuTipo=Documento::whereId($doc)->first();

        $this->docuMatricula=Matricula::whereId($id)->first();

        $this->docuDetalle();
        $this->formaPago();
        $this->modulosCurso();
    }

    public function modulosCurso(){
        $this->Modulos=Modulo::where('curso_id', $this->docuMatricula->curso_id)
                                ->where('status', true)
                                ->orderBy('name', 'ASC')
                                ->get();
    }

    public function documatri($id, $tipo){

        $this->docuMatricula=Matricula::whereId($id)->first();

        $this->docuTipo=Documento::where('status', 3)
                                        ->whereIn('tipo', $tipo)
                                        ->get();


        $this->formaPago();
        $this->docuDetalleMatri();
    }

    public function docuDetalleMatri(){

        $ids=[];

        foreach ($this->docuTipo as $value) {
            array_push($ids, $value->id);
        }

        $this->detalles=DB::table('detalle_documento')
                            ->where('status', true)
                            ->whereIn('documento_id', $ids)
                            ->select('contenido','tipodetalle','documento_id')
                            ->orderBy('orden', 'ASC')
                            ->get();

        $this->obtePalabras();
    }

    public function docuDetalle(){

        $this->detalles=DB::table('detalle_documento')
                            ->where('status', true)
                            //->whereIn('documento_id', $ids)
                            ->where('documento_id', $this->docuTipo->id)
                            ->select('contenido','tipodetalle','documento_id')
                            ->orderBy('orden', 'ASC')
                            ->get();

        $this->obtePalabras();

    }

    public function formaPago(){
        $this->docuFormaP=ConfiguracionPago::find($this->docuMatricula->configpago);


        if($this->docuFormaP){
            $this->financiacion();
        }
    }

    public function financiacion(){

        $this->docuCartera=Cartera::where('matricula_id', $this->docuMatricula->id)
                                    ->get();
        $this->calculo();
    }

    public function calculo(){

        $fecha=Carbon::now();
        $nacio=$this->docuMatricula->alumno->perfil->fecha_nacimiento;

        if($nacio){
            $this->edad=$fecha->diffInYears($nacio);
        }else{
            $this->edad=18;
        }



        foreach ($this->docuCartera as $value) {
            if($value->fecha_pago<$fecha){
                $this->deuda=$this->deuda+$value->saldo;
            }
        }
    }

    public function obtePalabras(){

        $this->palabras=[

            'matriculaEstu',
            'matriculaInicia',
            'matriSede',
            'matriSector',
            'matriState',
            'nombreEstu',
            'documentoEstu',
            'tipodocuEstu',
            'docuExpedi',
            'horaDocu',
            'direccionEstu',
            'ciudadEstu',
            'telefonoEstu',
            'cursoEstu',
            'cursoDuraHor',
            'cursoDuraMes',
            'valorMatricula',
            'valorMatLetras',
            'nitInsti',
            'nombreIns',
            'rlInsti',
            'rldocInsti',
            'dirInsti',
            'telInsti',
            'deuda',
            'fechaCrea',
            'fopaCuot',
            'fopaVrMes',
            'fopaLetVrMes'
        ];

        $this->equivale();

    }

    public function equivale(){
        $formaPago=ConfiguracionPago::find($this->docuMatricula->configpago);
        if($formaPago){
            $this->cuotas=$formaPago->cuotas;
            $this->valormes=$formaPago->valor_cuota;
        }else{
            $this->cuotas=0;
            $this->valormes=0;
        }
        $formatterES = new NumberFormatter("es", NumberFormatter::SPELLOUT);
        $formapagoES = new NumberFormatter("es", NumberFormatter::SPELLOUT);

        $matriculaId=$this->docuMatricula->id; //matriculaEstu	Numero de matricula del estudiante
        $matriculaInicia=$this->docuMatricula->fecha_inicia; //matriculaInicia	Fecha de inicio del estudiante
        $matriSede=$this->docuMatricula->sede->name; // matriSede Nombre d ela sede donde se matriculo.
        $matriSector=$this->docuMatricula->sede->sector->name; //Ciudad donde se matricula
        $matriState=$this->docuMatricula->sede->sector->state->name; // matriState Departamento en el que se matriculo.
        $nombreEstud=strtoupper($this->docuMatricula->alumno->name); //nombreEstu	Nombre del estudiante
        $documEstu=number_format($this->docuMatricula->alumno->documento, 0, '.', '.'); //documentoEstu	documento del estudiante
        $tipodocu=strtoupper($this->docuMatricula->alumno->perfil->tipo_documento); //tipodocuEstu	tipo de documento del estudiante
        $docuExpedi=strtoupper($this->docuMatricula->alumno->perfil->tipo_documento); //docuExpedi	expedición del documento
        $horaDocu=$this->docuMatricula->control->ciclo->name; //horario explicito en el nombre del ciclo respectivo
        $direEstu=ucwords($this->docuMatricula->alumno->perfil->direccion); //direccionEstu	direccion del estudiante
        $ciudadEstu=ucwords($this->docuMatricula->alumno->perfil->state->name); //ciudadEstu	ciudad del estudiante
        $telEstu=$this->docuMatricula->alumno->perfil->celular; //telefonoEstu	teléfono del estudiante
        $curso=strtoupper($this->docuMatricula->curso->name); //cursoEstu	Curso al que se inscribio estudiante
        $cursoDuraHor=$this->docuMatricula->curso->duracion_horas; // cursoDuraHor Duración horas del curso.
        $cursoDuraMes=$this->docuMatricula->curso->duracion_meses; // cursoDuraMes duración meses del curso.
        $valorMatricula="$ ".number_format($this->docuMatricula->valor, 0, '.', '.');
        $valorMatLetras=ucwords($formatterES->format($this->docuMatricula->valor))." Pesos M/L.";
        $nit=config('instituto.nit'); //nitInsti	NIT del poliandino
        $empresa=strtoupper(config('instituto.nombre_empresa')); //nombreInsti	Nombre del poliandino
        $rl=strtoupper(config('instituto.representante_legal')); //rlInsti	Representante Legal del poliandino
        $docRl=config('instituto.documento_rl'); //rldocInsti	Documento Representante Legal del poliandino
        $dirEmp=ucwords(config('instituto.direccion')); //dirInsti	dirección legal del poliandino
        $telEmp=config('instituto.telefono'); //telInsti	teléfono legal del poliandino
        $deuda=$this->deuda; // deuda Valor de la mora.
        $fechaCrea=Carbon::now(); //FEcha en que se genera el documento
        $fopaCuot=$this->cuotas; // formaCuotas Cantidad de cuotas pactadas
        $fopaVrMes="$ ".number_format($this->valormes, 0, '.', '.'); // formaValorMensual Valor de la cuotamensual
        $fopaLetVrMes=ucwords($formapagoES->format($this->valormes))." Pesos M/L."; //formaValorMensualLetras Valor de la cuota mensual en letras

        $this->reemplazo=[
            $matriculaId,
            $matriculaInicia,
            $matriSede,
            $matriSector,
            $matriState,
            $nombreEstud,
            $documEstu,
            $horaDocu,
            $tipodocu,
            $docuExpedi,
            $direEstu,
            $ciudadEstu,
            $telEstu,
            $curso,
            $cursoDuraHor,
            $cursoDuraMes,
            $valorMatricula,
            $valorMatLetras,
            $nit,
            $empresa,
            $rl,
            $docRl,
            $dirEmp,
            $telEmp,
            $deuda,
            $fechaCrea,
            $fopaCuot,
            $fopaVrMes,
            $fopaLetVrMes

        ];

        $this->docFiltra();
    }

    public function docFiltra(){

        foreach ($this->detalles as $value) {

            $dato=$value->contenido;

            $datos = str_replace($this->palabras, $this->reemplazo, $dato);

            $nuevo=[
                'contenido'     =>$datos,
                'tipo'          =>$value->tipodetalle,
                'documento_id'  =>$value->documento_id
            ];

            array_push($this->impresion, $nuevo);

        }
    }
}
