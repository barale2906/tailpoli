<?php

namespace Database\Seeders;

use App\Models\Academico\Control;
use App\Models\Academico\Matricula;
use App\Models\Financiera\Cartera;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class ProximosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $Controles=Control::all();

        foreach ($Controles as $value) {
            try {
                if($value->inicia>now()){

                    Log::info('Control: ' . $value->id . ' GUARDADO. ');

                    $value->update([
                        'status_est'=>9
                    ]);

                    //Actualiza Cartera
                    Cartera::where('matricula_id',$value->matricula_id)
                                    ->update([
                                        'status_est'    =>9
                                    ]);

                    //Actuaiza Matricula
                    Matricula::where('id', $value->matricula_id)
                                    ->update([
                                        'status_est'    =>9
                                    ]);
                }
            } catch(Exception $exception){
                Log::info('Control: ' . $value->id . ' error: ' . $exception->getMessage().' linea código: '.$exception->getLine() );
            }
        }
    }
}
