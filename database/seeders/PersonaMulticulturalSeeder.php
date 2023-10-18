<?php

namespace Database\Seeders;

use App\Models\Admin\PersonaMulticultural;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PersonaMulticulturalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PersonaMulticultural::create([
            'name' => 'cabeza de familia',
        ]);
        PersonaMulticultural::create([
            'name' => 'desplazado',
        ]);
        PersonaMulticultural::create([
            'name' => 'indigena',
        ]);
        PersonaMulticultural::create([
            'name' => 'población de frontera',
        ]);
        PersonaMulticultural::create([
            'name' => 'población room',
        ]);
        PersonaMulticultural::create([
            'name' => 'reinsertado',
        ]);
        PersonaMulticultural::create([
            'name' => 'tipo cultural',
        ]);
    }
}
