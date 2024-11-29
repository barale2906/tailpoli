<?php

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class titulotecnicoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $row = 0;

        if(($handle = fopen(public_path() . '/csv/37-titulotecnico.csv', 'r')) !== false) {

            while(($data = fgetcsv($handle, 26000, ';')) !== false) {

                $row++;

                try {
                    DB::table('titulotecnico')
                        ->insert([
                            'curso_id'=>intval($data[0]),
                            'descripcion'=>$data[1],
                            'tipo'=>intval($data[2]),
                            'created_at'=>now(),
                            'updated_at'=>now(),
                        ]);

                }catch(Exception $exception){
                    Log::info('Line: ' . $row . ' 37-titulotecnico with error: ' . $exception->getMessage().' código: '.$exception->getCode().' linea: '.$exception->getLine());
                }
            }
        }

        fclose($handle);
    }
}
