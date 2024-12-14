<?php

namespace App\Traits;

use App\Models\Academico\Ciclogrupo;
use App\Models\Academico\Control;
use App\Models\Academico\Horario;
use App\Models\Academico\Matricula;
use App\Models\Academico\Modulo;
use App\Models\Configuracion\Documento;
use App\Models\Financiera\Cartera;
use App\Models\Financiera\ConfiguracionPago;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use NumberFormatter;

trait RenderDocTrait
{
    public $docuTipo;
    public $docuMatricula;
    public $controlele;
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
    public $moruda;
    public $edad;
    public $plantilla;
    public $diaprimer;
    public $mesprimer;
    public $anoprimer;
    public $horarios;


    //public function docubase($id, $tipo, $ori=null){
    public function docubase($id, $doc){

        $this->docuTipo=Documento::whereId($doc)->first();

        $plantilla=DB::table('tipo_documentos')
                            ->where('name',$this->docuTipo->tipo)
                            ->select('plantilla')
                            ->first();

        $this->plantilla=$plantilla->plantilla;

        $this->docuMatricula=Matricula::whereId($id)->first();
        $this->controlele=Control::where('matricula_id',$id)->first();

        $this->docuDetalle();
        $this->formaPago();
        $this->modulosCurso();
        $this->creahorarios();
    }

    public function creahorarios(){

        DB::table('apoyo_recibo')
            ->where('id_creador', Auth::user()->id)
            ->where('tipo','horario')
            ->delete();

        $this->primerGrupo=Ciclogrupo::where('ciclo_id', $this->controlele->ciclo_id)->orderBy('fecha_inicio', 'ASC')->first();

        $horarios=Horario::where('grupo_id', $this->primerGrupo->grupo_id)
                                ->orderBy('hora', 'ASC')
                                ->get();

        foreach ($horarios as $value) {
            $reg=DB::table('apoyo_recibo')
                    ->where('id_creador', Auth::user()->id)
                    ->where('tipo','horario')
                    ->where('concepto',$value->dia)
                    ->first();

            if($reg){
                DB::table('apoyo_recibo')
                    ->where('id_creador', Auth::user()->id)
                    ->where('tipo','horario')
                    ->where('concepto',$value->dia)
                    ->update([
                        'valor'=>$reg->valor+1,
                    ]);
            }else{
                DB::table('apoyo_recibo')
                    ->insert([
                        'id_creador'    =>Auth::user()->id,
                        'tipo'          =>'horario',
                        'concepto'      =>$value->dia,
                        'hora'          =>$value->hora,
                        'valor'         =>1
                    ]);
            }
        }

        if($horarios){
            //$this->horarios=$horarios;
            $this->horarios=DB::table('apoyo_recibo')
                                ->where('id_creador', Auth::user()->id)
                                ->where('tipo','horario')
                                ->get();
        }else{
            $this->horarios=0;
        }


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
                                    ->whereNotIn('estado_cartera_id',[5,7])
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
                $this->moruda=$this->moruda+$value->saldo;
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
            'matriGen',
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
            'nombreInsti',
            'rlInsti',
            'rldocInsti',
            'dirInsti',
            'telInsti',
            'moruda',
            'fechaCrea',
            'fopaCuot',
            'fopaVrMes',
            'fopaLetVrMes',
            'fopaprimerdia',
            'fopaprimermes',
            'fopaprimeryear',
            'fopamatricula',
            'fopaletrasmatricula'
        ];

        $this->equivale();

    }

    public function equivale(){
        $formaPago=ConfiguracionPago::find($this->docuMatricula->configpago);
        if($formaPago->cuotas>0){
            $this->cuotas=$formaPago->cuotas;
            $this->valormes=$formaPago->valor_cuota;
            $primero=Cartera::where('responsable_id', $this->docuMatricula->alumno_id)
                                ->where('observaciones', 'like', '%Cuota N°: 1%')
                                ->first();

            $pago=Carbon::create($primero->fecha_pago);
            $this->diaprimer=$pago->day;
            $this->mesprimer=$pago->month;
            $this->anoprimer=$pago->year;
        }else{
            $this->cuotas=0;
            $this->valormes=0;
            $this->diaprimer=0;
            $this->mesprimer=0;
            $this->anoprimer=0;
        }

        $formatterES = new NumberFormatter("es", NumberFormatter::SPELLOUT);
        $formapagoES = new NumberFormatter("es", NumberFormatter::SPELLOUT);
        $formamatriculaES = new NumberFormatter("es", NumberFormatter::SPELLOUT);
        $matricrea= Carbon::create($this->docuMatricula->created_at);

        $matriculaEstu=$this->docuMatricula->id; //matriculaEstu	Numero de matricula del estudiante
        $matriculaInicia=$this->docuMatricula->fecha_inicia; //matriculaInicia	Fecha de inicio del estudiante
        $matriSede=$this->docuMatricula->sede->name; // matriSede Nombre d ela sede donde se matriculo.
        $matriSector=$this->docuMatricula->sede->sector->name; //Ciudad donde se matricula
        $matriState=$this->docuMatricula->sede->sector->state->name; // matriState Departamento en el que se matriculo.
        $matriGen=$formattedDate = $matricrea->format('d') . ' días del mes de ' . $matricrea->locale('es')->monthName . ' de ' . $matricrea->format('Y'); // Fecha de creación de la matricula para los contratos
        $nombreEstu=strtoupper($this->docuMatricula->alumno->name); //nombreEstu	Nombre del estudiante
        $documentoEstu=number_format($this->docuMatricula->alumno->documento, 0, '.', '.'); //documentoEstu	documento del estudiante
        $tipodocuEstu=strtoupper($this->docuMatricula->alumno->perfil->tipo_documento); //tipodocuEstu	tipo de documento del estudiante
        $docuExpedi=strtoupper($this->docuMatricula->alumno->perfil->lugar_expedicion); //docuExpedi	expedición del documento
        $horaDocu=$this->controlele->ciclo->name; //horario explicito en el nombre del ciclo respectivo
        $direccionEstu=ucwords($this->docuMatricula->alumno->perfil->direccion); //direccionEstu	direccion del estudiante
        $ciudadEstu=ucwords($this->docuMatricula->alumno->perfil->state->name); //ciudadEstu	ciudad del estudiante
        $telefonoEstu=$this->docuMatricula->alumno->perfil->celular; //telefonoEstu	teléfono del estudiante
        $cursoEstu=strtoupper($this->docuMatricula->curso->name); //cursoEstu	Curso al que se inscribio estudiante
        $cursoDuraHor=$this->docuMatricula->curso->duracion_horas; // cursoDuraHor Duración horas del curso.
        $cursoDuraMes=$this->docuMatricula->curso->duracion_meses; // cursoDuraMes duración meses del curso.
        $valorMatricula="$ ".number_format($this->docuMatricula->valor, 0, '.', '.');
        $valorMatLetras=ucwords($formatterES->format($this->docuMatricula->valor))." Pesos M/L.";
        $nitInsti=config('instituto.nit'); //nitInsti	NIT del poliandino
        $nombreInsti=strtoupper(config('instituto.nombre_empresa')); //nombreInsti	Nombre del poliandino
        $rlInsti=strtoupper(config('instituto.representante_legal')); //rlInsti	Representante Legal del poliandino
        $rldocInsti=config('instituto.documento_rl'); //rldocInsti	Documento Representante Legal del poliandino
        $dirInsti=ucwords(config('instituto.direccion')); //dirInsti	dirección legal del poliandino
        $telInsti=config('instituto.telefono'); //telInsti	teléfono legal del poliandino
        $moruda=$this->moruda; // moruda Valor de la mora.
        $fechaCrea=Carbon::now(); //FEcha en que se genera el documento
        $fopaCuot=$this->cuotas; // formaCuotas Cantidad de cuotas pactadas
        $fopaVrMes="$ ".number_format($this->valormes, 0, '.', '.'); // formaValorMensual Valor de la cuotamensual
        $fopaLetVrMes=ucwords($formapagoES->format($this->valormes))." Pesos M/L."; //formaValorMensualLetras Valor de la cuota mensual en letras
        $fopaprimerdia=$this->diaprimer; //Día del primer pago de cartera
        $fopaprimermes=$this->mesprimer; // Mes del primer pago de cartera
        $fopaprimeryear=$this->anoprimer; // Año del primer pago de cartera
        $fopamatricula="$ ".number_format($formaPago->valor_matricula, 0, '.', '.'); // Valor a pagar por matricula
        $fopaletrasmatricula=ucwords($formamatriculaES->format($formaPago->valor_matricula))." Pesos M/L."; //Valor en letras del costo de matricula

        $this->reemplazo=[
            $matriculaEstu,
            $matriculaInicia,
            $matriSede,
            $matriSector,
            $matriState,
            $matriGen,
            $nombreEstu,
            $documentoEstu,
            $tipodocuEstu,
            $docuExpedi,
            $horaDocu,
            $direccionEstu,
            $ciudadEstu,
            $telefonoEstu,
            $cursoEstu,
            $cursoDuraHor,
            $cursoDuraMes,
            $valorMatricula,
            $valorMatLetras,
            $nitInsti,
            $nombreInsti,
            $rlInsti,
            $rldocInsti,
            $dirInsti,
            $telInsti,
            $moruda,
            $fechaCrea,
            $fopaCuot,
            $fopaVrMes,
            $fopaLetVrMes,
            $fopaprimerdia,
            $fopaprimermes,
            $fopaprimeryear,
            $fopamatricula,
            $fopaletrasmatricula,
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
