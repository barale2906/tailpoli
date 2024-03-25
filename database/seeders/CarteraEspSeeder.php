<?php

namespace Database\Seeders;

use App\Models\Financiera\ConceptoPago;
use App\Models\Financiera\EstadoCartera;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CarteraEspSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $row = 0;
        $observaciones=" ----- ".now()." Creado por ERP POLIANDINO, Ajuste de registros del 642988 al 1306220 - 1307047 al 1500000 - 2057749 al 2307749 payment_agreement_id = 14204,14345,14354,14468,14469,14470, 13948 de la BD SWIP"." ----- ";

        if(($handle = fopen(public_path() . '/csv/13-cartera-2022-ene-mar.csv', 'r')) !== false) {

                while(($data = fgetcsv($handle, 26000, ';')) !== false) {

                    $row++;

                    try {

                        $creado=new Carbon($data[9]);
                        $crea=$creado->format('Y-m-d H:i:s');

                        $actualiza=new Carbon($data[10]);
                        $actua=$actualiza->format('Y-m-d H:i:s');

                        $fecha=new Carbon($data[1]);
                        $fech=$fecha->format('Y-m-d');

                        $fechaa=new Carbon($data[11]);
                        $fechb=$fechaa->format('Y-m-d');


                        //Mirar estado cartera
                        $cartera=EstadoCartera::where('name', strtolower($data[6]))->select('id')->first();
                        $concepto=ConceptoPago::where('name', strtolower($data[7]))->select('id')->first();

                        DB::table('carteras')->insert([
                            'id'                    => intval($data[0]),
                            'fecha_pago'            => $data[1],
                            'fecha_real'            => $data[9],
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
                            'updated_at'            => $data[10],
                            'sector_id'             => intval($data[11]),
                            'sede_id'               => intval($data[12]),
                        ]);

                    }catch(Exception $exception){
                        Log::info('Line: ' . $row . ' 13-cartera-2022-ene-mar with error: ' . $exception->getMessage());
                    }
                }
        }

        fclose($handle);
    }
}
