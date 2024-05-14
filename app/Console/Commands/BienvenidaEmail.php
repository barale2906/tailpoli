<?php

namespace App\Console\Commands;

use App\Models\Academico\Matricula;
use Carbon\Carbon;
use Illuminate\Console\Command;

class BienvenidaEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Matricula:bienvenida-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envía correo de bienvenida a los nuevos estudiantes con su carnet';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $nuevos=Matricula::where('created_at', Carbon::today()->subDay())
                            ->where('status', true)
                            ->get();
    }
}
