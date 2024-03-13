<?php

namespace Database\Seeders;

use App\Models\Academico\Modulo;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Type\Integer;

class GruponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $row = 0;
        $numero=6000;

        if(($handle = fopen(public_path() . '/csv/10-grupos-nuevos-23.csv', 'r')) !== false) {

                while(($data = fgetcsv($handle, 26000, ';')) !== false) {

                    $row++;

                    try {
                        //Obtener los modulos del curso
                        $modulo=Modulo::where('id', intval($data[3]))->first();
                        $modulos=Modulo::where('curso_id', $modulo->curso_id)
                                        ->where('status', true)
                                        ->orderBy('name')
                                        ->get();


                        //Cargar los demás modulos
                        foreach ($modulos as $value) {
                            $name=strtolower($data[1])." --- ".$value->name;
                            if($value->id === intval($data[3])){


                                DB::table('grupos')->insert([
                                    'id'                => $numero,
                                    'name'              => $name,
                                    'quantity_limit'    => intval($data[2]),
                                    'modulo_id'         => intval($data[3]),
                                    'sede_id'           => intval($data[4]),
                                    'profesor_id'       => intval($data[5]),
                                    'created_at'        => now(),
                                    'updated_at'        => now(),
                                ]);

                            }
                            if($value->id !== intval($data[3])){
                                    //Cargar primer modulo
                                    DB::table('grupos')->insert([
                                        'id'                => $numero,
                                        'name'              => $name,
                                        'quantity_limit'    => intval($data[2]),
                                        'modulo_id'         => $value->id,
                                        'sede_id'           => intval($data[4]),
                                        'profesor_id'       => intval($data[5]),
                                        'created_at'        => now(),
                                        'updated_at'        => now(),
                                    ]);
                            }
                            $numero++;
                        }

                    }catch(Exception $exception){
                        Log::info('Line: ' . $row . ' 10-grupos-nuevos-23.csv with error: ' . $exception->getMessage());
                    }


                }
        }

        fclose($handle);
    }
}
