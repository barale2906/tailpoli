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
            'tipo' => 'todos',
        ]);
        Estado::create([
            'name' => 'inactivo',
            'tipo' => 'todos',
        ]);
        Estado::create([
            'name' => 'desertado',
            'tipo' => 'estudiante',
        ]);
        Estado::create([
            'name' => 'egresado',
            'tipo' => 'estudiante',
        ]);
        Estado::create([
            'name' => 'aplazado',
            'tipo' => 'estudiante',
        ]);
        Estado::create([
            'name' => 'retirado',
            'tipo' => 'estudiante',
        ]);
        Estado::create([
            'name' => 'reintegro',
            'tipo' => 'estudiante',
        ]);
        Estado::create([
            'name' => 'acuerdo de pago',
            'tipo' => 'estudiante',
        ]);
        Estado::create([
            'name' => 'por iniciar',
            'tipo' => 'estudiante',
        ]);
        Estado::create([
            'name' => 'paga cuando retomen las clases',
            'tipo' => 'estudiante',
        ]);
    }
}
