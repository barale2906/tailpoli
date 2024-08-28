<?php

namespace Database\Seeders;

use App\Models\Academico\Ciclo;
use App\Models\Academico\Control;
use App\Models\Academico\Grupo;
use App\Models\Academico\Matricula;
use App\Models\Academico\Modulo;
use App\Models\Financiera\Cartera;
use App\Models\Financiera\ConfiguracionPago;
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

                    //obtener configuracion de pago
                    $config=ConfiguracionPago::where('inicia', '>=', $matricula->fecha_inicia)
                                                ->where('curso_id', $matricula->curso_id)
                                                ->where('sector_id', $matricula->sede->sector->id)
                                                ->select('id')
                                                ->first();

                    if($config){
                        $pagoconf=$config->id;
                    }else{
                        $pagoconf=0;
                    }


                    //Actualizar status de la matricula
                    $matricula->update([
                        'status'=>true,
                        'configpago'=>$pagoconf
                    ]);

                    //Actualizar fechas de pago reales cartera
                    Cartera::where('matricula_id', $matricula->id)
                                ->where('estado_cartera_id', '<',5)
                                ->update([
                                    'fecha_real'=>null
                                ]);

                    //Actualizar registro de último pago
                    $ultimopago=ReciboPago::where('paga_id', $matricula->alumno_id)
                                            ->where('origen', true)
                                            ->select('fecha')
                                            ->orderBy('fecha', 'DESC')
                                            ->first();

                    if($ultimopago){
                        $fechaultimo=$ultimopago->fecha;
                    }else{
                        $fechaultimo=null;
                    }
                    //Obtener mora
                    $ayer=Carbon::today()->subDay();

                    $mora=Cartera::where('responsable_id', $matricula->alumno_id)
                                    ->where('estado_cartera_id', '<',5)
                                    ->where('fecha_pago', '<=', $ayer)
                                    ->where('saldo', '>', 10000)
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
                        'ultimo_pago'   =>$fechaultimo,
                        'mora'          =>$mora,
                        'estado_cartera'=>$estadomora,
                    ]);

                    // Cargar grupos
                    foreach ($ciclo->ciclogrupos as $value) {

                        DB::table('grupo_matricula')
                        ->insert([
                            'grupo_id'      =>$value->grupo_id,
                            'matricula_id'  =>$matricula->id,
                            'created_at'    =>now(),
                            'updated_at'    =>now(),
                        ]);

                        //Cargar estudiante al grupo
                        DB::table('grupo_user')
                            ->insert([
                                'grupo_id'      =>$value->grupo_id,
                                'user_id'       =>$matricula->alumno->id,
                                'created_at'    =>now(),
                                'updated_at'    =>now(),
                            ]);



                        //Sumar usuario al grupo
                        $inscritos=Grupo::find($value->grupo_id);

                        $tot=$inscritos->inscritos+1;

                        $inscritos->update([
                            'inscritos'=>$tot
                        ]);

                    }


                }catch(Exception $exception){
                    Log::info('Line: ' . $row . ' 19-activa-matricula with error: ' . $exception->getMessage());
                }


            }
        }

    fclose($handle);
    }
}
