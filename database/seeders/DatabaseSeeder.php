<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(100)->create();

        \App\Models\User::factory()->create([
            'name' => 'Ing Alexander Barajas V',
            'email' => 'alexanderbarajas@gmail.com',
            'password'=>bcrypt('10203040')
        ]);
        $this->call([
            CountrySeeder::class,
            RegimenSaludSeeder::class,
            PersonaMulticulturalSeeder::class,
            EstadoSeeder::class,
            ProductoSeeder::class,
            CursoSeeder::class
        ]);
    }
}
