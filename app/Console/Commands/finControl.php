<?php

namespace App\Console\Commands;

use App\Models\Academico\Ciclo;
use App\Models\Academico\Control;
use App\Models\Clientes\Pqrs;
use Carbon\Carbon;
use Illuminate\Console\Command;

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
        Ciclo::where('finaliza', Carbon::today()->subDays(20))
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
                });
    }
}
