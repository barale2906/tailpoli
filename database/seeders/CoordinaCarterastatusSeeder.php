<?php

namespace Database\Seeders;

use App\Models\Financiera\Cartera;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class CoordinaCarterastatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $row = 0;

        if(($handle = fopen(public_path() . '/csv/coordina_cartera.csv', 'r')) !== false) {

                while(($data = fgetcsv($handle, 260000, ';')) !== false) {

                    $row++;

                    try {

                        Log::info('Cartera: ' . intval($data[0]) . ' Coordinando status.');

                        Cartera::where('id', intval($data[0]))->update([
                            //'observaciones'=>$data[1],
                            'status'=>$data[2],
                            'estado_cartera_id'=>$data[2],
                        ]);


                    }catch(Exception $exception){
                        Log::info('Line: ' . $row . ' coordina_cartera.csv: ' . $exception->getMessage());
                    }
                }
        }
    }
}
