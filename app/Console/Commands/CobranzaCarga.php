<?php

namespace App\Console\Commands;

use App\Models\Financiera\Cartera;
use App\Models\Financiera\Cobranza;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CobranzaCarga extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Cobranza:CargaMora';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Obtiene los registros de cartera vencidos con mas de un día vencido';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dias=config('dias_cobranza');
        $cobranza=config('dias_reporte');
        $tiempo=$cobranza-$dias;

        $hoy=Carbon::today()->subDays($dias);

        $carteras=Cartera::where('fecha_pago',$hoy)
                            ->where('estado_cartera_id',3)
                            ->get();

        foreach ($carteras as $value) {
            Cobranza::create([
                'cartera_id'=>$value->id,
                'alumno_id'=>$value->responsable_id,
                'sede_id'=>$value->sede_id,
                'matricula_id'=>$value->matricula_id,
                'curso_id'=>$value->matricula->curso->id,
                'dias'=>$dias,
                'diasreporte'=>$tiempo,
                'saldo'=>$value->saldo,
                'correos'=>now()." AUTOMATICO: Se carga el control de cobranza. ----- ",
                'status'=>$value->estado_cartera_id,
            ]);
        }


    }
}
