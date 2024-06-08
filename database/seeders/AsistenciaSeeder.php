<?php

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Academico\Asistencia;
use App\Models\Academico\Control;
use App\Models\User;

class AsistenciaSeeder extends Seeder
{

    public $actual;
    public $grupo_id;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // profesor, grupo, ciclo, estudiante, fecha

        $row = 0;

        if(($handle = fopen(public_path() . '/csv/33_asistencia.csv', 'r')) !== false) {

                while(($data = fgetcsv($handle, 26000, ';')) !== false) {

                    $row++;

                    try {

                        $this->grupo_id=intval($data[1]);

                        $esta=Asistencia::where('profesor_id', intval($data[0]))
                                            ->where('grupo_id', intval($data[1]))
                                            ->where('ciclo_id', intval($data[2]))
                                            ->first();

                        // Verificar si exite la asistencia con estos parámetros
                        if($esta){
                            $this->actual=$esta;
                        }else{
                            $this->actual=Asistencia::create([
                                                        'profesor_id'   => intval($data[0]),
                                                        'grupo_id'      => intval($data[1]),
                                                        'ciclo_id'      => intval($data[2]),
                                                        'registros'     => 0
                                                    ]);
                        }

                        //Cargar los estudiantes con estos parámetros
                        $alumnos=User::query()
                                        ->with(['alumnosGrupo'])
                                        ->when($this->grupo_id, function($qu){
                                            return $qu->where('status', true)
                                                    ->whereHas('alumnosGrupo', function($q){
                                                        $q->where('grupo_id', $this->grupo_id);
                                                    });
                                        })
                                        ->select('id', 'name')
                                        ->orderBy('name')
                                        ->get();

                        if($alumnos){
                            foreach ($alumnos as $value) {
                                $estab=DB::table('asistencia_detalle')
                                            ->where('asistencia_id', $this->actual->id)
                                            ->where('alumno_id', $value->id)
                                            ->count();

                                if($estab===0){
                                    DB::table('asistencia_detalle')
                                        ->insert([
                                            'asistencia_id' =>$this->actual->id,
                                            'alumno_id'     =>$value->id,
                                            'alumno'        =>$value->name,
                                            'profesor_id'   =>$this->actual->profesor_id,
                                            'profesor'      =>$this->actual->profesor->name,
                                            'grupo_id'      =>$this->actual->grupo_id,
                                            'grupo'         =>$this->actual->grupo->name,
                                            'created_at'    =>now(),
                                            'updated_at'    =>now()
                                        ]);
                                }
                            }
                        }else{
                            $alumno=User::find(intval($data[3]));
                            DB::table('asistencia_detalle')
                                        ->insert([
                                            'asistencia_id' =>$this->actual->id,
                                            'alumno_id'     =>$alumno->id,
                                            'alumno'        =>$alumno->name,
                                            'profesor_id'   =>$this->actual->profesor_id,
                                            'profesor'      =>$this->actual->profesor->name,
                                            'grupo_id'      =>$this->actual->grupo_id,
                                            'grupo'         =>$this->actual->grupo->name,
                                            'created_at'    =>now(),
                                            'updated_at'    =>now()
                                        ]);
                        }


                        // Verificar si existe la fecha cargada
                        $fecha=DB::table('asistencia_registro')
                                    ->where('asistencia_id', $this->actual->id)
                                    ->where('fecha_clase', $data[4])
                                    ->count();

                        if($fecha===0){
                            $this->actual->update([
                                'registros'     =>$this->actual->registros+1
                            ]);

                            //Crgar fecha
                            DB::table('asistencia_registro')
                                ->insert([
                                    'asistencia_id' => $this->actual->id,
                                    'fecha_clase'   => $data[4],
                                    'created_at'    => now(),
                                    'updated_at'    => now()
                                ]);
                        }


                        //Cargar asistencia
                        $registro=DB::table('asistencia_registro')
                                    ->where('asistencia_id',$this->actual->id)
                                    ->where('fecha_clase', $data[4])
                                    ->first();


                        $estadetalle=DB::table('asistencia_detalle')
                                    ->where('asistencia_id', $this->actual->id)
                                    ->where('alumno_id', intval($data[3]))
                                    ->select('id')
                                    ->first();

                        //Verificar si ya existe el registro
                        $ya=DB::table('asistencia_detalle_registro')
                                ->where('Asistencia_detalle_id', $estadetalle->id)
                                ->where('fecha_asis', $registro->fecha_clase)
                                ->where('registro_asistencia_id', $registro->id)
                                ->count();


                        if($ya===0){
                            DB::table('asistencia_detalle_registro')
                                ->insert([
                                    'Asistencia_detalle_id'     => $estadetalle->id,
                                    'fecha_asis'                => $registro->fecha_clase,
                                    'registro_asistencia_id'    => $registro->id,
                                    'created_at'                => now(),
                                    'updated_at'                => now()
                                ]);

                            //Registrar control
                            Control::where('estudiante_id', intval($data[3]))
                                    ->where('status', true)
                                    ->update([
                                        'ultima_asistencia'=>$registro->fecha_clase,
                                    ]);
                        }


                    }catch(Exception $exception){
                        Log::info('Line: ' . $row . ' 33_asistencia.csv with error: ' . $exception->getMessage().' codigo: '.$exception->getLine());
                    }
                }
        }

        fclose($handle);
    }
}
