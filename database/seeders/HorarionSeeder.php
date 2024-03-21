<?php

namespace Database\Seeders;

use App\Models\Academico\Curso;
use App\Models\Academico\Grupo;
use App\Models\Academico\Horario;
use App\Models\Academico\Modulo;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class HorarionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $row = 0;

        if(($handle = fopen(public_path() . '/csv/10-horario-grupo.csv', 'r')) !== false) {

                while(($data = fgetcsv($handle, 26000, ';')) !== false) {

                    $row++;

                    try {

                        $grupos=Grupo::where('name','like', "%".strtolower($data[1])."%")
                                    ->get();

                        $dias=array();

                        if($data[6]==="1"){
                            array_push($dias,'lunes');
                        }
                        if($data[7]==="1"){
                            array_push($dias,'martes');
                        }
                        if($data[8]==="1"){
                            array_push($dias,'miercoles');
                        }
                        if($data[9]==="1"){
                            array_push($dias,'jueves');
                        }
                        if($data[10]==="1"){
                            array_push($dias,'viernes');
                        }
                        if($data[11]==="1"){
                            array_push($dias,'sabado');
                        }
                        if($data[12]==="1"){
                            array_push($dias,'domingo');
                        }

                        foreach ($grupos as $value) {
                            //Definir los días según el array

                            foreach ($dias as $val) {

                                //Calcular horas
                                $cant=intval($data[4]);
                                $ini=new Carbon($data[3]);;

                                for ($i=0; $i < $cant; $i++) {
                                    $horac=$ini->addHours($i);
                                    $hora=$horac->roundMinutes(60)->format('H:i:s');

                                    Horario::create([
                                        'sede_id'       =>intval($data[2]),
                                        'area_id'       =>4,
                                        'grupo'         =>$value->name,
                                        'grupo_id'      =>$value->id,
                                        'tipo'          =>false,
                                        'periodo'       =>true,
                                        'dia'           =>$val,
                                        'hora'          =>$hora,
                                    ]);
                                }


                            }


                        }


                    }catch(Exception $exception){
                        Log::info('Line: ' . $row . ' 10-horario-grupo.csv with error: ' . $exception->getMessage());
                    }

                }
        }

        fclose($handle);
    }
}
