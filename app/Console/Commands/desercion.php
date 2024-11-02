<?php

namespace App\Console\Commands;

use App\Models\Academico\Control;
use App\Models\Academico\Matricula;
use App\Models\Clientes\Pqrs;
use App\Models\Configuracion\Estado;
use App\Models\Financiera\Cartera;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class desercion extends Command
{
    public $desertado;
    public $activo;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Academico:desercion';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica el estado de un estudiante según el tiempo de su última asistencia';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $inic=Carbon::today()->subMonths(12);
        $hoy=Carbon::today();
        $margen=config('instituto.desertado_fin'); //Control de deserción
        $fecha=Carbon::today()->subDays($margen); //tIEMPO DE ASISTENCIA

        Log::info(now().': Ejecuta Deserción reciente. margen: '.$margen.' fecha margen: '.$fecha);
;
        $controles=Control::where('status', true)
                            ->whereNotIn('status_est',[2,4,6,11])
                            ->where('inicia','>', $inic)
                            ->orderBy('inicia','ASC')
                            ->get();

        foreach ($controles as $value) {
            //Log::info("Inicia: ".$value->inicia." Asistencia: ".$value->ultima_asistencia." Documento: ".$value->estudiante->documento);
            try {
                    $inicio=new Carbon($value->ciclo->inicia);

                    if($value->ultima_asistencia){
                        if($value->ultima_asistencia > $fecha){
                            //Verificar si ya ERA DESERTADO
                            if(intval($value->status_est)===3){

                                //Asignar Estado de reintegrado si hasta ahora vuelve

                                $value->update([
                                    'status_est'=>7
                                ]);

                                //Actualizar Matricula
                                Matricula::where('id',$value->matricula_id)
                                            ->update([
                                                'status_est'=>7
                                            ]);

                                //Actualizar Cartera
                                Cartera::where('matricula_id', $value->matricula_id)
                                        ->update([
                                            'status_est'=>7
                                        ]);

                                Pqrs::create([
                                    'estudiante_id' =>$value->estudiante_id,
                                    'gestion_id'    =>$value->matricula->creador_id,
                                    'fecha'         =>now(),
                                    'tipo'          =>4,
                                    'observaciones' =>'ACÁDEMICO:  --- ¡REINTEGRO! --- --- AUTOMATICO -----  ',
                                    'status'        =>4
                                ]);

                            }else{

                                //Activar estudiante
                                $value->update([
                                    'status_est'=>1
                                ]);

                                //Actualizar Matricula
                                Matricula::where('id',$value->matricula_id)
                                ->update([
                                    'status_est'=>1
                                ]);

                                //Actualizar Cartera
                                Cartera::where('matricula_id', $value->matricula_id)
                                        ->update([
                                            'status_est'=>1
                                        ]);

                                Pqrs::create([
                                    'estudiante_id' =>$value->estudiante_id,
                                    'gestion_id'    =>$value->matricula->creador_id,
                                    'fecha'         =>now(),
                                    'tipo'          =>4,
                                    'observaciones' =>'ACÁDEMICO:  --- ¡ACTIVO! --- --- AUTOMATICO -----  ',
                                    'status'        =>4
                                ]);
                            }
                        }else{
                            $value->update([
                                'status_est'=>3
                            ]);

                            //Actualizar Matricula
                            Matricula::where('id',$value->matricula_id)
                                        ->update([
                                            'status_est'=>3
                                        ]);

                            //Actualizar Cartera
                            Cartera::where('matricula_id', $value->matricula_id)
                                    ->update([
                                        'status_est'=>3
                                    ]);

                            Pqrs::create([
                                'estudiante_id' =>$value->estudiante_id,
                                'gestion_id'    =>$value->matricula->creador_id,
                                'fecha'         =>now(),
                                'tipo'          =>4,
                                'observaciones' =>'ACÁDEMICO:  --- ¡DESERTADO! --- --- AUTOMATICO -----  ',
                                'status'        =>4
                            ]);
                        }
                    }else{
                        if($hoy>$inicio){

                            $value->update([
                                'status_est'=>3
                            ]);

                            //Actualizar Matricula
                            Matricula::where('id',$value->matricula_id)
                                        ->update([
                                            'status_est'=>3
                                        ]);

                            //Actualizar Cartera
                            Cartera::where('matricula_id', $value->matricula_id)
                                    ->update([
                                        'status_est'=>3
                                    ]);

                            Pqrs::create([
                                'estudiante_id' =>$value->estudiante_id,
                                'gestion_id'    =>$value->matricula->creador_id,
                                'fecha'         =>now(),
                                'tipo'          =>4,
                                'observaciones' =>'ACÁDEMICO:  --- ¡DESERTADO! --- --- AUTOMATICO -----  ',
                                'status'        =>4
                            ]);
                        }else{
                            $value->update([
                                'status_est'=>9
                            ]);

                            //Actualizar Matricula
                            Matricula::where('id',$value->matricula_id)
                                        ->update([
                                            'status_est'=>9
                                        ]);

                            //Actualizar Cartera
                            Cartera::where('matricula_id', $value->matricula_id)
                                    ->update([
                                        'status_est'=>9
                                    ]);

                            Pqrs::create([
                                'estudiante_id' =>$value->estudiante_id,
                                'gestion_id'    =>$value->matricula->creador_id,
                                'fecha'         =>now(),
                                'tipo'          =>4,
                                'observaciones' =>'ACÁDEMICO:  --- ¡POR INICIAR! --- --- AUTOMATICO -----  ',
                                'status'        =>4
                            ]);
                        }
                    }

            } catch(Exception $exception){
                Log::info('Linea control: ' . $value->id . ' Deserción No permitio registrar: ' . $exception->getMessage().' control: '.$exception->getLine());
            }
        }
    }
}
