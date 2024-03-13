<?php

namespace Database\Seeders;

use App\Models\Financiera\ConceptoPago;
use App\Models\Financiera\EstadoCartera;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CarterafinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $row = 0;
        $observaciones=" ----- ".now()." Creado por ERP POLIANDINO ----- ";

        if(($handle = fopen(public_path() . '/csv/13-cartera-FIN.csv', 'r')) !== false) {

                while(($data = fgetcsv($handle, 26000, ';')) !== false) {

                    $row++;

                    try {
                        //Mirar estado cartera
                        $cartera=EstadoCartera::where('name', strtolower($data[6]))->select('id')->first();
                        $concepto=ConceptoPago::where('name', strtolower($data[7]))->select('id')->first();

                        $data[1]=date("Y-m-d");
                        $data[11]=date("Y-m-d");
                        $data[9]=date("Y-m-d H:i:s");
                        $data[10]=date("Y-m-d H:i:s");

                        DB::table('carteras')->insert([
                            'id'                    => intval($data[0]),
                            'fecha_pago'            => $data[1],
                            'fecha_real'            => $data[11],
                            'valor'                 => intval($data[2]),
                            'saldo'                 => intval($data[3]),
                            'observaciones'         => $observaciones,
                            'status'                => intval($data[4]),
                            'matricula_id'          => intval($data[5]),
                            'estado_cartera_id'     => $cartera->id,
                            'concepto_pago_id'      => $concepto->id,
                            'concepto'              => strtolower($data[7]),
                            'responsable_id'        => intval($data[8]),
                            'created_at'            => $data[9],
                            'updated_at'            => $data[10]
                        ]);

                    }catch(Exception $exception){
                        Log::info('Line: ' . $row . ' 13-cartera-FIN with error: ' . $exception->getMessage());
                    }
                }
        }

        fclose($handle);
    }
}
