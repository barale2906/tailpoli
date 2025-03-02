<?php

namespace App\Console\Commands;

use App\Models\Financiera\Cartera;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CastigaCartera extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Cartera:Castiga';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Castiga la cartera que tiene mas de 5 años por prescripción de terminos.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $crt=Carbon::today()->subYears(5);
        $prescritos=Cartera::where('estado_cartera_id','<',5)
                            ->where('fecha_pago','<',$crt)
                            ->select('matricula_id')
                            ->groupBy('matricula_id')
                            ->get();

        $mensaje=now()." AUTOMATICO se castiga la cartera por prescripción de la deuda. ----- ";
        if($prescritos){
            Log::channel('comandos_log')->info(now().': Ejecuta Castiga Cartera. Consulta: '.$prescritos->count().' registros: '.$prescritos);

            foreach ($prescritos as $value) {

                try {
                    DB::table('carteras')
                        ->where('estado_cartera_id','<',5)
                        ->where('matricula_id',$value->matricula_id)
                        ->update([
                                    'status'=>5,
                                    'estado_cartera_id'=>5,
                                    'observaciones' => DB::raw("CONCAT(' $mensaje', observaciones)"),
                                    'updated_at'=>now()
                                ]);
                } catch(Exception $exception){
                    Log::channel('comandos_log')->info('matricula_id: ' . $value->matricula_id . ' CastigaCartera No permitio registrar: ' . $exception->getMessage().' control: '.$exception->getLine());
                }

            }
        }else{
            Log::channel('comandos_log')->info(now().': Carga Multa.'.' consulta: Sin registros.');
        }

    }
}
