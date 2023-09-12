<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AlmacenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Inventario\Almacen::create([
            'name' => 'ropas',
            'sede_id'=> 1
        ]);

        \App\Models\Inventario\Almacen::create([
            'name' => 'insumos aseo',
            'sede_id'=> 1
        ]);

        \App\Models\Inventario\Almacen::create([
            'name' => 'papelería',
            'sede_id'=> 1
        ]);

        \App\Models\Inventario\Almacen::create([
            'name' => 'ropas',
            'sede_id'=> 2
        ]);

        \App\Models\Inventario\Almacen::create([
            'name' => 'insumos aseo',
            'sede_id'=> 2
        ]);

        \App\Models\Inventario\Almacen::create([
            'name' => 'papelería',
            'sede_id'=> 2
        ]);
    }
}
