<?php

namespace Database\Seeders;

use App\Models\Admin\RegimenSalud;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegimenSaludSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RegimenSalud::create([
            'name' => 'Sisben !',
        ]);

        RegimenSalud::create([
            'name' => 'Sisben 1',
        ]);

        RegimenSalud::create([
            'name' => 'Sisben 2',
        ]);

        RegimenSalud::create([
            'name' => 'Sisben 3',
        ]);

        RegimenSalud::create([
            'name' => 'Sisben 4',
        ]);
    }
}
