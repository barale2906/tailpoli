<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Configuracion\Country::create([
            'name' => 'Colombia',
        ]);

        \App\Models\Configuracion\Country::create([
            'name' => 'Venezuela',
        ]);
        \App\Models\Configuracion\Country::create([
            'name' => 'Chile',
        ]);
        \App\Models\Configuracion\Country::create([
            'name' => 'Haiti',
        ]);
        \App\Models\Configuracion\Country::create([
            'name' => 'Otros',
        ]);
    }
}
