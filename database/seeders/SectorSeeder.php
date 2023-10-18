<?php

namespace Database\Seeders;

use App\Models\Configuracion\Sector;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sector::create([
            'name' => 'Soacha',
            'state_id' => 1,
        ]);
        Sector::create([
            'name' => 'Chía',
            'state_id' => 1,
        ]);
        Sector::create([
            'name' => 'Cajicá',
            'state_id' => 1,
        ]);
        Sector::create([
            'name' => 'Bogotá',
            'state_id' => 2,
        ]);
        Sector::create([
            'name' => 'Pereira',
            'state_id' => 3,
        ]);
        Sector::create([
            'name' => 'Pasto',
            'state_id' => 4,
        ]);
        Sector::create([
            'name' => 'Bucaramanga',
            'state_id' => 5,
        ]);
        Sector::create([
            'name' => 'Malaga',
            'state_id' => 5,
        ]);
    }
}
