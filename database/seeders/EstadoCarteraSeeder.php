<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstadoCarteraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Financiera\EstadoCartera::create([
            'name' => 'activa',
        ]);

        \App\Models\Financiera\EstadoCartera::create([
            'name' => 'abonada',
        ]);

        \App\Models\Financiera\EstadoCartera::create([
            'name' => 'mora',
        ]);

        \App\Models\Financiera\EstadoCartera::create([
            'name' => 'castigada',
        ]);

        \App\Models\Financiera\EstadoCartera::create([
            'name' => 'convenio',
        ]);

        \App\Models\Financiera\EstadoCartera::create([
            'name' => 'cerrada',
        ]);


    }
}
