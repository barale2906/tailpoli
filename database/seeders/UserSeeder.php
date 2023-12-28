<?php

namespace Database\Seeders;

use App\Models\Configuracion\Perfil;
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
        $super = User::factory()->create([
            'name' => 'Ing Alexander Barajas V',
            'email' => 'alexanderbarajas@gmail.com',
            'documento'=>10215300,
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

        Perfil::create([
            'user_id'=>$super->id,
            'country_id'=>1,
            'state_id'=>1,
            'sector_id'=>1,
            'estado_id'=>1,
            'regimen_salud_id'=>1,
            'tipo_documento'=>'cédula de ciudadanía',
            'documento'=>10215300,
            'name'=>'Alexander',
            'lastname'=>'Barajas Vargas'
        ]);

        $stephany = User::factory()->create([
                    'name' => 'stephany izquierdo ocampo',
                    'email' => 'direccion@gmail.com',
                    'documento'=>10215301,
                    'password'=>bcrypt('10203040')
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

        Perfil::create([
            'user_id'=>$stephany->id,
            'country_id'=>1,
            'sector_id'=>1,
            'state_id'=>1,
            'estado_id'=>1,
            'regimen_salud_id'=>1,
            'tipo_documento'=>'cédula de ciudadanía',
            'documento'=>10215301,
            'name'=>'stephany',
            'lastname'=>'izquierdo ocampo'
        ]);

        $admon = User::factory()->create([
            'name' => 'Administrador Barajas V',
            'email' => 'administrador@gmail.com',
            'documento'=>10215302,
            'password'=>bcrypt('10203040')
        ])->assignRole('Administrador');

        DB::table('sede_user')
                ->insert([
                    'user_id'=>$admon->id,
                    'sede_id'=>1,
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ]);

        Perfil::create([
            'user_id'=>$admon->id,
            'country_id'=>1,
            'sector_id'=>1,
            'state_id'=>1,
            'estado_id'=>1,
            'regimen_salud_id'=>1,
            'tipo_documento'=>'cédula de ciudadanía',
            'documento'=>10215302,
            'name'=>'administrador',
            'lastname'=>'Barajas V'
        ]);

        $coordinador=User::factory()->create([
                        'name' => 'Coordinador Barajas V',
                        'email' => 'coordinador@gmail.com',
                        'documento'=>10215303,
                        'password'=>bcrypt('10203040')
                    ])->assignRole('Coordinador');

        Perfil::create([
            'user_id'=>$coordinador->id,
            'country_id'=>1,
            'sector_id'=>1,
            'state_id'=>1,
            'estado_id'=>1,
            'regimen_salud_id'=>1,
            'tipo_documento'=>'cédula de ciudadanía',
            'documento'=>10215303,
            'name'=>'coordinador',
            'lastname'=>'Barajas V'
        ]);

        $aux=User::factory()->create([
            'name' => 'Auxiliar Barajas V',
            'email' => 'auxiliar@gmail.com',
            'documento'=>10215304,
            'password'=>bcrypt('10203040')
        ])->assignRole('Auxiliar');

        DB::table('sede_user')
                ->insert([
                    'user_id'=>$aux->id,
                    'sede_id'=>1,
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ]);

        Perfil::create([
            'user_id'=>$aux->id,
            'country_id'=>1,
            'sector_id'=>1,
            'state_id'=>1,
            'estado_id'=>1,
            'regimen_salud_id'=>1,
            'tipo_documento'=>'cédula de ciudadanía',
            'documento'=>10215304,
            'name'=>'auxiliar',
            'lastname'=>'Barajas V'
        ]);

        $profesor=User::factory()->create([
                    'name' => 'Profesor Barajas V',
                    'email' => 'profesor@gmail.com',
                    'documento'=>10215305,
                    'password'=>bcrypt('10203040')
                ])->assignRole('Profesor');

        Perfil::create([
            'user_id'=>$profesor->id,
            'country_id'=>1,
            'sector_id'=>1,
            'state_id'=>1,
            'estado_id'=>1,
            'regimen_salud_id'=>1,
            'tipo_documento'=>'cédula de ciudadanía',
            'documento'=>10215305,
            'name'=>'profesor',
            'lastname'=>'Barajas V'
        ]);

        $estudiante=User::factory()->create([
                        'name' => 'Estudiante Barajas V',
                        'email' => 'estudiante@gmail.com',
                        'documento'=>10215306,
                        'password'=>bcrypt('10203040')
                    ])->assignRole('Estudiante');

        Perfil::create([
            'user_id'=>$estudiante->id,
            'country_id'=>1,
            'sector_id'=>1,
            'state_id'=>1,
            'estado_id'=>1,
            'regimen_salud_id'=>1,
            'tipo_documento'=>'cédula de ciudadanía',
            'documento'=>10215306,
            'name'=>'estudiante',
            'lastname'=>'Barajas V'
        ]);

        $is=0;
        $documento=10215307;
        while ($is <= 30) {

            $usu = User::factory()->create()->assignRole('Profesor');

            Perfil::create([
                'user_id'=>$usu->id,
                'country_id'=>1,
                'sector_id'=>1,
                'state_id'=>1,
                'estado_id'=>1,
                'regimen_salud_id'=>1,
                'tipo_documento'=>'cédula de ciudadanía',
                'documento'=>$documento,
                'name'=>'profesor '.$usu->id,
                'lastname'=>'profesor '.$usu->id
            ]);

            $is++;
            $documento++;

        }

        $id=0;
        $documento=10315300;
        while ($id <= 100) {

            $usu = User::factory()->create()->assignRole('Estudiante');

            Perfil::create([
                'user_id'=>$usu->id,
                'country_id'=>1,
                'sector_id'=>1,
                'state_id'=>1,
                'estado_id'=>1,
                'regimen_salud_id'=>1,
                'tipo_documento'=>'cédula de ciudadanía',
                'documento'=>$documento,
                'name'=>'estudiante '.$usu->id,
                'lastname'=>'apellido '.$usu->id
            ]);

            $id++;
            $documento++;

        }


    }
}
