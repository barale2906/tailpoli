<?php

namespace App\Traits;

use App\Models\Configuracion\Docugrado;
use App\Models\Configuracion\Documento;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use NumberFormatter;

trait docugradosTrait
{

    public $diplomas;
    public $cuerpodocu=[];
    public $componentes;
    public $palab=[];
    public $reempla=[];
    public $docugrado;
    public $orientacion;
    public $tamano;
    public $documento;
    public $margensup=35;
    public $titulotec;
    public $temas;
    public $ciudad;
    public $fechagrado;
    public $folio;
    public $libroregistro;
    public $acta;
    public $fechacta;
    public $fechalarga;



    public function iniciaregistros($acta,$doc){

        $this->documento=Documento::find($doc);
        $this->configpag();


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
            $this->titulobten();
            $this->cargaPalabras();
        }
    }

    public function titulobten(){
        if($this->docugrado->tipo_curso===1){
            $titulo=DB::table('titulotecnico')
                        ->where('curso_id',$this->docugrado->matricula->curso->id)
                        ->where('tipo',1)
                        ->first();

            $this->titulotec=$titulo->descripcion;

            $this->temas=DB::table('titulotecnico')
                            ->where('curso_id',$this->docugrado->matricula->curso->id)
                            ->where('tipo',2)
                            ->get();
        }else{
            $this->titulotec=$this->docugrado->titulo;
        }

        $this->ciudad=$this->docugrado->matricula->sede->sector->name;
        $fechagrado=Carbon::create($this->docugrado->fecha_grado);
        $this->fechagrado=$fechagrado->format('d') . ' de ' . $fechagrado->locale('es')->monthName . ' de ' . $fechagrado->format('Y');
        $fechacta=Carbon::create($this->docugrado->fecha_acta);
        $this->fechacta=$fechacta->format('d') . ' días del mes de ' . $fechacta->locale('es')->monthName . ' de ' . $fechacta->format('Y');
        $this->folio=$this->docugrado->folio_acta;
        $this->libroregistro=$this->docugrado->libro;
        $this->acta=$this->docugrado->acta;
        $this->diplomas=$this->docugrado->tipo_curso;

        $this->creafechalarga();
    }

    public function creafechalarga(){
        $fechalarga = Carbon::create($this->docugrado->fecha_acta);

        // Crea un formateador para convertir números a palabras en español
        $formatter = new NumberFormatter('es', NumberFormatter::SPELLOUT);

        // Extrae y convierte el día y el año a palabras
        $diaPalabra = $formatter->format($fechalarga->day);
        $mesPalabra = $fechalarga->locale('es')->monthName;
        $anioPalabra = $formatter->format($fechalarga->year);

        // Construye la fecha en el formato requerido
        $this->fechalarga = ucfirst("$diaPalabra ({$fechalarga->day}) de $mesPalabra de $anioPalabra ({$fechalarga->year})");

    }

    public function configpag(){

        // Configurar orientación
        if($this->documento->orientacion===1){
            $this->orientacion='portrait';
        }
        if($this->documento->orientacion===2){
            $this->orientacion='landscape';
        }

        // Configurar tamaño
        if($this->documento->tamano===1){
            $this->tamano='letter';
        }
        if($this->documento->tamano===2){ //oficio
            $this->tamano=[0, 0, 612, 1008];
        }

        // Configurar margen superior
        if($this->documento->tipo==="diploma"){
            $this->margensup=100;
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
            'nombreInsti',
            'gradnumacta',
            'gradactafec',
            'gradfec',
            'gradcangrads',
            'gradinialu',
            'gradalufin',
            'gradfol',
            'gradtit',
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
        $docuregistrado=$this->docugrado->matricula->alumno->perfil->tipo_documento; //tipodocuEstu	tipo de documento del estudiante
        if($docuregistrado=='tarjeta identidad'){
            $tipodocuEstu="TI";
        }else{
            $tipodocuEstu="CC";
        }
        $docuExpedi=strtoupper($this->docugrado->matricula->alumno->perfil->lugar_expedicion); //docuExpedi	expedición del documento
        $cursoEstu=strtoupper($this->docugrado->matricula->curso->name); //cursoEstu	Curso al que se inscribio estudiante
        $nitInsti=config('instituto.nit'); //nitInsti	NIT del poliandino
        $nombreInsti=strtoupper(config('instituto.nombre_empresa')); //nombreInsti	Nombre del poliandino
        $fechacta=Carbon::create($this->docugrado->fecha_acta);
        $fechactatexto=$fechacta->format('d') . ' de ' . $fechacta->locale('es')->monthName . ' de ' . $fechacta->format('Y');
        $fechagrado=Carbon::create($this->docugrado->fecha_grado);
        $fechagradotexto=$fechagrado->format('d') . ' de ' . $fechagrado->locale('es')->monthName . ' de ' . $fechagrado->format('Y');

        $gradnumacta=$this->docugrado->acta;
        $gradactafec=$fechactatexto;
        $gradfec=$fechagradotexto;
        $gradcangrads=$this->docugrado->alumnos_graduados;
        $gradinialu=$this->docugrado->alumno_inicia;
        $gradalufin=$this->docugrado->alumno_finaliza;
        $gradfol=$this->docugrado->folio_acta;
        $gradtit=$this->docugrado->titulo;

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
            $gradnumacta,
            $gradactafec,
            $gradfec,
            $gradcangrads,
            $gradinialu,
            $gradalufin,
            $gradfol,
            $gradtit,
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
