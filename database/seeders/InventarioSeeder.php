<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InventarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Inventario\Inventario::create([
            'fecha_movimiento' => now(),
            'cantidad'=> 10,
            'saldo'=>10,
            'precio'=>25000,
            'descripcion'=>'inventario inicial',
            'almacen_id'=>1,
            'producto_id'=>6,
            'user_id'=>1
        ]);

        \App\Models\Inventario\Inventario::create([
            'fecha_movimiento' => now(),
            'cantidad'=> 9,
            'saldo'=>9,
            'precio'=>26200,
            'descripcion'=>'inventario inicial',
            'almacen_id'=>3,
            'producto_id'=>6,
            'user_id'=>12
        ]);

        \App\Models\Inventario\Inventario::create([
            'fecha_movimiento' => now(),
            'cantidad'=> 19,
            'saldo'=>19,
            'precio'=>27300,
            'descripcion'=>'inventario inicial',
            'almacen_id'=>5,
            'producto_id'=>6,
            'user_id'=>50
        ]);

        \App\Models\Inventario\Inventario::create([
            'fecha_movimiento' => now(),
            'cantidad'=> 100,
            'saldo'=>100,
            'precio'=>2500,
            'descripcion'=>'inventario inicial',
            'almacen_id'=>1,
            'producto_id'=>2,
            'user_id'=>1
        ]);

        \App\Models\Inventario\Inventario::create([
            'fecha_movimiento' => now(),
            'cantidad'=> 90,
            'saldo'=>90,
            'precio'=>2400,
            'descripcion'=>'inventario inicial',
            'almacen_id'=>3,
            'producto_id'=>2,
            'user_id'=>50
        ]);

        \App\Models\Inventario\Inventario::create([
            'fecha_movimiento' => now(),
            'cantidad'=> 89,
            'saldo'=>89,
            'precio'=>2700,
            'descripcion'=>'inventario inicial',
            'almacen_id'=>5,
            'producto_id'=>2,
            'user_id'=>19
        ]);
    }
}
