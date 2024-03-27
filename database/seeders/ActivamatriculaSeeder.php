<?php

namespace Database\Seeders;

use App\Models\Academico\Ciclo;
use App\Models\Academico\Control;
use App\Models\Academico\Matricula;
use App\Models\Academico\Modulo;
use App\Models\Financiera\Cartera;
use App\Models\Financiera\ReciboPago;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ActivamatriculaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(($handle = fopen(public_path() . '/csv/19-activa-matricula.csv', 'r')) !== false) {

            $row = 0;

            while(($data = fgetcsv($handle, 26000, ';')) !== false) {

                $row++;

                try {

                    //Seleccionar matricula
                    $matricula=Matricula::find(intval($data[0]));

                    $ciclo=Ciclo::find(intval($data[1]));

                    //Modulos
                    $modulos=Modulo::where('curso_id', intval($data[2]))
                                    ->where('status', true)
                                    ->get();

                    //Cargar modulos
                    foreach ($modulos as $value) {
                        DB::table('matricula_modulos_aprobacion')
                            ->insert([
                                'matricula_id'  =>$matricula->id,
                                'alumno_id'     =>$matricula->alumno_id,
                                'modulo_id'     =>$value->id,
                                'name'          =>$value->name,
                                'dependencia'   =>$value->dependencia,
                                'observaciones' =>now()." ERP POLIANDINO Genera el registro.",
                                'created_at'    =>now(),
                                'updated_at'    =>now(),
                            ]);
                    }

                    //Actualizar status de la matricula

                    $matricula->update([
                        'status'=>true
                    ]);


                    //Actualizar registro de último pago
                    $ultimopago=ReciboPago::where('paga_id', $matricula->alumno_id)
                                            ->where('origen', true)
                                            ->select('fecha')
                                            ->orderBy('fecha', 'DESC')
                                            ->first();

                    //Obtener mora
                    $ayer=Carbon::today()->subDay();

                    $mora=Cartera::where('fecha_pago', '<=', $ayer)
                                    ->where('saldo', '>', 0)
                                    ->sum('saldo');


                    if($mora>0){
                        $estadomora=5;
                    }else{
                        $estadomora=2;
                    }

                    Control::create([
                        'inicia'        =>$ciclo->inicia,
                        'matricula_id'  =>$matricula->id,
                        'ciclo_id'      =>$ciclo->id,
                        'sede_id'       =>$ciclo->sede_id,
                        'estudiante_id' =>$matricula->alumno_id,
                        'ultimo_pago'   =>$ultimopago,
                        'mora'          =>$mora,
                        'estado_cartera'=>$estadomora,
                    ]);





                }catch(Exception $exception){
                    Log::info('Line: ' . $row . ' 19-activa-matricula with error: ' . $exception->getMessage());
                }


            }
    }

    fclose($handle);
    }
}
