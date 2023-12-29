<?php

namespace App\Console\Commands;

use App\Models\Configuracion\Documento;
use Carbon\Carbon;
use Illuminate\Console\Command;

class finDocumento extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Documento:vigencia';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica el inicio y fin de la vigencia de los documentos';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Documento::where('status', 2)
                    ->where('fecha', Carbon::today())
                    ->each(function($docu){
                        Documento::where('tipo', $docu->tipo)
                                    ->where('status', 3)
                                    ->each(function($ant){
                                        $ant->update([
                                            'status'=>4
                                        ]);
                                    });

                        $docu->update([
                            'status'=>3
                        ]);

                    });
    }
}
