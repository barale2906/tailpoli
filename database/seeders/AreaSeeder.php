<?php

namespace Database\Seeders;

use App\Models\Configuracion\Area;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Area::create([
            'name'       => 'Laboratorio Electrónica'
        ]);
        Area::create([
            'name'       => 'Laboratorio Diesel'
        ]);
        Area::create([
            'name'       => 'Aerografía'
        ]);
        Area::create([
            'name'       => 'Aula 101'
        ]);
        Area::create([
            'name'       => 'Aula 102'
        ]);
        Area::create([
            'name'       => 'Aula 103'
        ]);
        Area::create([
            'name'       => 'Aula 104'
        ]);
        Area::create([
            'name'       => 'Aula 201'
        ]);
        Area::create([
            'name'       => 'Aula 202'
        ]);
        Area::create([
            'name'       => 'Aula 203'
        ]);
        Area::create([
            'name'       => 'Aula 204'
        ]);
        Area::create([
            'name'       => 'Aula 301'
        ]);
        Area::create([
            'name'       => 'Aula 302'
        ]);
        Area::create([
            'name'       => 'Aula 303'
        ]);
        Area::create([
            'name'       => 'Aula 304'
        ]);
        Area::create([
            'name'       => 'Aula 401'
        ]);
        Area::create([
            'name'       => 'Aula 402'
        ]);
        Area::create([
            'name'       => 'Aula 403'
        ]);
        Area::create([
            'name'       => 'Aula 404'
        ]);
        Area::create([
            'name'       => 'Aula 501'
        ]);
        Area::create([
            'name'       => 'Aula 502'
        ]);
        Area::create([
            'name'       => 'Aula 503'
        ]);
        Area::create([
            'name'       => 'Aula 504'
        ]);
    }
}
