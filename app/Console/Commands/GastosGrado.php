<?php

namespace App\Console\Commands;

use App\Models\Academico\Control;
use App\Models\Financiera\ReciboPago;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\table;

class GastosGrado extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Academico:Gastos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Este comando verifica si el estudiante genero el pago de su diploma y el pago de la ceremonia de grado durante el día';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $hoy=Carbon::today()->subDay();
        //Verificr pago diploma
        $recibos= DB::table('concepto_pago_recibo_pago')
                        ->whereIn('concepto_pago_id', [15,17])
                        ->where('created_at', '>=', $hoy )
                        ->get();

        foreach ($recibos as $value) {
            $encabezado=ReciboPago::where('id', $value->recibo_pago_id)
                                    ->select('numero_recibo','paga_id')
                                    ->first();

            if($value->concepto_pago_id===15){
                Control::where('estudiante_id', $encabezado->paga_id)
                        ->whereNotIn('status_est',[2,4,11])
                        ->whereNull('ceremonia')
                        ->orderBy('id', 'ASC')
                        ->update([
                            'ceremonia'=>$encabezado->numero_recibo
                        ]);
            }
            if($value->concepto_pago_id===17){
                Control::where('estudiante_id', $encabezado->paga_id)
                        ->whereNotIn('status_est',[2,4,11])
                        ->whereNull('diploma')
                        ->orderBy('id', 'ASC')
                        ->update([
                            'diploma'=>$encabezado->numero_recibo
                        ]);
            }
        }
    }
}
