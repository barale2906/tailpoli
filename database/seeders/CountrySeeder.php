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
        \App\Models\Admin\Country::create([
            'name' => 'Colombia',
        ]);

        \App\Models\Admin\Country::create([
            'name' => 'Venezuela',
        ]);
        \App\Models\Admin\Country::create([
            'name' => 'Chile',
        ]);
        \App\Models\Admin\Country::create([
            'name' => 'Haiti',
        ]);
        \App\Models\Admin\Country::create([
            'name' => 'Otros',
        ]);
    }
}
