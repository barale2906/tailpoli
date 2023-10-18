<?php

namespace Database\Seeders;

use App\Models\Configuracion\EstadoUsuario;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstadoUsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EstadoUsuario::create([
            'name' => 'activo',
        ]);
        EstadoUsuario::create([
            'name' => 'aplazado',
        ]);
        EstadoUsuario::create([
            'name' => 'acuerdo de pago',
        ]);
        EstadoUsuario::create([
            'name' => 'desertado',
        ]);
        EstadoUsuario::create([
            'name' => 'egresado',
        ]);
        EstadoUsuario::create([
            'name' => 'inactivo',
        ]);
        EstadoUsuario::create([
            'name' => 'reintegro',
        ]);
        EstadoUsuario::create([
            'name' => 'retirado',
        ]);
    }
}
