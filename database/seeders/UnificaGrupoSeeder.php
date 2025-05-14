<?php

namespace Database\Seeders;

use App\Models\Academico\Acaplan;
use App\Models\Academico\Asistencia;
use App\Models\Academico\Ciclo;
use App\Models\Academico\Ciclogrupo;
use App\Models\Academico\Control;
use App\Models\Academico\Cronograma;
use App\Models\Academico\Grupo;
use App\Models\Academico\Horario;
use App\Models\Academico\Matricula;
use App\Models\Academico\Nota;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UnificaGrupoSeeder extends Seeder
{
    public $grupo;
    public $horario;
    public $asistencia;
    public $matricula;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //identificar los grupos para obtener los ciclos asignados a cada ciclo (De las matriculas mas recientes)
        $grupos=Grupo::where('status',1)
                        ->where('inscritos','>',0)
                        ->orderBy('sede_id','ASC')
                        ->orderBy('modulo_id','ASC')
                        ->orderBy('inscritos','DESC')
                        ->get();

        foreach ($grupos as $grupo) {
            $this->coincidencias($grupo);
        }

    }

    private function coincidencias($grupo){
        //Buscar los grupos que coincidan con: sede_id, profesor_id, modulo_id, jornada, horario.sede_id, horario.dia y horario.hora ordenando por el que mas inscritos tenga para los recientemente creados.

        $this->horario="";

        $this->grupo=Grupo::find($grupo->id);

        $horas=Horario::where('grupo_id',$grupo->id)
                        ->orderBy('dia','ASC')
                        ->orderBy('hora','ASC')
                        ->get();

        foreach ($horas as $item) {
            $this->horario=$this->horario." ini dia: ".$item->dia." --- Hora: ".$item->hora." fin. ";
        }

        $this->recalculagrupo();

    }

    private function recalculagrupo(){
        if($this->grupo->inscritos>0){
            $aplican=Grupo::where('id', '!=',$this->grupo->id)
                            ->where('status', 1)
                            ->where('inscritos','>',0)
                            ->where('sede_id',$this->grupo->sede_id)
                            ->where('profesor_id',$this->grupo->profesor_id)
                            ->where('modulo_id',$this->grupo->modulo_id)
                            ->where('jornada',$this->grupo->jornada)
                            ->get();

            if($aplican){
                foreach ($aplican as $value) {
                    $this->comparahorarios($value);
                }
            }

            Log::info('GRUPOS SIMILARES: Grupo ELEGIDO: ' . $this->grupo->id.' Cantidad encontrada: '.$aplican->count());

            $this->updategrupoelegido();
        }
    }

    private function updategrupoelegido(){
        //Actualizar cantidades a ciclos, grupos, asistencias, Crear el registro de asistencia a los que no lo tengan
        $estudiantes = DB::table('grupo_user')
                            ->where('grupo_id', $this->grupo->id)
                            ->get();

        $totalEstudiantes = $estudiantes->count();

        $curso=$this->grupo->modulo->curso->id;

        $this->grupo->update([
            'inscritos' =>$totalEstudiantes
        ]);

        Log::info('GRUPO REGISTRADOS: Grupo:' . $this->grupo->id.' Estudiantes Registrados: '.$totalEstudiantes);

        foreach ($estudiantes as $value) {
            $this->matricula=Matricula::where('alumno_id',$value->user_id)
                                    ->where('curso_id',$curso)
                                    ->where('status',1)
                                    ->first();

            if($this->matricula){
                $control=Control::where('estudiante_id',$value->user_id)
                                    ->where('matricula_id',$this->matricula->id)
                                    ->first();

                    $esta=Asistencia::where('grupo_id', $this->grupo->id)
                                    ->where('ciclo_id', $control->ciclo_id)
                                    ->first();

                    if($esta){
                        $this->asistencia=$esta;
                        $this->cargarEstudiante();
                    }else{
                        $this->nuevo($control);
                    }

                    $this->updateCiclo($control->ciclo_id);
                    $this->cantidadAsistencia();
            }else{
                Log::info('GRUPO REGISTRADOS: updategrupoelegido NO TIENE MATRICULA ACTIVA: '.$this->grupo->id.' Ciclo: '.$curso);
            }


        }

    }

    private function cantidadAsistencia(){
        $total=DB::table('asistencia_detalle')->where('asistencia_id', $this->asistencia->id)->count();

        Asistencia::where('id',$this->asistencia->id)
                    ->update([
                        'registros' =>intval($total)
                    ]);

        Log::info('ASISTENCIA REGISTRADOS: Asistencia:' . $this->asistencia->id.' Estudiantes Registrados: '.$total);
    }

    private function updateCiclo($id){

        $total=Control::where('status',1)
                        ->where('ciclo_id',$id)
                        ->count();

        if($total){
            Ciclo::where('id',$id)
            ->update([
                'registrados'    =>intval($total)
            ]);

            Log::info('CICLO REGISTRADOS: ciclo:' . $id.' Estudiantes Registrados: '.$total);

        }else{
            Log::info('CICLO REGISTRADOS: NO ENCONTRO REGISTRO PARA EL CICLO:' . $id);
        }
    }

    private function cargarEstudiante(){

        $registrado=DB::table('asistencia_detalle')
                        ->where('asistencia_id',$this->asistencia->id)
                        ->where('alumno_id',$this->matricula->alumno->id)
                        ->where('grupo_id',$this->asistencia->grupo_id)
                        ->first();

        if($registrado){

        }else{
            DB::table('asistencia_detalle')
                ->insert([
                    'asistencia_id' =>$this->asistencia->id,
                    'alumno_id'     =>$this->matricula->alumno->id,
                    'alumno'        =>$this->matricula->alumno->name,
                    'profesor_id'   =>$this->asistencia->profesor_id,
                    'profesor'      =>$this->asistencia->profesor->name,
                    'grupo_id'      =>$this->grupo->id,
                    'grupo'         =>$this->grupo->name,
                    'created_at'    =>now(),
                    'updated_at'    =>now()
                ]);
        }
        Log::info('ESTUDIANTE ASISTENCIA: Grupo ELEGIDO: ' . $this->grupo->id.' Estudiante Registrado: '.$this->matricula->alumno_id);
    }

    private function nuevo($control){ //nuevo registro de asistencia
        $this->asistencia=Asistencia::create([
                                    'profesor_id'   => $this->grupo->profesor_id,
                                    'grupo_id'      => $this->grupo->id,
                                    'ciclo_id'      => $control->ciclo_id,
                                    'registros'     => 0
                                ]);

        $this->cargarEstudiante();
    }

    private function comparahorarios($gru){

        $esthorario="";
        $comparado="No coincide";

        $horas=Horario::where('grupo_id',$gru->id)
                        ->orderBy('dia','ASC')
                        ->orderBy('hora','ASC')
                        ->get();

        foreach ($horas as $item) {
            $esthorario=$esthorario." ini dia: ".$item->dia." --- Hora: ".$item->hora." fin. ";
        }

        if($this->horario===$esthorario){
            $comparado="COINCIDE";
            $this->migrar($gru);
        }

        Log::info('HORARIO COMPARADO: Horario base: ' . $this->horario.' Horario grupo: '.$esthorario.' REsultado: '.$comparado.' Grupo comparado: '.$gru->id);
    }

    //Asignar todos los estudiantes al que tenga la mayor cantidad de inscritos. Inactivar el que se le eliminen los estudiantes.
    private function migrar($grusalida){
        //Asignar el grupo al ciclo respectivo.
        $ciclogrupos=Ciclogrupo::where('grupo_id',$grusalida->id)->get();

        foreach ($ciclogrupos as $reg) {
            try {
                Ciclogrupo::where('id',$reg->id)
                            ->update([
                                'grupo_id'      => $this->grupo->id,
                                'updated_at'    => now()
                            ]);
                Log::info('CICLOGRUPO: Grupo inactivado: ' . $grusalida->id.' registro modificado: '.$reg->id .' grupo seleccionado: '.$this->grupo->id );

            } catch(Exception $exception){
                Log::info('CICLCOGRUPO: grupo fallido: ' . $reg->id . ' detalle del error: ' . $exception->getMessage().' código: '.$exception->getCode().' linea: '.$exception->getLine(). ' grupo seleccionado: '.$this->grupo->id);
            }
        }

        $this->updateMatricula($grusalida);
        //Cargar el estudiante a asistencia_detalle cuando no este registrado


    }

    private function updateMatricula($grup){
        //Asignar las matriculas al grupo respectivo (grupo_matricula: no eliminar actualizar)
        $grupomatriculas=DB::table('grupo_matricula')->where('grupo_id',$grup->id)->get();

        foreach ($grupomatriculas as $reg) {
            try {
                DB::table('grupo_matricula')->where('id',$reg->id)
                            ->update([
                                'grupo_id'      => $this->grupo->id,
                                'updated_at'    => now()
                            ]);
                Log::info('GRUPOMATRICULA: Grupo inactivado: ' . $grup->id.' registro modificado: '.$reg->id . ' grupo seleccionado: '.$this->grupo->id );

            } catch(Exception $exception){
                Log::info('GRUPOMATRICULA: grupo fallido: ' . $reg->id . ' detalle del error: ' . $exception->getMessage().' código: '.$exception->getCode().' linea: '.$exception->getLine(). ' grupo seleccionado: '.$this->grupo->id);
            }
        }

        $this->updateuser($grup);
    }

    private function updateuser($grup){
        //Asignar el estudiante al grupo_user, ojo no eliminar, modificar el existente cambiando el grupo.
        $grupousers=DB::table('grupo_user')->where('grupo_id',$grup->id)->get();

        foreach ($grupousers as $reg) {
            try {
                DB::table('grupo_user')->where('id',$reg->id)
                            ->update([
                                'grupo_id'      => $this->grupo->id,
                                'updated_at'    => now()
                            ]);
                Log::info('GRUPOUSUARIO: Grupo inactivado: ' . $grup->id.' registro modificado: '.$reg->id . ' grupo seleccionado: '.$this->grupo->id );

            } catch(Exception $exception){
                Log::info('GRUPOUSUARIO: grupo fallido: ' . $reg->id . ' detalle del error: ' . $exception->getMessage().' código: '.$exception->getCode().' linea: '.$exception->getLine(). ' grupo seleccionado: '.$this->grupo->id);
            }
        }

        $this->updateAsistencia($grup);
    }

    private function updateAsistencia($grup){
        //Si estan en otros grupos unificar y traer las asistencias (asistencias, asistencia_detalle,).
        $grupoasistencia=Asistencia::where('grupo_id',$grup->id)->get();

        foreach ($grupoasistencia as $reg) {
            try {
                Asistencia::where('id',$reg->id)
                            ->update([
                                'grupo_id'      => $this->grupo->id,
                                'updated_at'    => now()
                            ]);

                DB::table('asistencia_detalle')->where('asistencia_id',$reg->id)
                            ->update([
                                'grupo_id'      => $this->grupo->id,
                                'grupo'         => $this->grupo->name,
                                'updated_at'    => now()
                            ]);
                Log::info('ASISTENCIA: Grupo inactivado: ' . $grup->id.' registro modificado: '.$reg->id . ' grupo seleccionado: '.$this->grupo->id );

            } catch(Exception $exception){
                Log::info('ASISTENCIA: grupo fallido: ' . $reg->id . ' detalle del error: ' . $exception->getMessage().' código: '.$exception->getCode().' linea: '.$exception->getLine(). ' grupo seleccionado: '.$this->grupo->id);
            }
        }

        $this->updateNota($grup);
    }

    private function updateNota($grup){
        //Cambiar grupos de calificaciones: notas, notas_detalle
        $gruponota=Nota::where('grupo_id',$grup->id)->get();

        foreach ($gruponota as $reg) {
            try {
                Nota::where('id',$reg->id)
                            ->update([
                                'grupo_id'      => $this->grupo->id,
                                'updated_at'    => now()
                            ]);

                DB::table('notas_detalle')->where('nota_id',$reg->id)
                            ->update([
                                'grupo_id'      => $this->grupo->id,
                                'grupo'         => $this->grupo->name,
                                'updated_at'    => now()
                            ]);
                Log::info('NOTAS: Grupo inactivado: ' . $grup->id.' registro modificado: '.$reg->id . ' grupo seleccionado: '.$this->grupo->id );

            } catch(Exception $exception){
                Log::info('NOTAS: grupo fallido: ' . $reg->id . ' detalle del error: ' . $exception->getMessage().' código: '.$exception->getCode().' linea: '.$exception->getLine(). ' grupo seleccionado: '.$this->grupo->id);
            }
        }

        $this->updateCronograma($grup);
    }

    private function updateCronograma($grup){
        //Actualizar Cronogramas
        $grupocronograma=Cronograma::where('grupo_id',$grup->id)->get();

        foreach ($grupocronograma as $reg) {
            try {
                Cronograma::where('id',$reg->id)
                            ->update([
                                'grupo_id'      => $this->grupo->id,
                                'updated_at'    => now()
                            ]);

                Log::info('CRONOGRAMA: Grupo inactivado: ' . $grup->id.' registro modificado: '.$reg->id . ' grupo seleccionado: '.$this->grupo->id );

            } catch(Exception $exception){
                Log::info('CRONOGRAMA: grupo fallido: ' . $reg->id . ' detalle del error: ' . $exception->getMessage().' código: '.$exception->getCode().' linea: '.$exception->getLine(). ' grupo seleccionado: '.$this->grupo->id);
            }
        }

        $this->updateplanes($grup);
    }

    private function updateplanes($grup){
        //Actualizar acaplans
        $grupoplan=Acaplan::where('grupo_id',$grup->id)->get();

        foreach ($grupoplan as $reg) {
            try {
                Acaplan::where('id',$reg->id)
                            ->update([
                                'grupo_id'      => $this->grupo->id,
                                'updated_at'    => now()
                            ]);

                Log::info('PLAN ACADEMICO: Grupo inactivado: ' . $grup->id.' registro modificado: '.$reg->id . ' grupo seleccionado: '.$this->grupo->id );

            } catch(Exception $exception){
                Log::info('PLAN ACADEMICO: grupo fallido: ' . $reg->id . ' detalle del error: ' . $exception->getMessage().' código: '.$exception->getCode().' linea: '.$exception->getLine(). ' grupo seleccionado: '.$this->grupo->id);
            }
        }

        $this->inactivgrupo($grup);
    }

    private function inactivgrupo($grup){
        Grupo::where('id', $grup->id)
                ->update([
                    'status'    =>0,
                    'inscritos' =>0,
                    'updated_at'    => now()
                ]);

        Log::info('FINALIZA GRUPO: Grupo inactivado: ' . $grup->id.' grupo seleccionado: '.$this->grupo->id );
    }
}
