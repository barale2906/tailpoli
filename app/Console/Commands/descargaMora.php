<?php

namespace App\Console\Commands;

use App\Models\Academico\Control;
use App\Models\Financiera\Cartera;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class descargaMora extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Cartera:DescargaMora';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica los controles de mora y los actualiza';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $morados=Control::whereNotIn('status_est',[2,4,6,11])
                            //->where('mora','>',0)
                            ->get();

        Log::channel('comandos_log')->info(now().': Ejecuta DescargaMora Ajustado.');
        foreach ($morados as $value) {
            Control::where('id',$value->id)
                    ->update([
                        'mora'=>0,
                        'estado_cartera'=>2
                    ]);
            $cartera=Cartera::where('matricula_id',$value->matricula_id)
                                ->where('estado_cartera_id',3)
                                ->select('saldo')
                                ->get();

            try {
                if($cartera){
                    $mora=0;
                    foreach ($cartera as $item) {
                        $mora=$mora+$item->saldo;
                    }

                    Control::where('id',$value->id)
                        ->update([
                            'mora'=>$mora,
                            'estado_cartera'=>5
                        ]);
                }
            } catch(Exception $exception){
                Log::channel('comandos_log')->info('Linea control: ' . $value->id . ' DescargaMora No permitio registrar: ' . $exception->getMessage().' control: '.$exception->getLine());
            }

        }
    }
}
