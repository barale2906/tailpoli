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
        $id=0;
        while ($id <= 1200) {
            User::factory()->create()->assignRole('Estudiante');
            $id++;
        }

        $super = User::factory()->create([
            'name' => 'Ing Alexander Barajas V',
            'email' => 'alexanderbarajas@gmail.com',
            'password'=>bcrypt('10203040')
        ])->assignRole('Superusuario');

        DB::table('sede_user')
                ->insert([
                    'user_id'=>$super->id,
                    'sede_id'=>1,
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ]);

        DB::table('sede_user')
                ->insert([
                    'user_id'=>$super->id,
                    'sede_id'=>2,
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ]);

        $stephany = User::factory()->create([
                    'name' => 'stephany izquierdo ocampo',
                    'email' => 'direccionsedea@gmail.com',
                    'password'=>bcrypt('Poliandino2023*')
                ])->assignRole('Superusuario');

                DB::table('sede_user')
                        ->insert([
                            'user_id'=>$stephany->id,
                            'sede_id'=>1,
                            'created_at'=>now(),
                            'updated_at'=>now(),
                        ]);

                DB::table('sede_user')
                        ->insert([
                            'user_id'=>$stephany->id,
                            'sede_id'=>2,
                            'created_at'=>now(),
                            'updated_at'=>now(),
                        ]);

        $admon = User::factory()->create([
            'name' => 'Administrador Barajas V',
            'email' => 'administrador@gmail.com',
            'password'=>bcrypt('10203040')
        ])->assignRole('Administrador');

        DB::table('sede_user')
                ->insert([
                    'user_id'=>$admon->id,
                    'sede_id'=>1,
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ]);

        User::factory()->create([
            'name' => 'Coordinador Barajas V',
            'email' => 'coordinador@gmail.com',
            'password'=>bcrypt('10203040')
        ])->assignRole('Coordinador');

        User::factory()->create([
            'name' => 'Auxiliar Barajas V',
            'email' => 'auxiliar@gmail.com',
            'password'=>bcrypt('10203040')
        ])->assignRole('Auxiliar');

        User::factory()->create([
            'name' => 'Profesor Barajas V',
            'email' => 'profesor@gmail.com',
            'password'=>bcrypt('10203040')
        ])->assignRole('Profesor');

        User::factory()->create([
            'name' => 'Estudiante Barajas V',
            'email' => 'estudiante@gmail.com',
            'password'=>bcrypt('10203040')
        ])->assignRole('Estudiante');
    }
}
