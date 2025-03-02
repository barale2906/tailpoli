<?php

namespace Database\Seeders;

use App\Models\Academico\Ciclo;
use App\Models\Academico\Ciclogrupo;
use App\Models\Academico\Cronograma;
use App\Traits\AcaplanTrait;
use App\Traits\CronogramaTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class CronoPlanSeeder extends Seeder
{
    use CronogramaTrait;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hoy=Carbon::today();
        $ciclos=Ciclo::where('finaliza','>', $hoy)
                    ->where('status',1)
                    ->select('id')
                    ->get();

        foreach ($ciclos as $value) {
            $ya=Cronograma::where('ciclo_id',$value->id)->count('ciclo_id');
            //Log::info('Ciclo: ' . $value->id);
            try {

                if ($ya===0) {
                    $grupos=Ciclogrupo::where('ciclo_id',$value->id)
                                        ->get();

                    foreach ($grupos as $item) {
                        try {
                            $this->cronocrea($value->id,$item->fecha_inicio,$item->fecha_fin,$item->grupo_id);
                            //$this->plancrea($value->id,$item->grupo_id);
                        } catch(Exception $exception){
                            Log::info('Grupo crono: ' . $item->grupo_id. ' Error: ' . $exception->getMessage());
                        }
                    }
                } else {
                    Log::info('Ciclo: ' . $value->id.' Ya esta crono.');
                }

            } catch(Exception $exception){
                Log::info('Ciclo Crono: ' . $value->id. ' Error: ' . $exception->getMessage());
            }
        }
    }
}
