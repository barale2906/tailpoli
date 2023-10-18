<?php

namespace Database\Seeders;

use App\Models\Configuracion\Estado;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Estado::create([
            'name' => 'activo',
        ]);
        Estado::create([
            'name' => 'desertado',
        ]);
        Estado::create([
            'name' => 'egresado',
        ]);
        Estado::create([
            'name' => 'aplazado',
        ]);
        Estado::create([
            'name' => 'retirado',
        ]);
        Estado::create([
            'name' => 'reintegro',
        ]);
        Estado::create([
            'name' => 'acuerdo de pago',
        ]);
        Estado::create([
            'name' => 'por iniciar',
        ]);
        Estado::create([
            'name' => 'paga cuando retomen las clases',
        ]);
    }
}
