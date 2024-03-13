<?php

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RecibopagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $row = 0;

        if(($handle = fopen(public_path() . '/csv/14-recibos.csv', 'r')) !== false) {

            while(($data = fgetcsv($handle, 26000, ';')) !== false) {

                $row++;

                try {

                    $observaciones=strtolower($data[4])." ----- ".now()." Creado por ERP POLIANDINO. ----- ";

                    $data[1]=date("Y-m-d");
                    $data[9]=date("Y-m-d H:i:s");
                    $data[10]=date("Y-m-d H:i:s");

                    DB::table('recibo_pagos')->insert([
                        'numero_recibo'     =>intval($data[0]),
                        'origen'            =>true,
                        'fecha'             =>$data[1],
                        'valor_total'       =>$data[2],
                        'medio'             =>strtolower($data[3]),
                        'observaciones'     =>$observaciones,
                        'sede_id'           =>intval($data[5]),
                        'creador_id'        =>intval($data[6]),
                        'paga_id'           =>intval($data[7]),
                        'status'            =>intval($data[8]),
                        'created_at'        =>$data[9],
                        'updated_at'        =>$data[10],
                    ]);

                }catch(Exception $exception){
                    Log::info('Line: ' . $row . ' 14-recibos with error: ' . $exception->getMessage());
                }
            }
        }

        fclose($handle);
    }
}
