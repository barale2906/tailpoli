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
        $hoy=Carbon::today();
;
        $controles=Control::where('status', true)
                            ->whereNotIn('status_est',[2,6,11])
                            ->whereBetween('inicia', [$inic, $hoy])
                            ->get();

        /*
            última asistencia
            si(
                mayor a la fecha de margen
                si(
                    Ya era desertado
                    si(
                        marcar reintegrado
                    )
                    no(
                        marcar activo
                    )
                )
                no(
                    Marcar desertado
                )
            )
            no(
                hoy mayor que fecha inicio
                si(
                    Marcar desertado
                )
                no(
                    Marcar con 9
                )
            )
        */

        foreach ($controles as $value) {
            Log::info('Linea control: ' . $value->id . ' VERIFICA');

            try {
                    $hoy=Carbon::today();
                    $margen=$value->ciclo->desertado+1; //Control de deserción
                    $inicio=new Carbon($value->ciclo->inicia);
                    $fecha=Carbon::today()->subDays($margen); //tIEMPO DE ASISTENCIA

                    if($value->ultima_asistencia){
                        if($value->ultima_asistencia > $fecha){
                            //Verificar si ya ERA DESERTADO
                            if($value->status_est===$this->desertado){

                                //Asignar Estado de reintegrado si hasta ahora vuelve

                                $value->update([
                                    'status_est'=>$this->activo
                                ]);

                                //Actualizar Matricula
                                Matricula::where('id',$value->matricula_id)
                                            ->update([
                                                'status_est'=>$this->activo
                                            ]);

                                //Actualizar Cartera
                                Cartera::where('matricula_id', $value->matricula_id)
                                        ->update([
                                            'status_est'=>$this->activo
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
                        if($hoy>$inicio){

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
