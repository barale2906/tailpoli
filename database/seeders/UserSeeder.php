<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(120)->create();

        User::factory()->create([
            'name' => 'Ing Alexander Barajas V',
            'email' => 'alexanderbarajas@gmail.com',
            'password'=>bcrypt('10203040')
        ])->assignRole('Superusuario');

        User::factory()->create([
            'name' => 'Administrador Barajas V',
            'email' => 'alexanderbarajas1@gmail.com',
            'password'=>bcrypt('10203040')
        ])->assignRole('Administrador');

        User::factory()->create([
            'name' => 'Coordinador Barajas V',
            'email' => 'alexanderbarajas2@gmail.com',
            'password'=>bcrypt('10203040')
        ])->assignRole('Coordinador');

        User::factory()->create([
            'name' => 'Auxiliar Barajas V',
            'email' => 'alexanderbarajas3@gmail.com',
            'password'=>bcrypt('10203040')
        ])->assignRole('Auxiliar');

        User::factory()->create([
            'name' => 'Profesor Barajas V',
            'email' => 'alexanderbarajas4@gmail.com',
            'password'=>bcrypt('10203040')
        ])->assignRole('Profesor');

        User::factory()->create([
            'name' => 'Estudiante Barajas V',
            'email' => 'alexanderbarajas5@gmail.com',
            'password'=>bcrypt('10203040')
        ])->assignRole('Estudiante');
    }
}
