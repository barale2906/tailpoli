<?php

namespace Database\Seeders;

use App\Models\Academico\Grupo;
use App\Models\Academico\Matricula;
use App\Models\Academico\Modulo;
use App\Models\Clientes\Pqrs;
use App\Models\Configuracion\Documento;
use App\Models\User;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MatriculaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $row = 0;

        if(($handle = fopen(public_path() . '/csv/12-enrollments-27.csv', 'r')) !== false) {

                while(($data = fgetcsv($handle, 26000, ';')) !== false) {

                    $row++;

                    try {

                        $data[1]=date("Y-m-d");
                        $data[11]=date("Y-m-d H:i:s");
                        $data[12]=date("Y-m-d H:i:s");

                        DB::table('matriculas')->insert([
                            'id'            => intval($data[0]),
                            'fecha_inicia'  => $data[1],
                            'medio'         => strtolower($data[2]),
                            'nivel'         => strtolower($data[3]),
                            'valor'         => $data[4],
                            //'metodo'        => strtolower($data[5]),
                            'status'        => intval($data[5]),
                            'configpago'    => 0,
                            'alumno_id'     => intval($data[6]),
                            'curso_id'      => intval($data[7]),
                            'comercial_id'  => intval($data[8]),
                            'creador_id'    => intval($data[9]),
                            'sede_id'       => intval($data[10]),
                            'created_at'    => $data[11],
                            'updated_at'    => $data[12]
                        ]);

                        $modCar=Grupo::where('id', intval($data[13]))->first();
                        $creador=User::where('id',intval($data[9]))->select('id', 'name')->first();

                        // Cargar modulos
                        $modulos=Modulo::where('curso_id', intval($data[7]))
                                            ->where('status', true)
                                            ->orderBy('name')
                                            ->get();

                        foreach ($modulos as $value) {
                            DB::table('matricula_modulos_aprobacion')
                                ->insert([
                                    'matricula_id'  =>intval($data[0]),
                                    'alumno_id'     =>intval($data[6]),
                                    'modulo_id'     =>$value->id,
                                    'name'          =>$value->name,
                                    'dependencia'   =>$value->dependencia,
                                    'observaciones' =>$data[11]." ".$creador->name." Genera el registro.",
                                    'created_at'    =>$data[11],
                                    'updated_at'    =>$data[12]
                                ]);

                                //Identificar y cargar los grupos por modulo

                                if($value->id===$modCar->modulo_id){

                                    DB::table('grupo_matricula')
                                        ->insert([
                                            'grupo_id'      =>intval($data[13]),
                                            'matricula_id'  =>intval($data[0]),
                                            'created_at'    =>$data[11],
                                            'updated_at'    =>$data[12]
                                        ]);


                                    //Cargar estudiante al grupo
                                    DB::table('grupo_user')
                                        ->insert([
                                            'grupo_id'      =>intval($data[13]),
                                            'user_id'       =>intval($data[6]),
                                            'created_at'    =>$data[11],
                                            'updated_at'    =>$data[12]
                                        ]);



                                    //Sumar usuario al grupo

                                    $tot=$modCar->inscritos+1;

                                    $modCar->update([
                                        'inscritos'=>$tot
                                    ]);

                                }else{

                                    //Sumar usuario al grupo
                                    $inscritos=Grupo::where('modulo_id', $value->id)
                                                    ->first();

                                    DB::table('grupo_matricula')
                                        ->insert([
                                            'grupo_id'      =>$inscritos->id,
                                            'matricula_id'  =>intval($data[0]),
                                            'created_at'    =>$data[11],
                                            'updated_at'    =>$data[12]
                                        ]);

                                    //Cargar estudiante al grupo
                                    DB::table('grupo_user')
                                        ->insert([
                                            'grupo_id'      =>$inscritos->id,
                                            'user_id'       =>intval($data[6]),
                                            'created_at'    =>$data[11],
                                            'updated_at'    =>$data[12]
                                        ]);

                                    $tot=$inscritos->inscritos+1;

                                    $inscritos->update([
                                        'inscritos'=>$tot
                                    ]);
                                }
                        }

                        // Cargar documentos
                        $documentos=Documento::where('status', 3)
                                            ->whereIn('tipo', ['contrato','pagare','cartapagare','actaPago','comproCredito','comproEntrega','gastocertifinal','matricula'])
                                            ->orderBy('titulo')
                                            ->select('id')
                                            ->get();

                        //Asignar documentos base
                        foreach ($documentos as $value) {
                            DB::table('documento_matricula')
                                    ->insert([
                                        'documento_id'   =>$value->id,
                                        'matricula_id'   =>intval($data[0]),
                                        'created_at'     =>$data[11],
                                        'updated_at'     =>$data[12]
                                    ]);
                        }

                        // Cargar PQRS
                        Pqrs::create([
                            'estudiante_id' =>intval($data[6]),
                            'gestion_id'    =>$creador->id,
                            'fecha'         =>$data[11],
                            'tipo'          =>4,
                            'observaciones' =>'ACÁDEMICO: Matricula N°: '.intval($data[0]).' ----- ',
                            'status'        =>4
                        ]);

                    }catch(Exception $exception){
                        Log::info('Line: ' . $row . ' 12-enrollments-27 with error: ' . $exception->getMessage());
                    }
                }
        }

        fclose($handle);


        /* Matricula::create([
            'medio' => 'google',
            'nivel'=>'pre grado',
            'anula'=>'',
            'anula_user'=>'',
            'valor'=>'1250000',
            'metodo'=>'contado',
            'alumno_id'=>'2',
            'comercial_id'=>'124',
            'creador_id'=>'125',
            'curso_id'=>1,
            'sede_id'=>1,
            'configpago'=>1
        ]);

        Matricula::create([
            'medio' => 'amigo',
            'nivel'=>'bachiller',
            'anula'=>'',
            'anula_user'=>'',
            'valor'=>'1300000',
            'metodo'=>'contado',
            'alumno_id'=>'4',
            'comercial_id'=>'125',
            'creador_id'=>'124',
            'curso_id'=>2,
            'sede_id'=>2,
            'configpago'=>3
        ]); */
    }
}
