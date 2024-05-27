<?php

namespace Database\Seeders;

use App\Models\Academico\Matricula;
use App\Models\Financiera\Cartera;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class CarteraOrdenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $matriculas=Matricula::where('status', true)->select('id')->get();

        foreach ($matriculas as $value) {
            $carteras=Cartera::where('matricula_id', $value->id)
                                //->where('status', true)
                                ->where('concepto', 'mensualidad')
                                ->orderBy('fecha_pago', 'ASC')
                                ->get();

            if($carteras){
                $a=1;
                foreach ($carteras as $value) {
                    if($value->concepto_pago_id!==1){
                        try {
                                $value->update([
                                    'observaciones'=>'Cuota Nro: '.$a.' mensual. ----- '.$value->observaciones
                                ]);
                                $a++;
                        } catch(Exception $exception){
                            Log::info('registro: '.$a.' Error al modificar las observaciones: '. $exception->getMessage().' linea código: '.$exception->getLine().' Cartera: '.$value );
                        }
                    }
                }
            }
        }
    }
}
