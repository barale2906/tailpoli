<?php

namespace App\Console\Commands;

use App\Models\Academico\Control;
use App\Models\Financiera\Cartera;
use Carbon\Carbon;
use Illuminate\Console\Command;

class cargaMora extends Command
{
    public $deuda;
    public $id;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Cartera:cargaMora';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualiza la mora en la tabla de control';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Cartera::where('fecha_pago', Carbon::today()->subDay())
                ->where('saldo', '>', 0)
                ->each(function($cart){
                    $this->deuda=$cart->saldo;
                    Control::where('status', true)
                            ->where('estudiante_id', $cart->responsable_id)
                            ->each(function($crt){
                                $valor=$crt->mora;
                                $crt->update([
                                    'mora'=>$valor+$this->deuda,
                                ]);
                            });
                });
    }
}
