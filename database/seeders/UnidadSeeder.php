<?php

namespace Database\Seeders;

use App\Models\Academico\Unidade;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class UnidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $row = 0;

        if(($handle = fopen(public_path() . '/csv/39-unidades.csv', 'r')) !== false) {

            while(($data = fgetcsv($handle, 26000, ';')) !== false) {

                $row++;

                try {
                    Unidade::create([
                        'id'=>intval($data[0]),
                        'modulo_id'=>intval($data[1]),
                        'name'=>strtolower($data[2]),
                        'duracion'=>intval($data[3]),
                    ]);

                }catch(Exception $exception){
                    Log::info('Line: ' . $row . ' 39-unidades with error: ' . $exception->getMessage().' código: '.$exception->getCode().' linea: '.$exception->getLine());
                }
            }
        }

        fclose($handle);
    }
}
