<?php

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PalabraNewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $row = 0;

        if(($handle = fopen(public_path() . '/csv/30-palabrasadicionales.csv', 'r')) !== false) {

            while(($data = fgetcsv($handle, 26000, ';')) !== false) {

                $row++;

                try {
                    DB::table('palabras_clave')
                        ->insert([
                            'palabra'=>$data[0],
                            'descripcion'=>strtolower($data[1]),
                            'created_at'=>now(),
                            'updated_at'=>now(),
                        ]);

                }catch(Exception $exception){
                    Log::info('Line: ' . $row . ' 30-palabrasadicionales with error: ' . $exception->getMessage());
                }
            }
        }

        fclose($handle);
    }
}
