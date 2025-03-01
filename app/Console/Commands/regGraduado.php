<?php

namespace App\Console\Commands;

use App\Models\Academico\Control;
use App\Models\Academico\Matricula;
use App\Models\Clientes\Pqrs;
use App\Models\Financiera\Cartera;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class regGraduado extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Academico:Graduado';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Válida las fechas de graduación y marca al estudiante como graduado el día registrado como fecha de grado.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::channel('comandos_log')->info(now().': Academico:Graduado Válida estuidiantes que se graduan hoy.');
        $hoy=Carbon::today();

        $graduados=Control::whereNotIn('status_est',[2,4,6,11])
                            ->where('fecha_grado',$hoy)
                            ->get();

        foreach ($graduados as $value) {
            try {
                $value->update([
                    'status_est'=>4
                ]);

                //Actualizar Matricula
                Matricula::where('id',$value->matricula_id)
                            ->update([
                                'status_est'=>4,
                                'status'    =>0
                            ]);

                //Actualizar Cartera
                Cartera::where('matricula_id', $value->matricula_id)
                        ->update([
                            'status_est'=>4
                        ]);

                Pqrs::create([
                    'estudiante_id' =>$value->estudiante_id,
                    'gestion_id'    =>$value->matricula->creador_id,
                    'fecha'         =>now(),
                    'tipo'          =>4,
                    'observaciones' =>'ACÁDEMICO:  --- ¡GRADUADO! --- --- AUTOMATICO -----  ',
                    'status'        =>4
                ]);
            } catch(Exception $exception){
                Log::channel('comandos_log')->info('Linea control: ' . $value->id . ' REgistro de graduados no permitio registrar: ' . $exception->getMessage().' control: '.$exception->getLine());
            }
        }
    }
}
