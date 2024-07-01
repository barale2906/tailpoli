<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SincroCarteraMatriAnuladaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $row = 0;

        if(($handle = fopen(public_path() . '/csv/34_sincro_anula_cartera.csv', 'r')) !== false) {

                while(($data = fgetcsv($handle, 26000, ';')) !== false) {

                    try {

                        //Actualizar fechas de pago reales cartera
                        Cartera::where('matricula_id', $data[0])
                                ->update([
                                    'status'=>false
                                ]);


                    }catch(Exception $exception){
                        Log::info('Line: ' . $row . ' 34_sincro_anula_cartera with error: ' . $exception->getMessage().' codigo: '.$exception->getLine());
                    }
                    $row++;
                }
        }

        fclose($handle);
    }
}
