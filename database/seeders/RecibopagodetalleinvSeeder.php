<?php

namespace Database\Seeders;

use App\Models\Financiera\ConceptoPago;
use App\Models\Financiera\ReciboPago;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RecibopagodetalleinvSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $row = 0;

        if(($handle = fopen(public_path() . '/csv/15-recibos-detallesinv.csv', 'r')) !== false) {

            while(($data = fgetcsv($handle, 26000, ';')) !== false) {

                $row++;

                try {

                    $recibo=ReciboPago::where('id', intval($data[4]))->where('origen', false)->first();
                    $concepto=ConceptoPago::where('name', 'Inventario')->first();

                    $data[2]=date("Y-m-d H:i:s");
                    $data[3]=date("Y-m-d H:i:s");

                    DB::table('concepto_pago_recibo_pago')
                    ->insert([
                        'valor'             =>intval($data[0]),
                        'created_at'        =>$data[2],
                        'updated_at'        =>$data[3],
                        'tipo'              =>$concepto->tipo,
                        'medio'             =>$recibo->medio,
                        'concepto_pago_id'  =>$concepto->id,
                        'recibo_pago_id'    =>$recibo->id,
                    ]);

                }catch(Exception $exception){
                    Log::info('Line: ' . $row . ' 15-recibos-detallesinv with error: ' . $exception->getMessage());
                }
            }
        }

        fclose($handle);
    }
}
