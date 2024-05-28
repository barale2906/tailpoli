<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Models\Financiera\Cartera;

class SincroCarteraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $row = 0;

        if(($handle = fopen(public_path() . '/csv/31-actualiza-cartera.csv', 'r')) !== false) {

            while(($data = fgetcsv($handle, 26000, ';')) !== false) {

                $row++;

                try {
                    Cartera::where('id', intval($data[0]))
                            ->update([
                                'fecha_real'    =>$data[1],
                                'saldo'         =>$data[2],
                                'status'        =>intval($data[3]),
                                'updated_at'    =>$data[4]
                            ]);

                }catch(Exception $exception){
                    Log::info('Line: ' . $row . ' 31-actualiza-cartera with error: ' . $exception->getMessage().' código: '.$exception->getCode().' linea: '.$exception->getLine());
                }
            }
        }

        fclose($handle);
    }
}
