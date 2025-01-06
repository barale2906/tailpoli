<?php

namespace Database\Seeders;

use App\Models\Academico\Unidtema;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class UniTemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $row = 0;

        if(($handle = fopen(public_path() . '/csv/40-temas.csv', 'r')) !== false) {

            while(($data = fgetcsv($handle, 26000, ';')) !== false) {

                $row++;

                try {
                    Unidtema::create([
                        'unidade_id'=>intval($data[0]),
                        'name'=>strtolower($data[1]),
                        'duracion'=>intval($data[2]),
                    ]);

                }catch(Exception $exception){
                    Log::info('Line: ' . $row . ' 40-temas with error: ' . $exception->getMessage().' código: '.$exception->getCode().' linea: '.$exception->getLine());
                }
            }
        }

        fclose($handle);
    }
}
