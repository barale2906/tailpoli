<?php

namespace Database\Seeders;


use App\Models\Financiera\ConfiguracionPago;
use App\Models\Inventario\PagoConfig;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InvConfSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $row = 0;
        $ids=array();

        $sedes=ConfiguracionPago::where('status', true)
                                    ->select('sector_id')
                                    ->groupBy('sector_id')
                                    ->get();

        foreach ($sedes as $value) {
            $config=PagoConfig::create([
                            'inicia'        =>'2024-01-01',
                            'finaliza'      =>'2024-12-31',
                            'descripcion'   =>'Configuración de pago para: '.$value->sector->name,
                            'sector_id'     =>$value->sector_id,
                            'status'        =>1
                        ]);

            array_push($ids, $config->id);
        }




        if(($handle = fopen(public_path() . '/csv/28_inv_precios.csv', 'r')) !== false) {

            while(($data = fgetcsv($handle, 26000, ';')) !== false) {

                $row++;

                try {

                    foreach ($ids as $value) {


                        DB::table('pago_configs_producto')
                            ->insert([
                                'pago_configs_id'   =>$value,
                                'producto_id'       =>intval($data[0]),
                                'name'              =>strtolower($data[1]),
                                'valor'             =>$data[2],
                                'created_at'        =>now(),
                                'updated_at'        =>now(),
                            ]);

                    }

                }catch(Exception $exception){
                    Log::info('Line: ' . $row . ' 28_inv_precios with error: ' . $exception->getMessage().' código: '.$exception->getCode().' linea: '.$exception->getLine());
                }
            }
        }

        fclose($handle);
    }
}
