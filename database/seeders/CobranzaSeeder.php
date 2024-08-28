<?php

namespace Database\Seeders;

use App\Models\Financiera\Cartera;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class CobranzaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cartera=Cartera::select('id','status','estado_cartera_id','saldo','fecha_pago')->get();
        $hoy=Carbon::today();

        foreach ($cartera as $value) {
            Log::info(' id_control: '.$value->id.' saldo: '.$value->saldo.' estado: '.$value->estado_cartera_id.' sttus: '.$value->status);


            if(intval($value->status)===0 && intval($value->saldo)>0){
                Cartera::where('id',$value->id)
                        ->update([
                            'status'=>7,
                            'estado_cartera_id'=>7
                        ]);

                Log::info(' id_control: '.$value->id.' ANULADA.');
            }

            if(intval($value->saldo)===0 && intval($value->estado_cartera_id)===6 && intval($value->status)===0){
                Cartera::where('id',$value->id)
                        ->update([
                            'status'=>6,
                            'estado_cartera_id'=>6
                        ]);

                Log::info(' id_control: '.$value->id.' CERRADA.');
            }

            if(intval($value->status)===1 && intval($value->estado_cartera_id)===1 && intval($value->saldo)>0 && $value->fecha_pago<$hoy){
                Cartera::where('id',$value->id)
                        ->update([
                            'status'=>3,
                            'estado_cartera_id'=>3
                        ]);
                Log::info(' id_control: '.$value->id.' MORA.');
            }

        }
    }
}
