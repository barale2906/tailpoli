<?php

namespace Database\Seeders;

use App\Models\Inventario\Almacen;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AlmacenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Almacen::create([
            'name' => 'ropas',
            'sede_id'=> 1
        ]);

        Almacen::create([
            'name' => 'insumos aseo',
            'sede_id'=> 1
        ]);

        Almacen::create([
            'name' => 'papelería',
            'sede_id'=> 1
        ]);

        Almacen::create([
            'name' => 'ropas sede 2',
            'sede_id'=> 2
        ]);

        Almacen::create([
            'name' => 'insumos aseo sede 2',
            'sede_id'=> 2
        ]);

        Almacen::create([
            'name' => 'papelería sede 2',
            'sede_id'=> 2
        ]);
    }
}
