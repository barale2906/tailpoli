<?php

namespace Database\Seeders;

use App\Models\Academico\Control;
use App\Models\Academico\Matricula;
use App\Models\Financiera\Cartera;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class GraduadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $row = 0;

        if(($handle = fopen(public_path() . '/csv/graduados.csv', 'r')) !== false) {

                while(($data = fgetcsv($handle, 90000, ';')) !== false) {

                    $row++;

                    try {

                        //Estado en control
                        $esta=Control::where('matricula_id', intval($data[0]))
                                        ->count();

                        if($esta>0){
                            Control::where('matricula_id', intval($data[0]))
                                    ->update([
                                        'status_est'    =>4
                                    ]);
                        }else{
                            Log::info('matricula: ' . intval($data[0]) . ' no esta la matricula en CONTROL.');
                        }

                        //Estado en cartera
                        $car=Cartera::where('matricula_id',intval($data[0]))
                                        ->count();

                        if($car>0){
                            Cartera::where('matricula_id',intval($data[0]))
                                    ->update([
                                        'status_est'    =>4,
                                        'estado_cartera_id'=>6,
                                        'status'=>6
                                    ]);
                        }else{
                            Log::info('matricula: ' . intval($data[0]) . ' no esta la matricula en CARTERA.');
                        }

                        //Matriculas
                        $matr=Matricula::where('id', intval($data[0]))
                                        ->count();

                        if($matr>0){
                            Matricula::where('id', intval($data[0]))
                                        ->update([
                                            'status_est'    =>4
                                        ]);
                        }else{
                            Log::info('matricula: ' . intval($data[0]) . ' no esta la matricula en MATRICULA.');
                        }



                    }catch(Exception $exception){
                        Log::info('Line: ' . $row . ' graduados.csv with error: ' . $exception->getMessage());
                    }
                }
        }
    }
}
