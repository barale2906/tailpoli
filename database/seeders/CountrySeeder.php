<?php

namespace Database\Seeders;

use App\Models\Configuracion\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Country::create([
            'name' => 'Colombia',
        ]);

        Country::create([
            'name' => 'Venezuela',
        ]);

        Country::create([
            'name' => 'Otros',
        ]);

        Country::create([
            'name' => 'Chile',
        ]);
        Country::create([
            'name' => 'Haiti',
        ]);
        Country::create([
            'name' => 'Alemania',
        ]);
    }
}
