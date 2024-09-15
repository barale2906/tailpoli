<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LimpiApoyo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Gestion:LimpiApoyo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Realiza la limpieza de la tabla de apoyo';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info(now().': Ejecuta CobranzaDescarga.');

        DB::table('apoyo_recibo')
            ->delete();
    }
}
