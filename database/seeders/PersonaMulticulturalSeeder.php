<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PersonaMulticulturalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Admin\PersonaMulticultural::create([
            'name' => 'cabeza de familia',
        ]);
        \App\Models\Admin\PersonaMulticultural::create([
            'name' => 'desplazado',
        ]);
        \App\Models\Admin\PersonaMulticultural::create([
            'name' => 'indigena',
        ]);
        \App\Models\Admin\PersonaMulticultural::create([
            'name' => 'población de frontera',
        ]);
        \App\Models\Admin\PersonaMulticultural::create([
            'name' => 'población room',
        ]);
        \App\Models\Admin\PersonaMulticultural::create([
            'name' => 'reinsertado',
        ]);
        \App\Models\Admin\PersonaMulticultural::create([
            'name' => 'tipo cultural',
        ]);
    }
}
