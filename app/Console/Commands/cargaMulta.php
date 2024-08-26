<?php

namespace App\Console\Commands;

use App\Models\Clientes\Pqrs;
use App\Models\Financiera\Cartera;
use App\Models\Financiera\ConceptoPago;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class cargaMulta extends Command
{
    public $multa;
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
        $this->multa=ConceptoPago::where('name', 'Recargo Mora')
                            ->where('tipo', 'financiero')
                            ->where('status', true)
                            ->select('valor','id','name')
                            ->first();

        /* Cartera::where('fecha_pago', Carbon::today()->subDay())
                ->where('saldo', '>', 0)
                ->each(function($cart){

                    Cartera::create([
                        'fecha_pago'=>$cart->fecha_pago,
                        'valor'=>$this->multa->valor,
                        'saldo'=>$this->multa->valor,
                        'observaciones'=>'Se carga multa por no pago de la cuota del: '.$cart->fecha_pago.', por $'.number_format($cart->saldo, 0, '.', ' '),
                        'matricula_id'=>$cart->matricula_id,
                        'concepto_pago_id'=>$this->multa->id,
                        'concepto'=>$this->multa->name,
                        'responsable_id'=>$cart->responsable_id,
                        'estado_cartera_id'=>1,
                        'sede_id'=>$cart->sede_id,
                        'sector_id'=>$cart->sector_id
                    ]);

                    Pqrs::create([
                        'estudiante_id' =>$cart->responsable_id,
                        'gestion_id'    =>$cart->matricula->creador_id,
                        'fecha'         =>now(),
                        'tipo'          =>2,
                        'observaciones' =>'PAGO: Se carga multa por no pago en la fecha establecida. ----- ',
                        'status'        =>4
                    ]);
                }); */

        $vencida=Cartera::where('fecha_pago', Carbon::today()->subDay())
                        ->where('status', '<',5)
                        ->whereNotIn('status_est',[2,6,11])
                        ->where('saldo', '>', 0)
                        ->get();

        foreach ($vencida as $value) {
            try {

                    Cartera::create([
                        'fecha_pago'=>$value->fecha_pago,
                        'valor'=>$this->multa->valor,
                        'saldo'=>$this->multa->valor,
                        'observaciones'=>'Se carga multa por no pago de la cuota del: '.$value->fecha_pago.', por $'.number_format($value->saldo, 0, '.', ' '),
                        'matricula_id'=>$value->matricula_id,
                        'concepto_pago_id'=>$this->multa->id,
                        'concepto'=>$this->multa->name,
                        'responsable_id'=>$value->responsable_id,
                        'estado_cartera_id'=>1,
                        'sede_id'=>$value->sede_id,
                        'sector_id'=>$value->sector_id,
                        'status_est'=>$value->status_est
                    ]);

                    Pqrs::create([
                        'estudiante_id' =>$value->responsable_id,
                        'gestion_id'    =>$value->matricula->creador_id,
                        'fecha'         =>now(),
                        'tipo'          =>2,
                        'observaciones' =>'PAGO: Se carga multa por no pago en la fecha establecida. ----- ',
                        'status'        =>4
                    ]);

            } catch(Exception $exception){
                Log::info('Linea cartera: ' . $value->id . ' CargaMulta No permitio registrar: ' . $exception->getMessage().' control: '.$exception->getLine());
            }
        }

    }
}
