<?php

namespace Database\Seeders;

use App\Models\Academico\Ciclogrupo;
use App\Models\Academico\Grupo;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CicloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $row = 0;

        if(($handle = fopen(public_path() . '/csv/10a-ciclos.csv', 'r')) !== false) {

                while(($data = fgetcsv($handle, 26000, ';')) !== false) {

                    $row++;

                    try {

                        $data[4]=date("Y-m-d");
                        $data[5]=date("Y-m-d");

                        //Crear ciclo
                        DB::table('ciclos')->insert([
                            'id'            => $data[0],
                            'sede_id'       => $data[1],
                            'curso_id'      => $data[2],
                            'name'          => strtolower($data[3]),
                            'inicia'        => $data[4],
                            'finaliza'      => $data[5],
                            'jornada'       => $data[6],
                            'desertado'     => $data[7],
                            'created_at'    => now(),
                            'updated_at'    => now(),
                        ]);

                        $grupos=Grupo::where('name','like', "%".strtolower($data[3])."%")
                                    ->get();

                        foreach ($grupos as $value) {

                            Ciclogrupo::create([
                                'ciclo_id'       => $data[0],
                                'grupo_id'       => $value->id,
                                'fecha_inicio'   => $data[4],
                                'fecha_fin'      => $data[5],
                            ]);
                        }

                    }catch(Exception $exception){
                        Log::info('Line: ' . $row . ' 10a-ciclos.csv with error: ' . $exception->getMessage());
                    }

                }
        }

        fclose($handle);
    }
}
