<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Configuracion\Area::create([
            'name'       => 'Aula 101'
        ]);
        \App\Models\Configuracion\Area::create([
            'name'       => 'Aula 102'
        ]);
        \App\Models\Configuracion\Area::create([
            'name'       => 'Aula 103'
        ]);
        \App\Models\Configuracion\Area::create([
            'name'       => 'Aula 104'
        ]);
        \App\Models\Configuracion\Area::create([
            'name'       => 'Aula 201'
        ]);
        \App\Models\Configuracion\Area::create([
            'name'       => 'Aula 202'
        ]);
        \App\Models\Configuracion\Area::create([
            'name'       => 'Aula 203'
        ]);
        \App\Models\Configuracion\Area::create([
            'name'       => 'Aula 204'
        ]);
        \App\Models\Configuracion\Area::create([
            'name'       => 'Aula 301'
        ]);
        \App\Models\Configuracion\Area::create([
            'name'       => 'Aula 302'
        ]);
        \App\Models\Configuracion\Area::create([
            'name'       => 'Aula 303'
        ]);
        \App\Models\Configuracion\Area::create([
            'name'       => 'Aula 304'
        ]);
        \App\Models\Configuracion\Area::create([
            'name'       => 'Aula 401'
        ]);
        \App\Models\Configuracion\Area::create([
            'name'       => 'Aula 402'
        ]);
        \App\Models\Configuracion\Area::create([
            'name'       => 'Aula 403'
        ]);
        \App\Models\Configuracion\Area::create([
            'name'       => 'Aula 404'
        ]);
        \App\Models\Configuracion\Area::create([
            'name'       => 'Aula 501'
        ]);
        \App\Models\Configuracion\Area::create([
            'name'       => 'Aula 502'
        ]);
        \App\Models\Configuracion\Area::create([
            'name'       => 'Aula 503'
        ]);
        \App\Models\Configuracion\Area::create([
            'name'       => 'Aula 504'
        ]);
        \App\Models\Configuracion\Area::create([
            'name'       => 'Laboratorio Electrónica'
        ]);
        \App\Models\Configuracion\Area::create([
            'name'       => 'Laboratorio Diesel'
        ]);
        \App\Models\Configuracion\Area::create([
            'name'       => 'Aerografía'
        ]);
        \App\Models\Configuracion\Area::create([
            'name'       => 'Almacén'
        ]);
    }
}
