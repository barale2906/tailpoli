<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Configuracion\Estado::create([
            'name' => 'activo',
        ]);
        \App\Models\Configuracion\Estado::create([
            'name' => 'desertado',
        ]);
        \App\Models\Configuracion\Estado::create([
            'name' => 'egresado',
        ]);
        \App\Models\Configuracion\Estado::create([
            'name' => 'aplazado',
        ]);
        \App\Models\Configuracion\Estado::create([
            'name' => 'retirado',
        ]);
        \App\Models\Configuracion\Estado::create([
            'name' => 'reintegro',
        ]);
        \App\Models\Configuracion\Estado::create([
            'name' => 'acuerdo de pago',
        ]);
        \App\Models\Configuracion\Estado::create([
            'name' => 'por iniciar',
        ]);
        \App\Models\Configuracion\Estado::create([
            'name' => 'paga cuando retomen las clases',
        ]);
    }
}
