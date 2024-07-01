<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Financiera\Cartera;

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

                        $observaciones=now().' ERP poliandino, ajuste de cartera por matricula anulada. ----- ';

                        $item=Cartera::where('matricula_id', $data[0])->get();

                        foreach ($item as $value) {
                            Cartera::where('id', $value->id)
                                    ->update([
                                        'status' => false,
                                        'observaciones' =>$observaciones.$value->observaciones,
                                    ]);
                        }


                    }catch(Exception $exception){
                        Log::info('Line: ' . $row . ' 34_sincro_anula_cartera with error: ' . $exception->getMessage().' codigo: '.$exception->getLine());
                    }
                    $row++;
                }
        }

        fclose($handle);
    }
}
