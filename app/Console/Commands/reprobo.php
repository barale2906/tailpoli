<?php

namespace App\Console\Commands;

use App\Models\Academico\Ciclogrupo;
use App\Models\Clientes\Pqrs;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class reprobo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Academico:aprobo-reprobo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica notas y determina si aprobo o reprobo el estudiante';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Ciclogrupo::where('fecha_fin', Carbon::today()->subDays(15))
                    ->each(function($cigr){
                        $registros= DB::table('notas_detalle')
                                        ->where('grupo_id', $cigr->grupo_id)
                                        ->where('aprobo', 0)
                                        ->get();

                            foreach ($registros as $value) {
                                if ($value->acumulado>=3) {

                                    DB::table('notas_detalle')
                                        ->where('id', $value->id)
                                        ->update([
                                            'aprobo'=>1,
                                            'observaciones'=>now()." AUTOMATICO: APROBO EL MODULO: ".$value->grupo." ----- ".$value->observaciones
                                        ]);

                                    Pqrs::create([
                                        'estudiante_id' =>$value->alumno_id,
                                        'gestion_id'    =>$value->profesor_id,
                                        'fecha'         =>now(),
                                        'tipo'          =>4,
                                        'observaciones' =>'ACÁDEMICO:  --- ¡APROBO! --- '.$value->grupo.' --- AUTOMATICO -----  ',
                                        'status'        =>4
                                    ]);

                                } else {
                                    DB::table('notas_detalle')
                                        ->where('id', $value->id)
                                        ->update([
                                            'aprobo'=>2,
                                            'observaciones'=>now()." AUTOMATICO: REPROBO EL MODULO: ".$value->grupo." ----- ".$value->observaciones
                                        ]);

                                    Pqrs::create([
                                        'estudiante_id' =>$value->alumno_id,
                                        'gestion_id'    =>$value->profesor_id,
                                        'fecha'         =>now(),
                                        'tipo'          =>4,
                                        'observaciones' =>'ACÁDEMICO:  --- ¡REPROBO! --- '.$value->grupo.' --- AUTOMATICO -----  ',
                                        'status'        =>4
                                    ]);
                                }
                            }
                    });
    }
}
