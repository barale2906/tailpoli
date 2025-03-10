<?php

namespace App\Console\Commands;

use App\Models\Academico\Control;
use App\Models\Financiera\Cartera;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ResetCartera extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Cartera:Reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Resetea el cuadro de control y vuelve a cargar la cartera.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::channel('comandos_log')->info('ejecuta: Cartera:Reset' );

        Control::whereNotIn('status_est',[2,4,6,11,12,13])
                            ->update([
                                'mora'=>0,
                                'estado_cartera'=>1
                            ]);

        $listados=Control::whereNotIn('status_est',[2,4,6,11,12,13])
                            ->get();

        foreach ($listados as $value) {
            try {

                $cartera=Cartera::where('matricula_id', $value->matricula_id)
                                    ->where('estado_cartera_id',3)
                                    ->sum('saldo');

                $estado=1;

                if($cartera>0){
                    $estado=3;
                }
                Log::channel('comandos_log')->info('Matricula ID:'.$value->matricula_id.' Valor Cartera: '.$cartera.' Estado Cartera: '.$estado );
                Control::where('id',$value->id)
                        ->update([
                            'mora'          =>$cartera,
                            'estado_cartera'=>$estado,
                            'updated_at'    =>now()
                        ]);
            } catch(Exception $exception){
                Log::channel('comandos_log')->info('Matricula N°: ' . $value->matricula_id . ' Algo paso: ' . $exception->getMessage().' Donde: '.$exception->getLine());
            }
        }
    }
}
