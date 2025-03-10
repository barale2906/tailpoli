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
        $schedule->command('Gestion:LimpiApoyo')->timezone('America/Bogota')->at('00:10');  //->everyThreeMinutes();
        $schedule->command('Ciclo:vencimiento')->timezone('America/Bogota')->at('00:20');  //->everyThreeMinutes();
        //$schedule->command('Control:vencimiento')->timezone('America/Bogota')->at('00:40');  //->everyThreeMinutes();
        $schedule->command('Documento:vigencia')->timezone('America/Bogota')->at('01:00');  //->everyThreeMinutes();
        //$schedule->command('Cartera:cargaMulta')->timezone('America/Bogota')->at('01:10');  //->everyThreeMinutes();
        $schedule->command('Cartera:cargaMora')->timezone('America/Bogota')->at('01:30');  //->everyThreeMinutes();
        //$schedule->command('Academico:aprobo-reprobo')->timezone('America/Bogota')->at('01:50');  //->everyThreeMinutes();
        $schedule->command('Academico:DesercionAntiguo')->timezone('America/Bogota')->at('02:05');  //->everyThreeMinutes();
        $schedule->command('Academico:desercion')->timezone('America/Bogota')->at('02:25');  //->everyThreeMinutes();
        $schedule->command('Matricula:bienvenida-email')->timezone('America/Bogota')->at('02:45');  //everyMinute();
        $schedule->command('Cartera:aviso-cartera')->timezone('America/Bogota')->at('02:50'); //->at('02:50');  //everyMinute();
        $schedule->command('Academico:Gastos')->timezone('America/Bogota')->at('03:10'); //->at('03:10');  //everyMinute();
        $schedule->command('Cobranza:Carga')->timezone('America/Bogota')->at('03:40'); //->at('03:40');  //everyMinute();
        $schedule->command('Cartera:Castiga')->timezone('America/Bogota')->at('04:00'); //->at('04:00');  //everyMinute();
        $schedule->command('Cobranza:Descarga')->timezone('America/Bogota')->at('04:40'); //->at('04:10');  //everyMinute();
        $schedule->command('Academico:Graduado')->timezone('America/Bogota')->at('05:40');  //->everyThreeMinutes();
        //$schedule->command('Cartera:DescargaMora')->timezone('America/Bogota')->at('05:50');  //->everyThreeMinutes();
        $schedule->command('Cartera:Reset')->timezone('America/Bogota')->at('05:50');  //->everyThreeMinutes();
        $schedule->command('Cobranza:Gestion')->timezone('America/Bogota')->at('10:45'); //->at('10:45');  //everyMinute();

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
