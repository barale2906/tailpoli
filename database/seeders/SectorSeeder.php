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
            'slug' => 'soac',
            'state_id' => 1,
        ]);
        Sector::create([
            'name' => 'Chía',
            'slug' => 'chia',
            'state_id' => 1,
        ]);
        Sector::create([
            'name' => 'Cajicá',
            'slug' => 'caji',
            'state_id' => 1,
        ]);
        Sector::create([
            'name' => 'Bogotá',
            'slug' => 'bta',
            'state_id' => 2,
        ]);
        Sector::create([
            'name' => 'Pereira',
            'slug' => 'pere',
            'state_id' => 3,
        ]);
        Sector::create([
            'name' => 'Pasto',
            'slug' => 'past',
            'state_id' => 4,
        ]);
        Sector::create([
            'name' => 'Bucaramanga',
            'slug' => 'buca',
            'state_id' => 5,
        ]);
        Sector::create([
            'name' => 'Malaga',
            'slug' => 'malag',
            'state_id' => 5,
        ]);
    }
}
