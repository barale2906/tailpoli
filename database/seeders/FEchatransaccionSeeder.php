<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use App\Models\Financiera\ReciboPago;

class FEchatransaccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $recibos=Recibopago::select('id','created_at','numero_recibo')
                            ->whereNull('fecha_transaccion')
                            ->where('id', '>=',1)
                            ->where('id', '<',30000)
                            ->get();

        foreach ($recibos as $value) {
            try {
                Recibopago::where('id',$value->id)
                            ->update([
                                'fecha_transaccion'=>$value->created_at,
                            ]);

                Log::info('Recibo N°: ' . $value->numero_recibo );

            }catch(Exception $exception){
                Log::info('Line: ' . $value->id . ' fechatransacción with error: ' . $exception->getMessage());
            }
        }

    }
}
