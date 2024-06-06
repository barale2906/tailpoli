<?php

namespace Database\Seeders;

use App\Models\Academico\Grupo;
use App\Models\Academico\Nota;
use App\Models\User;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $row = 0;

        if(($handle = fopen(public_path() . '/csv/25-notas.csv', 'r')) !== false) {

            while(($data = fgetcsv($handle, 26000, ';')) !== false) {

                $row++;

                try {

                    //Buscamos grupo
                    $grupo=Grupo::where('sede_id', intval($data[0]))
                                    //->where('profesor_id', intval($data[1]))
                                    ->where('modulo_id', intval($data[2]))
                                    ->inRandomOrder()
                                    ->first();

                    //profesor
                    $profe=User::find(intval($data[1]));

                    //Estudiante
                    $estu=User::find(intval($data[3]));

                    $observaciones="ERP POLIANDINO, cargada por seeder para el profesor: ".$profe->name;

                    if($grupo){
                        $nota=Nota::where('profesor_id', intval($data[1]))
                                    ->where('grupo_id', $grupo->id)
                                    ->first();

                        if($nota){
                            DB::table('notas_detalle')
                                ->insert([
                                    'nota_id'       =>$nota->id,
                                    'alumno_id'     =>intval($data[3]),
                                    'alumno'        =>$estu->name,
                                    'profesor_id'   =>intval($data[1]),
                                    'profesor'      =>$profe->name,
                                    'grupo_id'      =>$grupo->id,
                                    'grupo'         =>$grupo->name,
                                    'acumulado'     =>intval($data[4]),
                                    'observaciones' =>$observaciones,
                                    'nota1'         =>intval($data[4]),
                                    'porcen1'       =>intval($data[4]),
                                    'nota2'         =>null,
                                    'porcen2'       =>null,
                                    'nota3'         =>null,
                                    'porcen3'       =>null,
                                    'nota4'         =>null,
                                    'porcen4'       =>null,
                                    'nota5'         =>null,
                                    'porcen5'       =>null,
                                    'nota6'         =>null,
                                    'porcen6'       =>null,
                                    'nota7'         =>null,
                                    'porcen7'       =>null,
                                    'nota8'         =>null,
                                    'porcen8'       =>null,
                                    'nota9'         =>null,
                                    'porcen9'       =>null,
                                    'nota10'        =>null,
                                    'porcen10'      =>null,
                                    'created_at'    =>$data[5],
                                    'updated_at'    =>$data[6]
                                ]);
                        }else{
                            $nuev=Nota::create([
                                                'profesor_id'   =>intval($data[1]),
                                                'grupo_id'      =>$grupo->id,
                                                'descripcion'   =>$observaciones,
                                                'registros'     =>1,
                                                'nota1'         =>'final',
                                                'porcen1'       =>100
                                            ]);


                            DB::table('notas_detalle')
                                            ->insert([
                                                'nota_id'       =>$nuev->id,
                                                'alumno_id'     =>intval($data[3]),
                                                'alumno'        =>$estu->name,
                                                'profesor_id'   =>intval($data[1]),
                                                'profesor'      =>$profe->name,
                                                'grupo_id'      =>$grupo->id,
                                                'grupo'         =>$grupo->name,
                                                'acumulado'     =>intval($data[4]),
                                                'observaciones' =>$observaciones,
                                                'nota1'         =>intval($data[4]),
                                                'porcen1'       =>intval($data[4]),
                                                'nota2'         =>null,
                                                'porcen2'       =>null,
                                                'nota3'         =>null,
                                                'porcen3'       =>null,
                                                'nota4'         =>null,
                                                'porcen4'       =>null,
                                                'nota5'         =>null,
                                                'porcen5'       =>null,
                                                'nota6'         =>null,
                                                'porcen6'       =>null,
                                                'nota7'         =>null,
                                                'porcen7'       =>null,
                                                'nota8'         =>null,
                                                'porcen8'       =>null,
                                                'nota9'         =>null,
                                                'porcen9'       =>null,
                                                'nota10'        =>null,
                                                'porcen10'      =>null,
                                                'created_at'    =>$data[5],
                                                'updated_at'    =>$data[6]
                                            ]);
                        }
                    }else{
                        Log::info('Line: ' . $row . ' no habia grupo ');
                    }

                }catch(Exception $exception){
                    Log::info('Line: ' . $row . ' 25-notas with error: ' . $exception->getMessage().' código: '.$exception->getCode().' linea: '.$exception->getLine());
                }
            }
        }

        fclose($handle);
    }
}
