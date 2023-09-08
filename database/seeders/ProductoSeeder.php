<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Inventario\Producto::create([
            'name' => 'kit overol manga corta xs',
            'descripcion'=> 'kit overol manga corta xs'
        ]);

        \App\Models\Inventario\Producto::create([
            'name' => 'kit overol manga corta x',
            'descripcion'=> 'kit overol manga corta x'
        ]);

        \App\Models\Inventario\Producto::create([
            'name' => 'kit overol manga corta xl',
            'descripcion'=> 'kit overol manga corta xl'
        ]);

        \App\Models\Inventario\Producto::create([
            'name' => 'kit overol manga larga xs',
            'descripcion'=> 'kit overol manga larga xs'
        ]);

        \App\Models\Inventario\Producto::create([
            'name' => 'kit overol manga larga x',
            'descripcion'=> 'kit overol manga larga x'
        ]);

        \App\Models\Inventario\Producto::create([
            'name' => 'kit overol manga larga xl',
            'descripcion'=> 'kit overol manga larga xl'
        ]);
    }
}
