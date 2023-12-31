<?php

namespace App\Console\Commands;

use App\Models\Academico\Control;
use App\Models\Clientes\Pqrs;
use App\Models\Configuracion\Estado;
use Carbon\Carbon;
use Illuminate\Console\Command;

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

        Control::where('ultima_asistencia', Carbon::today()->subMonth())
                ->each(function($cicl){
                    $cicl->update([
                        'status_est'=>$this->desertado
                    ]);

                    Pqrs::create([
                        'estudiante_id' =>$cicl->estudiante_id,
                        'gestion_id'    =>$cicl->matricula->creador_id,
                        'fecha'         =>now(),
                        'tipo'          =>4,
                        'observaciones' =>'ACÁDEMICO:  --- ¡DESERTADO! --- --- AUTOMATICO -----  ',
                        'status'        =>4
                    ]);
                });
        //Verificar si sale de deserción
        $con=Estado::where('status', true)
                    ->where('name', 'reintegro')
                    ->select('id')
                    ->first();

        $this->activo=$con->id;

        Control::where('ultima_asistencia', '>' ,Carbon::today()->subMonth())
                ->where('status_est', $this->desertado)
                ->each(function($cicl){
                    $cicl->update([
                        'status_est'=>$this->activo
                    ]);

                    Pqrs::create([
                        'estudiante_id' =>$cicl->estudiante_id,
                        'gestion_id'    =>$cicl->matricula->creador_id,
                        'fecha'         =>now(),
                        'tipo'          =>4,
                        'observaciones' =>'ACÁDEMICO:  --- ¡REINTEGRADO! --- --- AUTOMATICO -----  ',
                        'status'        =>4
                    ]);
                });

    }
}
