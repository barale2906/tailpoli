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
        //Verificar si entra en deserción
        $con=Estado::where('status', true)
                    ->where('name', 'desertado')
                    ->select('id')
                    ->first();

        $this->desertado=$con->id;

        //Verificar si sale de deserción
        $conec=Estado::where('status', true)
                    ->where('name', 'reintegro')
                    ->select('id')
                    ->first();

        $this->activo=$conec->id;

        $inic=Carbon::today()->subMonths(20);
;
        $controles=Control::where('status', true)
                            ->whereBetween('inicia', [$inic, Carbon::today()])
                            ->get();

        foreach ($controles as $value) {
            try {
                    $margen=$value->ciclo->desertado+1;
                    $inicio=new Carbon($value->ciclo->inicia);
                    $fecha=Carbon::today()->subDays($margen);
                    $diferencia=$fecha->diffInDays($inicio);

                    if($value->ultima_asistencia){
                        if($value->ultima_asistencia <= $fecha){
                            $value->update([
                                'status_est'=>$this->desertado
                            ]);

                            //Actualizar Matricula
                            Matricula::where('id',$value->matricula_id)
                                        ->update([
                                            'status_est'=>$this->desertado
                                        ]);

                            //Actualizar Cartera
                            Cartera::where('matricula_id', $value->matricula_id)
                                    ->update([
                                        'status_est'=>$this->desertado
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
                        if($diferencia>$margen){
                            $value->update([
                                'status_est'=>$this->desertado
                            ]);

                            //Actualizar Matricula
                            Matricula::where('id',$value->matricula_id)
                                        ->update([
                                            'status_est'=>$this->desertado
                                        ]);

                            //Actualizar Cartera
                            Cartera::where('matricula_id', $value->matricula_id)
                                    ->update([
                                        'status_est'=>$this->desertado
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
                    }

                    //Reactiva alumnos
                    if($value->status_est===$this->desertado){
                        if($value->ultima_asistencia >= $fecha){
                            $value->update([
                                'status_est'=>$this->activo
                            ]);

                            //Actualizar Matricula
                            Matricula::where('id',$value->matricula_id)
                                        ->update([
                                            'status_est'=>$this->desertado
                                        ]);

                            //Actualizar Cartera
                            Cartera::where('matricula_id', $value->matricula_id)
                                    ->update([
                                        'status_est'=>$this->desertado
                                    ]);

                            User::where('id',$value->estudiante_id)
                                    ->update([
                                        'caso_especial'=>2
                                    ]);

                            Pqrs::create([
                                'estudiante_id' =>$value->estudiante_id,
                                'gestion_id'    =>$value->matricula->creador_id,
                                'fecha'         =>now(),
                                'tipo'          =>4,
                                'observaciones' =>'ACÁDEMICO:  --- ¡REINTEGRADO! --- --- AUTOMATICO -----  ',
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
