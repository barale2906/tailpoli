<?php

namespace Database\Seeders;

use App\Models\Financiera\Cartera;
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
        $cartera=Cartera::select('id','status','estado_cartera_id','saldo')->get();

        foreach ($cartera as $value) {
            Log::info(' id_control: '.$value->id.' saldo: '.$value->saldo.' estado: '.$value->estado_cartera_id.' sttus: '.$value->status);

            if($value->saldo===0 && $value->estado_cartera_id===6 && $value->status===0){
                $value->update([
                    'status'=>6,
                ]);
                Log::info(' id_control: '.$value->id.' CERRADA.');
            }

            if($value->status===0 && $value->saldo>0){
                $value->update([
                    'status'=>7,
                    'estado_cartera_id'=>7
                ]);
                Log::info(' id_control: '.$value->id.' ANULADA.');
            }

            if($value->status===1 && $value->estado_cartera_id===1 && $value->saldo>0){
                $value->update([
                    'status'=>3,
                    'estado_cartera_id'=>3
                ]);
                Log::info(' id_control: '.$value->id.' MORA.');
            }

        }
    }
}
