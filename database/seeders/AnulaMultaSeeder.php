<?php

namespace Database\Seeders;

use App\Models\Financiera\Cartera;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class AnulaMultaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $anuladas=Cartera::where('estado_cartera_id','<',5)
                            ->where('concepto_pago_id',8)
                            ->get();

        $Observaciones=now().": ORDEN ANULACIÓN GERENCIA: Se anula este item de cartera ----- ";

        foreach ($anuladas as $value) {
            try {
                Cartera::where('id',$value->id)
                        ->update([
                            'estado_cartera_id' =>7,
                            'status'            =>7,
                            'observaciones'     =>$Observaciones.$value->observaciones,
                        ]);

            } catch(Exception $exception){
                Log::info('Matricula: ' . $value->matricula_id . ' Cartera id: '.$value->id.' with error: ' . $exception->getMessage());
            }
        }
    }
}
