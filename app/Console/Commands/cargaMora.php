<?php

namespace App\Console\Commands;

use App\Models\Academico\Control;
use App\Models\Financiera\Cartera;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Stmt\TryCatch;

class cargaMora extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Cartera:cargaMora';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualiza la mora en la tabla de control';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        /* Cartera::where('fecha_pago', Carbon::today()->subDay())
                ->where('saldo', '>', 0)
                ->each(function($cart){
                    $this->deuda=$cart->saldo;
                    Control::where('status', true)
                            ->where('estudiante_id', $cart->responsable_id)
                            ->each(function($crt){
                                $valor=$crt->mora;
                                $crt->update([
                                    'mora'=>$valor+$this->deuda,
                                ]);
                            });
            }); */

        $crt=Carbon::today()/* ->subDay() */;

        $vencida=Cartera::where('fecha_pago', '<',$crt)
                        ->whereNotIn('status_est',[2,6,11,12,13])
                        ->where('estado_cartera_id', '<',5)
                        ->whereBetween('concepto_pago_id',[2,4])
                        ->where('saldo', '>', 0)
                        ->get();

        Log::channel('comandos_log')->info(now().': Ejecuta CargaMora.');

        foreach ($vencida as $value) {
            try {

                //Poner la carter en mora
                Cartera::where('id',$value->id)
                        ->update([
                            'status'=>3,
                            'estado_cartera_id'=>3,
                        ]);

                /* $control=Control::where('status', true)
                                ->where('estudiante_id', $value->responsable_id)
                                ->get();

                foreach ($control as $item) {
                    $uno=Control::find($item->id);
                    $uno->update([
                        'mora'=>$uno->mora+$value->saldo,
                    ]);
                } */

            } catch(Exception $exception){
                Log::channel('comandos_log')->info('Linea cartera: ' . $value->id . ' CargaMora No permitio registrar: ' . $exception->getMessage().' control: '.$exception->getLine());
            }
        }
    }
}
