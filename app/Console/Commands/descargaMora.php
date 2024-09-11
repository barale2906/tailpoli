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
        $morados=Control::whereNotIn('status_est',[2,6,11])
                            ->where('mora','>',0)
                            ->get();

        Log::info(now().': Ejecuta DescargaMora.');
        foreach ($morados as $value) {
            $cartera=Cartera::where('matricula_id',$value->matricula_id)
                                ->where('status',3)
                                ->select('saldo')
                                ->get();

            try {
                $mora=0;
                $registro=Control::where('id',$value->id)->first();
                $registro->update([
                    'mora'=>0
                ]);
                if($cartera){
                    foreach ($cartera as $item) {
                        $registro->update([
                            'mora'=>$mora+$item->saldo,
                        ]);
                    }
                }
            } catch(Exception $exception){
                Log::info('Linea control: ' . $value->id . ' DescargaMora No permitio registrar: ' . $exception->getMessage().' control: '.$exception->getLine());
            }

        }
    }
}
