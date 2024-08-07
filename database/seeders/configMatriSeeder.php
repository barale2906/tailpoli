<?php

namespace Database\Seeders;

use App\Models\Academico\Ciclo;
use App\Models\Academico\Control;
use App\Models\Academico\Grupo;
use App\Models\Academico\Matricula;
use App\Models\Financiera\Cartera;
use App\Models\Financiera\ConfiguracionPago;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class configMatriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $row = 0;

        if(($handle = fopen(public_path() . '/csv/34-config_matricula.csv', 'r')) !== false) {

                while(($data = fgetcsv($handle, 26000, ';')) !== false) {

                    $row++;

                    try {

                        //Buscar configuracion de pago
                        if(intval($data[2])===0){
                            $config=ConfiguracionPago::where('curso_id', intval($data[1]))
                                                    ->where('cuotas', 0)
                                                    ->inRandomOrder()
                                                    ->first();

                            //Actualizar matricula
                            Matricula::where('id', intval($data[0]))
                            ->update([
                                'configpago'=>$config->id
                            ]);


                        }else{
                            $config=ConfiguracionPago::where('curso_id', intval($data[1]))
                                                    ->where('cuotas', '>', 0)
                                                    ->inRandomOrder()
                                                    ->first();

                            //Actualizar matricula
                            Matricula::where('id', intval($data[0]))
                            ->update([
                                'configpago'=>$config->id
                            ]);

                            //Cuotas cartera
                            $carte=Cartera::where('matricula_id', intval($data[0]))
                                            ->where('concepto_pago_id', 2)
                                            ->orderBy('id', 'ASC')
                                            ->first();

                            $carte->update([
                                'observaciones' => $carte->observaciones.' ----- Cuota N°: 1'
                            ]);
                        }

                        //Verificar que tenga ciclo
                        $esta=Control::where('matricula_id', intval($data[0]))
                                        ->count();

                        if($esta>0){
                            Log::info('matricula_id: ' . intval($data[0]) . ' ya tiene ciclo y control.');
                        }else{
                            $matricula=Matricula::find(intval($data[0]));
                            $cartera=Cartera::where('matricula_id', intval($data[0]))
                                            ->first();

                            $fecha1=Carbon::create($matricula->fecha_inicia)->subDays(7);
                            $fecha2=Carbon::create($matricula->fecha_inicia)->addDays(7);

                            /* $ciclo=Ciclo::whereBetween('inicia', [$fecha1,$fecha2])
                                            ->where('sede_id', $cartera->sede_id)
                                            ->where('curso_id', $matricula->curso_id)
                                            ->inRandomOrder()
                                            ->first(); */

                            $ciclo=Ciclo::where('sede_id', $cartera->sede_id)
                                            ->where('curso_id', $matricula->curso_id)
                                            ->inRandomOrder()
                                            ->first();

                            if($ciclo->ciclogrupos){
                                // Cargar modulos
                                foreach ($ciclo->ciclogrupos as $value) {

                                    DB::table('grupo_matricula')
                                        ->insert([
                                            'grupo_id'      =>$value->grupo->id,
                                            'matricula_id'  =>$matricula->id,
                                            'created_at'    =>now(),
                                            'updated_at'    =>now(),
                                        ]);

                                    //Cargar estudiante al grupo
                                    DB::table('grupo_user')
                                        ->insert([
                                            'grupo_id'      =>$value->grupo->id,
                                            'user_id'       =>$matricula->alumno_id,
                                            'created_at'    =>now(),
                                            'updated_at'    =>now(),
                                        ]);



                                    //Sumar usuario al grupo
                                    $inscritos=Grupo::find($value->grupo->id);

                                    $tot=$inscritos->inscritos+1;

                                    $inscritos->update([
                                        'inscritos'=>$tot
                                    ]);

                                    DB::table('matricula_modulos_aprobacion')
                                        ->insert([
                                            'matricula_id'  =>$matricula->id,
                                            'alumno_id'     =>$matricula->alumno_id,
                                            'modulo_id'     =>$value->grupo->modulo_id,
                                            'name'          =>$value->grupo->modulo->name,
                                            'dependencia'   =>$value->grupo->modulo->dependencia,
                                            'observaciones' =>now()." ERP POLIANDINO",
                                            'created_at'    =>now(),
                                            'updated_at'    =>now(),
                                        ]);
                                }
                            }


                            //Sumar usuario al ciclo
                            $tota=$ciclo->registrados+1;

                            $ciclo->update([
                                'registrados'=>$tota
                            ]);

                            //Cargar control
                            Control::create([
                                'inicia'        =>$ciclo->inicia,
                                'matricula_id'  =>$matricula->id,
                                'ciclo_id'      =>$ciclo->id,
                                'sede_id'       =>$ciclo->sede_id,
                                'estudiante_id' =>$matricula->alumno_id,
                            ]);
                        }


                    }catch(Exception $exception){
                        Log::info('Line: ' . $row . ' 34-config_matricula with error: ' . $exception->getMessage());
                    }

                }
        }

        fclose($handle);
    }
}
