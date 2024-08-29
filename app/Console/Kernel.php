<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('Ciclo:vencimiento')->timezone('America/Bogota')->at('12:20');  //->everyThreeMinutes();
        $schedule->command('Control:vencimiento')->timezone('America/Bogota')->at('12:40');  //->everyThreeMinutes();
        $schedule->command('Documento:vigencia')->timezone('America/Bogota')->at('01:00');  //->everyThreeMinutes();
        $schedule->command('Cartera:cargaMulta')->timezone('America/Bogota')->at('01:10');  //->everyThreeMinutes();
        $schedule->command('Cartera:cargaMora')->timezone('America/Bogota')->at('01:30');  //->everyThreeMinutes();
        $schedule->command('Academico:aprobo-reprobo')->timezone('America/Bogota')->at('01:50');  //->everyThreeMinutes();
        $schedule->command('Academico:desercion')->timezone('America/Bogota')->at('02:10');  //->everyThreeMinutes();
        $schedule->command('Matricula:bienvenida-email')->timezone('America/Bogota')->at('02:30');  //everyMinute();
        $schedule->command('Cartera:aviso-cartera')->timezone('America/Bogota')->at('02:50'); //->at('02:50');  //everyMinute();
        $schedule->command('Academico:Gastos')->timezone('America/Bogota')->at('03:10'); //->at('03:10');  //everyMinute();
        $schedule->command('Cobranza:Carga')->timezone('America/Bogota')->at('03:40'); //->at('03:40');  //everyMinute();
        $schedule->command('Cobranza:Descarga')->timezone('America/Bogota')->at('04:10'); //->at('04:10');  //everyMinute();
        $schedule->command('Cobranza:Carga')->timezone('America/Bogota')->at('04:40'); //->at('04:40');  //everyMinute();
        $schedule->command('Cobranza:Gestion')->timezone('America/Bogota')->at('16:08'); //->at('08:30');  //everyMinute();

    }
    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
