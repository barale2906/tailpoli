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
        $recibos=Recibopago::whereNull('fecha_transaccion')->get();

        foreach ($recibos as $value) {
            try {

                $value->update([
                    'fecha_transaccion'=>$value->created_at,
                ]);

                Log::info('Recibo N°: ' . $value->numero_recibo );

            }catch(Exception $exception){
                Log::info('Line: ' . $value->id . ' fechatransacción with error: ' . $exception->getMessage());
            }
        }

    }
}
