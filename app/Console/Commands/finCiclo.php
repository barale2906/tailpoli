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
        Log::channel('comandos_log')->info(now().': Ejecuta Ciclo:vencimiento-finCiclo.');
        $ciclos=Ciclo::where('finaliza', Carbon::today()->subDay())
                        ->where('status',true)
                        ->get();

        foreach ($ciclos as $value) {
            try {
                $observa=now().": AUTOMATICO se cierra el ciclo por fecha de finalización. ----- ".$value->observaciones;

                $value->update([
                                    'status'        =>false,
                                    'observaciones' =>$observa
                                ]);
            } catch(Exception $exception){
                Log::channel('comandos_log')->info('Linea ciclo: ' . $value->id . ' Ciclo No permitio registrar: ' . $exception->getMessage().' registro: '.$exception->getLine());
            }
        }


    }
}
