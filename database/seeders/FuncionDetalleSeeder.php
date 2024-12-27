<?php

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class FuncionDetalleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $row = 0;

        if(($handle = fopen(public_path() . '/csv/38-Funcionariosdeta.csv', 'r')) !== false) {

                while(($data = fgetcsv($handle, 26000, ';')) !== false) {

                    $row++;

                    try {



                    }catch(Exception $exception){
                        Log::info('Line: ' . $row . ' 38-Funcionariosdeta with error: ' . $exception->getMessage());
                    }
                }
            }

            fclose($handle);
    }
}
