<?php

namespace App\Console\Commands;

use App\Models\Academico\Ciclo;
use Carbon\Carbon;
use Illuminate\Console\Command;

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
        Ciclo::where('finaliza', Carbon::today()->subDay())
                ->each(function($ciclo){
                    $ciclo->update([
                        'status'=>false,
                    ]);

                });


    }
}
