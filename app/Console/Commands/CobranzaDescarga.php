<?php

namespace App\Console\Commands;

use App\Models\Financiera\Cartera;
use App\Models\Financiera\Cobranza;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CobranzaDescarga extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Cobranza:DescargaCobranza';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica que se hayan pagado los itemes para descargarlo de la gestión de cobranza.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $registros=Cobranza::where('status',3)->get();

        Log::info(now().': CobranzaDescarga.');

        foreach ($registros as $value) {

            $est=Cartera::find($value->cartera_id);

            if($est->estado_cartera_id>4){
                $value->update([
                    'status'=>$est->estado_cartera_id
                ]);
            }

            $value->update([
                'saldo'=>$est->saldo,
            ]);
        }
    }
}
