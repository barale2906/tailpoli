<?php

namespace Database\Seeders;

use App\Models\Financiera\CierreCaja;
use App\Models\Financiera\ReciboPago;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CierreCajaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $row = 0;

        if(($handle = fopen(public_path() . '/csv/27_cierra.csv', 'r')) !== false) {

                while(($data = fgetcsv($handle, 26000, ';')) !== false) {

                    $row++;

                    $obs=now()." Creado ERP POLIANDINO.";

                    try {

                        //Determinar los recibos de caja aplicables
                        $inv=ReciboPago::where('numero_recibo', '>', intval($data[1]))
                                        ->where('numero_recibo', '<=', intval($data[2]))
                                        ->where('origen', false)
                                        ->where('creador_id', intval($data[0]))
                                        ->where('cierre', null)
                                        ->get();

                        $cart=ReciboPago::where('numero_recibo', '>', intval($data[3]))
                                        ->where('numero_recibo', '<=', intval($data[4]))
                                        ->where('origen', true)
                                        ->where('creador_id', intval($data[0]))
                                        ->where('cierre', null)
                                        ->get();

                        //Cargar Cierre de Caja
                        $cierre=CierreCaja::create([
                                            'fecha_cierre'=>$data[5],
                                            'fecha'=>$data[5],
                                            'valor_total'=>$data[7],
                                            'observaciones'=>$obs,

                                            'valor_pensiones'=>$data[8],
                                            'valor_efectivo'=>$data[9],
                                            'valor_tarjeta'=>$data[10],
                                            'valor_cheque'=>$data[11],
                                            'valor_consignacion'=>$data[12],

                                            'valor_otros'=>$data[13],
                                            'valor_efectivo_o'=>$data[14],
                                            'valor_tarjeta_o'=>$data[15],
                                            'valor_cheque_o'=>$data[16],
                                            'valor_consignacion_o'=>$data[17],

                                            'sede_id'=>$data[18],
                                            'cajero_id'=>$data[0],
                                            'coorcaja_id'=>$data[0],
                                            'dia'=>true,
                                            'status'=>1
                        ]);

                        // actualizar recibos inventario con cierres
                        if($inv){
                            foreach ($inv as $value) {
                                if($value->status===2){
                                    $status=2;
                                }else{
                                    $status=1;
                                }

                                //Actualizar recibo
                                ReciboPago::whereId($value->id)->update([
                                    'status'=>$status,
                                    'cierre'=>$cierre->id
                                ]);

                                //Cargar recibo al cierre
                                DB::table('cierre_caja_recibo_pago')
                                    ->insert([
                                        'cierre_caja_id'=>$cierre->id,
                                        'recibo_pago_id'=>$value->id,
                                        'created_at'=>$data[5],
                                        'updated_at'=>$data[6],
                                    ]);
                            }
                        }


                        // actualizar recibos cartera con cierres

                        if($cart){
                            foreach ($cart as $value) {
                                if($value->status===2){
                                    $status=2;
                                }else{
                                    $status=1;
                                }
                                //Actualizar recibo
                                ReciboPago::whereId($value->id)->update([
                                    'status'=>$status,
                                    'cierre'=>$cierre->id
                                ]);

                                //Cargar recibo al cierre
                                DB::table('cierre_caja_recibo_pago')
                                    ->insert([
                                        'cierre_caja_id'=>$cierre->id,
                                        'recibo_pago_id'=>$value->id,
                                        'created_at'=>$data[5],
                                        'updated_at'=>$data[6],
                                    ]);
                            }
                        }



                    }catch(Exception $exception){
                        Log::info('Line: ' . $row . ' 27_cierra with error: ' . $exception->getMessage().' real: '.$data[13]);
                    }
                }
        }

        fclose($handle);
    }
}
