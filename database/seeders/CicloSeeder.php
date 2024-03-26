<?php

namespace Database\Seeders;

use App\Models\Academico\Ciclogrupo;
use App\Models\Academico\Grupo;
use Carbon\Carbon;
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

        if(($handle = fopen(public_path() . '/csv/18-ciclos.csv', 'r')) !== false) {

                while(($data = fgetcsv($handle, 26000, ';')) !== false) {

                    $row++;

                    try {

                        $ini=new Carbon($data[4]);
                        $fin=$ini->addMonths($data[5]);

                        //Crear ciclo
                        DB::table('ciclos')->insert([
                            'id'            => $data[0],
                            'sede_id'       => $data[1],
                            'curso_id'      => $data[2],
                            'name'          => strtolower($data[3]),
                            'inicia'        => $data[4],
                            'finaliza'      => $fin,
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
                                'fecha_fin'      => $fin,
                            ]);
                        }

                    }catch(Exception $exception){
                        Log::info('Line: ' . $row . ' 18-ciclos with error: ' . $exception->getMessage());
                    }

                }
        }

        fclose($handle);
    }
}
