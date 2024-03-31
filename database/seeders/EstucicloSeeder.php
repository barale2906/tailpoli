<?php

namespace Database\Seeders;

use App\Models\Academico\Ciclo;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class EstucicloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(($handle = fopen(public_path() . '/csv/21-Actualiza-estudiantes-ciclo.csv', 'r')) !== false) {

            $row = 0;

            while(($data = fgetcsv($handle, 26000, ';')) !== false) {

                $row++;

                try {

                    $ciclo=Ciclo::find(intval($data[1]));

                    //Sumar usuario al ciclo
                    $tota=$ciclo->registrados+1;

                    $ciclo->update([
                        'registrados'=>$tota
                    ]);


                }catch(Exception $exception){
                    Log::info('Line: ' . $row . ' 21-Actualiza-estudiantes-ciclo with error: ' . $exception->getMessage());
                }


            }
        }

    fclose($handle);
    }
}
