<?php

namespace Database\Seeders;

use App\Models\Academico\Curso;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CursoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $row = 0;

        if(($handle = fopen(public_path() . '/csv/3-courses-12.csv', 'r')) !== false) {

                while(($data = fgetcsv($handle, 26000, ';')) !== false) {

                    $row++;

                    try {

                        $creado=new Carbon($data[7]);
                        $crea=$creado->format('Y-m-d H:i:s');

                        $actualiza=new Carbon($data[8]);
                        $actua=$actualiza->format('Y-m-d H:i:s');

                        DB::table('cursos')->insert([
                            'id'            => intval($data[0]),
                            'name'          => strtolower($data[1]),
                            'slug'          => strtolower($data[2]),
                            'tipo'          => strtolower($data[3]),
                            'duracion_horas'=> $data[4],
                            'duracion_meses'=> $data[5],
                            'status'        => intval($data[6]),
                            'created_at'    => $data[7],
                            'updated_at'    => $data[8]
                        ]);

                    }catch(Exception $exception){
                        Log::info('Line: ' . $row . ' 3-courses-12 with error: ' . $exception->getMessage());
                    }
                }
            }

            fclose($handle);

            /* Curso::create([
                'name'              =>'Técnico Mantenimiento De Motocicletas',
                'slug'              =>'TecManMoto',
                'tipo'              =>'técnico',
                'duracion_horas'    =>159,
                'duracion_meses'   =>6
            ]);

            Curso::create([
                'name'              =>'Técnico En Mecánica De Vehículos Automotores',
                'slug'              =>'TecMecVehiAuto',
                'tipo'              =>'técnico',
                'duracion_horas'    =>159,
                'duracion_meses'   =>6
            ]);

            Curso::create([
                'name'              =>'Instalación De Car Audio Y Alarmas',
                'slug'              =>'InsCarAudAla',
                'tipo'              =>'práctico',
                'duracion_horas'    =>159,
                'duracion_meses'   =>6
            ]);
            Curso::create([
                'name'              =>'Inyección Electrónica Y Alto Cilindraje De Motos',
                'slug'              =>'inyEleAltCiliMoto',
                'tipo'              =>'práctico',
                'duracion_horas'    =>159,
                'duracion_meses'   =>6
            ]);*/
    }

}
