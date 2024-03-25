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

        if(($handle = fopen(public_path() . '/csv/16-grupos-finales.csv', 'r')) !== false) {

                while(($data = fgetcsv($handle, 26000, ';')) !== false) {

                    $row++;

                    try {
                        //Obtener los modulos del curso
                        $modulos=Modulo::where('curso_id', intval($data[0]))
                                        ->where('status', true)
                                        ->inRandomOrder()
                                        ->get();

                        $primero=strtolower($data[3])." --- ".strtolower($data[2]);

                        DB::table('grupos')->insert([
                            'id'                => $numero,
                            'name'              => $primero,
                            'quantity_limit'    => 100,
                            'modulo_id'         => intval($data[1]),
                            'sede_id'           => intval($data[4]),
                            'profesor_id'       => intval($data[5]),
                            'created_at'        => now(),
                            'updated_at'        => now(),
                        ]);


                        //Cargar los demás modulos
                        foreach ($modulos as $value) {

                            $name=strtolower($data[3])." --- ".$value->slug;

                            if($value->id !== intval($data[1])){

                                    DB::table('grupos')->insert([
                                        'id'                => $numero,
                                        'name'              => $name,
                                        'quantity_limit'    => 100,
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
                        Log::info('Line: ' . $row . ' 16-grupos-finales with error: ' . $exception->getMessage());
                    }


                }
        }

        fclose($handle);
    }
}
