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
        $schedule->command('Ciclo:vencimiento')->timezone('America/Bogota')->everyThreeMinutes();
        $schedule->command('Control:vencimiento')->timezone('America/Bogota')->everyThreeMinutes();
        $schedule->command('Documento:vigencia')->timezone('America/Bogota')->everyThreeMinutes();
        $schedule->command('Cartera:cargaMulta')->timezone('America/Bogota')->everyThreeMinutes();
        $schedule->command('Cartera:cargaMora')->timezone('America/Bogota')->everyThreeMinutes();
        $schedule->command('Academico:aprobo-reprobo')->timezone('America/Bogota')->everyThreeMinutes();
        $schedule->command('Academico:desercion')->timezone('America/Bogota')->everyThreeMinutes();
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
