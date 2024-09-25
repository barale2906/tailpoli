<?php

namespace App\Console\Commands;

use App\Models\Academico\Control;
use App\Models\Academico\Ciclo;
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
        Log::info(now().': Ejecuta Control:vencimiento-finControl.');

        $controles=Control::where('status', true)
                            ->get();

        $cont=Carbon::today()->subMonths(2);

        foreach ($controles as $value) {
            try {

                    $cicloac=Ciclo::where('finaliza', $cont)
                                ->where('id',$value->ciclo->id)
                                ->get();

                    if($cicloac->count()>=1){

                        $value->update([
                            'status'=>false,
                        ]);

                        Pqrs::create([
                            'estudiante_id' =>$value->estudiante_id,
                            'gestion_id'    =>$value->matricula->creador_id,
                            'fecha'         =>now(),
                            'tipo'          =>1,
                            'observaciones' =>'GESTIÓN: Finaliza ciclo cierre automático:  Control: '.$value->id.' ----- ',
                            'status'        =>4
                        ]);
                    }

            } catch(Exception $exception){
                Log::info('Linea control: ' . $value->id . ' finControl: ' . $exception->getMessage().' control: '.$exception->getLine());
            }
        }
    }
}
