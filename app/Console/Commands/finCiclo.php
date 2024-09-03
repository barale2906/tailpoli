<?php

namespace App\Console\Commands;

use App\Models\Academico\Ciclo;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class finCiclo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Ciclo:vencimiento';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica y finaliza la vigencia de un ciclo - programación';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $ciclos=Ciclo::where('finaliza', Carbon::today()->subDay())
                        ->get();

        Log::info(now().': finCiclo.');
        foreach ($ciclos as $value) {
            try {
                $value->update([
                                    'status'=>false,
                                ]);
            } catch(Exception $exception){
                Log::info('Linea ciclo: ' . $value->id . ' Ciclo No permitio registrar: ' . $exception->getMessage().' registro: '.$exception->getLine());
            }
        }


    }
}
