<?php

namespace Database\Seeders;

use App\Models\Academico\Acaplan;
use App\Models\Academico\Ciclo;
use App\Models\Academico\Ciclogrupo;
use App\Traits\AcaplanTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class PlanSeeder extends Seeder
{
    use AcaplanTrait;
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
            //Log::info('Ciclo: ' . $value->id);
            $ya=Acaplan::where('ciclo_id',$value->id)->count('ciclo_id');
            try {

                if($ya===0){
                    $grupos=Ciclogrupo::where('ciclo_id',$value->id)
                                        ->get();

                        foreach ($grupos as $item) {
                            try {
                                //$this->cronocrea($value->id,$item->fecha_inicio,$item->fecha_fin,$item->grupo_id);
                                $this->plancrea($value->id,$item->grupo_id);
                            } catch(Exception $exception){
                                Log::info('Grupo - plan: ' . $item->id. ' Error: ' . $exception->getMessage());
                            }
                        }
                } else {
                    Log::info('Ciclo: ' . $value->id.' Ya esta plan.');
                }

            } catch(Exception $exception){
                Log::info('Ciclo plan: ' . $value->id. ' Error: ' . $exception->getMessage());
            }
        }
    }
}
