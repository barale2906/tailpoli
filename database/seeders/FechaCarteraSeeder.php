<?php

namespace Database\Seeders;

use App\Models\Financiera\Cartera;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FechaCarteraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cartera=Cartera::whereNotNull('fecha_real')
                            ->where('created_at', '<','2024-05-31 23:59:59')
                            ->select('id','updated_at','fecha_real','matricula_id')
                            ->get();

        foreach ($cartera as $value) {
            try {

                $crt=Carbon::create($value->updated_at)->toDateString();

                Log::info('matricula_id: ' . $value->matricula_id.' Se cargo '.$value->updated_at.' id: '.$value->id.' control: '.$crt.' real: '.$value->fecha_real);
                if($crt===$value->fecha_real){
                    Log::info('id: '.$value->id.' IGUAL ');
                }else{
                    DB::table('carteras')
                        ->where('id', $value->id)
                        ->update([
                            'fecha_real'    => $crt
                        ]);
                }

            } catch(Exception $exception){
                Log::info('matricula_id: ' . $value->matricula_id.' id: '.$value->id. ' with error: ' . $exception->getMessage());
            }
        }
    }
}
