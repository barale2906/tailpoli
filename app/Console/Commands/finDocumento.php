<?php

namespace App\Console\Commands;

use App\Models\Configuracion\Documento;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

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

        $documentos=Documento::where('status', 2)
                                ->where('fecha', Carbon::today())
                                ->get();


        Log::info(now().': Ejecuta finDocumento.');
        foreach ($documentos as $value) {
            try {

                Documento::where('tipo', $value->tipo)
                            ->where('status', 3)
                            ->where('fecha', '<', Carbon::today())
                            ->update([
                                'status'=>4
                                ]);

                $value->update([
                    'status'=>3
                ]);



            } catch(Exception $exception){
                Log::info('Linea documento: ' . $value->id . ' Documento No permitio registrar: ' . $exception->getMessage().' documen: '.$exception->getLine());
            }
        }

    }
}
