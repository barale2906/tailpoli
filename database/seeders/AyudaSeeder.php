<?php

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AyudaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $row = 0;


        if(($handle = fopen(public_path() . '/csv/22-ayudas.csv', 'r')) !== false) {

                while(($data = fgetcsv($handle, 26000, ';')) !== false) {

                    $row++;

                    try {

                        DB::table('ayudas')->insert([
                            'modulo'        => strtolower($data[0]),
                            'titulo'        => strtolower($data[1]),
                            'descripcion'   => strtolower($data[2]),
                            'ruta'          => $data[3],
                            'youtube'       => $data[4],
                            'created_at'    => now(),
                            'updated_at'    => now(),
                        ]);

                    }catch(Exception $exception){
                        Log::info('Line: ' . $row . ' 22-ayudas with error: ' . $exception->getMessage());
                    }
                }
        }

        fclose($handle);
    }
}
