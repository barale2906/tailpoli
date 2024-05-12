<?php

namespace App\Console\Commands;

use App\Models\Academico\Ciclo;
use App\Models\Academico\Control;
use App\Models\Clientes\Pqrs;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class finControl extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Control:vencimiento';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Finaliza control por fechas';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        /* Ciclo::where('finaliza', Carbon::today()->subDays(20))
                ->each(function($ciclo){
                    $ciclo->control->each(function($crt){
                        $crt->update([
                            'status'=>false
                        ]);
                        Pqrs::create([
                            'estudiante_id' =>$crt->estudiante_id,
                            'gestion_id'    =>$crt->matricula->creador_id,
                            'fecha'         =>now(),
                            'tipo'          =>1,
                            'observaciones' =>'GESTIÓN: Finaliza ciclo cierre automático. ----- ',
                            'status'        =>4
                        ]);
                    });
                }); */

        $controles=Control::where('status', true)
                    ->get();

        foreach ($controles as $value) {
            try {

                $cont=Carbon::today()->subMonths(2);

                if($value->ciclo->finaliza<$cont){

                    $value->update([
                        'status'=>false,
                    ]);

                    Pqrs::create([
                        'estudiante_id' =>$value->estudiante_id,
                        'gestion_id'    =>$value->matricula->creador_id,
                        'fecha'         =>now(),
                        'tipo'          =>1,
                        'observaciones' =>'GESTIÓN: Finaliza ciclo cierre automático. ----- ',
                        'status'        =>4
                    ]);
                }

            } catch(Exception $exception){
                Log::info('Linea control: ' . $value->id . ' Deserción No permitio registrar: ' . $exception->getMessage().' control: '.$exception->getLine());
            }
        }
    }
}
