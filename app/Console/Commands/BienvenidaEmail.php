<?php

namespace App\Console\Commands;

use App\Models\Academico\Matricula;
use App\Traits\MailTrait;
use App\Traits\PdfTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class BienvenidaEmail extends Command
{
    use MailTrait;
    use PdfTrait;

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

        $fecha=Carbon::today()->subDay();
        $nuevos=Matricula::where('created_at', '>=', $fecha)
                            ->where('status', true)
                            ->select('id')
                            ->get();
        Log::info(now().': Ejecuta Correo Bienvenida.');

        if($nuevos->count()>0){
            foreach ($nuevos as $value) {

                try {

                    //Genera carnet
                    $this->carnet($value->id);

                    //Enviar email
                    $this->claseEmail(2,$value->id);


                } catch(Exception $exception){
                    Log::info('Matricula N°: ' . $value->id . ' Algo paso: ' . $exception->getMessage().' Donde: '.$exception->getLine());
                }
            }
        }else{
            Log::info('no se generaron registros en la consulta' );
        }
    }
}
