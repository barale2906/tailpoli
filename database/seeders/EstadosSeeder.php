<?php

namespace Database\Seeders;

use App\Models\Academico\Control;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class EstadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $inic=Carbon::today()->subMonths(20);
;
        $controles=Control::all();

        foreach ($controles as $value) {
            try {
                Log::info(' id_control: '.$value->id.' VERIFICADO.');
                if ($value->inicia<$inic) {
                    $value->update([
                        'status_est'=>2
                    ]);
                }else{
                    $value->update([
                        'status_est'=>3
                    ]);
                }
            } catch(Exception $exception){
                Log::info('Control: ' . $value->id . ' error: ' . $exception->getMessage().' linea código: '.$exception->getLine() );
            }
        }
    }
}
