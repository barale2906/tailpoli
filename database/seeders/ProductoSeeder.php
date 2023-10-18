<?php

namespace Database\Seeders;

use App\Models\Inventario\Producto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Producto::create([
            'name' => 'kit overol manga corta xs',
            'descripcion'=> 'kit overol manga corta xs'
        ]);

        Producto::create([
            'name' => 'kit overol manga corta x',
            'descripcion'=> 'kit overol manga corta x'
        ]);

        Producto::create([
            'name' => 'kit overol manga corta xl',
            'descripcion'=> 'kit overol manga corta xl'
        ]);

        Producto::create([
            'name' => 'kit overol manga larga xs',
            'descripcion'=> 'kit overol manga larga xs'
        ]);

        Producto::create([
            'name' => 'kit overol manga larga x',
            'descripcion'=> 'kit overol manga larga x'
        ]);

        Producto::create([
            'name' => 'kit overol manga larga xl',
            'descripcion'=> 'kit overol manga larga xl'
        ]);
    }
}
