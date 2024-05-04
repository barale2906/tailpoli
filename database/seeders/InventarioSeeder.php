<?php

namespace Database\Seeders;

use App\Models\Inventario\Inventario;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class InventarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $row = 0;

        if(($handle = fopen(public_path() . '/csv/26_inventario.csv', 'r')) !== false) {

            while(($data = fgetcsv($handle, 26000, ';')) !== false) {

                $row++;

                try {

                    Inventario::create([
                        'tipo'                  =>1,
                        'fecha_movimiento'      =>now(),
                        'cantidad'              =>intval($data[0]),
                        'saldo'                 =>intval($data[0]),
                        'precio'                =>1,
                        'descripcion'           =>'POLIANDINO INVENTARIO INICIAL.',
                        'status'                =>1,
                        'entregado'             =>1,
                        'almacen_id'            =>intval($data[1]),
                        'producto_id'           =>intval($data[2]),
                        'user_id'               =>108
                    ]);

                }catch(Exception $exception){
                    Log::info('Line: ' . $row . ' 26_inventario with error: ' . $exception->getMessage().' código: '.$exception->getCode().' linea: '.$exception->getLine());
                }
            }
        }

        fclose($handle);

        /* Inventario::create([
            'fecha_movimiento' => now(),
            'cantidad'=> 10,
            'saldo'=>10,
            'precio'=>25000,
            'descripcion'=>'inventario inicial',
            'almacen_id'=>1,
            'producto_id'=>6,
            'user_id'=>1
        ]);

        Inventario::create([
            'fecha_movimiento' => now(),
            'cantidad'=> 9,
            'saldo'=>9,
            'precio'=>26200,
            'descripcion'=>'inventario inicial',
            'almacen_id'=>3,
            'producto_id'=>6,
            'user_id'=>12
        ]);

        Inventario::create([
            'fecha_movimiento' => now(),
            'cantidad'=> 19,
            'saldo'=>19,
            'precio'=>27300,
            'descripcion'=>'inventario inicial',
            'almacen_id'=>5,
            'producto_id'=>6,
            'user_id'=>50
        ]);

        Inventario::create([
            'fecha_movimiento' => now(),
            'cantidad'=> 100,
            'saldo'=>100,
            'precio'=>2500,
            'descripcion'=>'inventario inicial',
            'almacen_id'=>1,
            'producto_id'=>2,
            'user_id'=>1
        ]);

        Inventario::create([
            'fecha_movimiento' => now(),
            'cantidad'=> 90,
            'saldo'=>90,
            'precio'=>2400,
            'descripcion'=>'inventario inicial',
            'almacen_id'=>3,
            'producto_id'=>2,
            'user_id'=>50
        ]);

        Inventario::create([
            'fecha_movimiento' => now(),
            'cantidad'=> 89,
            'saldo'=>89,
            'precio'=>2700,
            'descripcion'=>'inventario inicial',
            'almacen_id'=>5,
            'producto_id'=>2,
            'user_id'=>19
        ]); */
    }
}
