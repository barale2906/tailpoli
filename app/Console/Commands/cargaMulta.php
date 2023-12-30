<?php

namespace App\Console\Commands;

use App\Models\Financiera\Cartera;
use App\Models\Financiera\ConceptoPago;
use Carbon\Carbon;
use Illuminate\Console\Command;

class cargaMulta extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Cartera:cargaMulta';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Carga el valor de las multas por mora de un día';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        Cartera::where('fecha_pago', Carbon::today()->subDay())
                ->each(function($cart){

                    $multa=ConceptoPago::where('name', 'Recargo Mora')
                            ->where('tipo', 'financiero')
                            ->where('status', true)
                            ->select('valor','id','name')
                            ->first();


                    Cartera::create([
                        'fecha_pago'=>now(),
                        'valor'=>$multa->valor,
                        'saldo'=>$multa->valor,
                        'observaciones'=>'Se carga multa por no pago de la cuota del: '.$cart->fecha_pago.', por $'.number_format($cart->saldo, 0, '.', ' '),
                        'matricula_id'=>$cart->matricula_id,
                        'concepto_pago_id'=>$multa->id,
                        'concepto'=>$multa->name,
                        'responsable_id'=>$cart->responsable_id,
                        'estado_cartera_id'=>1
                    ]);
                });

    }
}
