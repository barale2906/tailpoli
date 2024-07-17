<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Financiera\Cartera;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class MensualidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $carteras=DB::table('concepto_pago_recibo_pago')
                        ->where('id_relacional','>',0)
                        ->where('id','>=',150747)
                        ->orderBy('id','DESC')
                        ->get();

        foreach ($carteras as $value) {
            try {
                $car=Cartera::find($value->id_relacional);

                if($car){
                    $dato=explode("-----",$car->observaciones);
                    $dat=$dato[0];
                    DB::table('concepto_pago_recibo_pago')
                        ->where('id', $value->id)
                        ->update([
                            'producto'=>$dat,
                        ]);
                    Log::info('Line: ' . $value->id . ', Cartera: '.$value->id_relacional.', actualiza: '.$dat);
                }else{
                    Log::info('Line: ' . $value->id . ', Cartera: '.$value->id_relacional.', no tenia observaciones.');
                }
            } catch (Exception $exception) {
                Log::info('id: ' . $value->id . ' Error: ' . $exception->getMessage());
            }


        }


    }
}
