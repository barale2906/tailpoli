<?php

namespace Database\Seeders;

use App\Models\Financiera\ConceptoPago;
use App\Models\Financiera\ReciboPago;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RecibopagodetalleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $row = 0;

        if(($handle = fopen(public_path() . '/csv/14-recibos-detalles.csv', 'r')) !== false) {

            while(($data = fgetcsv($handle, 26000, ';')) !== false) {

                $row++;

                try {

                    $recibo=ReciboPago::where('numero_recibo', intval($data[4]))->where('origen', true)->first();
                    $concepto=ConceptoPago::where('name', 'like', '%'.$data[5].'%')->first();

                    $creado=new Carbon($data[2]);
                    $crea=$creado->format('Y-m-d H:i:s');

                    $actualiza=new Carbon($data[3]);
                    $actua=$actualiza->format('Y-m-d H:i:s');

                    DB::table('concepto_pago_recibo_pago')
                    ->insert([
                        'valor'             =>intval($data[0]),
                        'id_relacional'     =>intval($data[1]),
                        'created_at'        =>$data[2],
                        'updated_at'        =>$data[3],
                        'tipo'              =>$concepto->tipo,
                        'medio'             =>$recibo->medio,
                        'concepto_pago_id'  =>$concepto->id,
                        'recibo_pago_id'    =>$recibo->id,
                    ]);

                }catch(Exception $exception){
                    Log::info('Line: ' . $row . ' 14-recibos-detalles with error: ' . $exception->getMessage());
                }
            }
        }

        fclose($handle);
    }
}
