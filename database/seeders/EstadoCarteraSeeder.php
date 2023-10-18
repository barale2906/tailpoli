<?php

namespace Database\Seeders;

use App\Models\Financiera\EstadoCartera;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstadoCarteraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EstadoCartera::create([
            'name' => 'activa',
        ]);

        EstadoCartera::create([
            'name' => 'abonada',
        ]);

        EstadoCartera::create([
            'name' => 'mora',
        ]);

        EstadoCartera::create([
            'name' => 'castigada',
        ]);

        EstadoCartera::create([
            'name' => 'convenio',
        ]);

        EstadoCartera::create([
            'name' => 'cerrada',
        ]);

        EstadoCartera::create([
            'name' => 'anulada',
        ]);


    }
}
