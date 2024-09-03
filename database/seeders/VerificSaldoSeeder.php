<?php

namespace Database\Seeders;

use App\Models\Financiera\Cartera;
use App\Models\User;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class VerificSaldoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $row = 0;

        if(($handle = fopen(public_path() . '/csv/Activa_estudiante.csv', 'r')) !== false) {

                while(($data = fgetcsv($handle, 26000, ';')) !== false) {

                    try {

                        $estudiante=User::where('documento',$data[0])->first();

                        //Consultar Cartera
                        $datos=Cartera::where('responsable_id', $estudiante->id)
                                        ->get();

                        foreach ($datos as $value) {
                            Log::info('* row: *'.$row.'* Matricula: * '.$value->matricula_id.' * Dcoumento: * ' . $estudiante->documento . ' * Nombre: * '.$estudiante->name.' * fecha pago: * '.$value->fecha_pago.' * fecha real: * '.$value->fecha_real.' * valor: * '.$value->valor.' * saldo: * '.$value->saldo.' * descuento: * '.$value->descuento.' * status: * '.$value->status.' * status_est: * '.$value->status_est.' * concepto: * '.$value->concepto);
                        }



                    }catch(Exception $exception){
                        Log::info('Line: ' . $row . ' Verifica saldo with error: '.$data[0]."--" . $exception->getMessage().' codigo: '.$exception->getLine());
                    }
                    $row++;
                }
        }

        fclose($handle);
    }
}
