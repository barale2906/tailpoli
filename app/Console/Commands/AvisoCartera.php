<?php

namespace App\Console\Commands;

use App\Models\Financiera\Cartera;
use App\Traits\MailTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class AvisoCartera extends Command
{
    use MailTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Cartera:aviso-cartera';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Informa al estudiante acerca de las fechas de pago de su proxima cuota.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $fecha=Carbon::today()->addDays(15);
        $hoy=Carbon::today();
        $proximos=Cartera::where('estado_cartera_id', '<',5)
                        ->whereNotIn('status_est',[2,6,11])
                        ->whereIn('fecha_pago', [$hoy,$fecha])
                        ->select('id')
                        ->get();

        Log::channel('comandos_log')->info(now() . ': Ejecuta AvisoCartera.');

        if($proximos->count()>0){
            foreach ($proximos as $value) {

                try {

                    //Enviar email
                    $this->claseEmail(3,$value->id);

                } catch(Exception $exception){
                    Log::channel('comandos_log')->info('AvisoCartera: ' . $value->id . ' No cargo: ' . $exception->getMessage().' Donde: '.$exception->getLine());
                }
            }
        }else{
            Log::channel('comandos_log')->info('no se generaron registros en la consulta' );
        }
    }
}
