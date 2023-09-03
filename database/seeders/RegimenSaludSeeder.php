<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegimenSaludSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Admin\RegimenSalud::create([
            'name' => 'Sisben !',
        ]);

        \App\Models\Admin\RegimenSalud::create([
            'name' => 'Sisben 1',
        ]);

        \App\Models\Admin\RegimenSalud::create([
            'name' => 'Sisben 2',
        ]);

        \App\Models\Admin\RegimenSalud::create([
            'name' => 'Sisben 3',
        ]);

        \App\Models\Admin\RegimenSalud::create([
            'name' => 'Sisben 4',
        ]);
    }
}
