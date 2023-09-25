<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(120)->create();

        $super = User::factory()->create([
            'name' => 'Ing Alexander Barajas V',
            'email' => 'alexanderbarajas@gmail.com',
            'password'=>bcrypt('10203040')
        ])->assignRole('Superusuario');

        DB::table('users_sedes')
                ->insert([
                    'user_id'=>$super->id,
                    'sede_id'=>1,
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ]);

        DB::table('users_sedes')
                ->insert([
                    'user_id'=>$super->id,
                    'sede_id'=>2,
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ]);

        $admon = User::factory()->create([
            'name' => 'Administrador Barajas V',
            'email' => 'alexanderbarajas1@gmail.com',
            'password'=>bcrypt('10203040')
        ])->assignRole('Administrador');

        DB::table('users_sedes')
                ->insert([
                    'user_id'=>$admon->id,
                    'sede_id'=>1,
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ]);

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
