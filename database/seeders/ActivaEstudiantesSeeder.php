<?php

namespace Database\Seeders;

use App\Models\Academico\Control;
use App\Models\Academico\Matricula;
use App\Models\Financiera\Cartera;
use App\Models\User;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class ActivaEstudiantesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $row = 0;

        if(($handle = fopen(public_path() . '/csv/Activa_estudiante.csv', 'r')) !== false) {

                while(($data = fgetcsv($handle, 26000, ';')) !== false) {

                    try {

                        $estudiante=User::where('documento',$data[0])->first();

                        $crt=Control::where('estudiante_id',$estudiante->id)->get();

                        if($crt){
                            foreach ($crt as $value) {
                                Control::where('id',$value->id)->update([
                                    'status_est'=>1
                                ]);
                            }
                        }

                        //Actualizar Matricula
                        Matricula::where('alumno_id',$estudiante->id)
                                ->update([
                                    'status_est'=>1
                                ]);

                        //Actualizar Cartera
                        Cartera::where('responsable_id', $estudiante->id)
                                ->update([
                                    'status_est'=>1
                                ]);



                    }catch(Exception $exception){
                        Log::info('Line: ' . $row . ' Activa_estudiante with error: '.$data[0]."--" . $exception->getMessage().' codigo: '.$exception->getLine());
                    }
                    $row++;
                }
        }

        fclose($handle);
    }
}
