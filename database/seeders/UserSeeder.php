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
            'sector_id'=>1,
            'estado_id'=>1,
            'regimen_salud_id'=>1,
            'tipo_documento'=>'cédula de ciudadanía',
            'documento'=>79844910,
            'name'=>'Alexander',
            'lastname'=>'Barajas Vargas'
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

        Perfil::create([
            'user_id'=>$stephany->id,
            'country_id'=>1,
            'sector_id'=>1,
            'estado_id'=>1,
            'regimen_salud_id'=>1,
            'tipo_documento'=>'cédula de ciudadanía',
            'documento'=>1030862596,
            'name'=>'stephany',
            'lastname'=>'izquierdo ocampo'
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

        Perfil::create([
            'user_id'=>$admon->id,
            'country_id'=>1,
            'sector_id'=>1,
            'estado_id'=>1,
            'regimen_salud_id'=>1,
            'tipo_documento'=>'cédula de ciudadanía',
            'documento'=>1030862556,
            'name'=>'administrador',
            'lastname'=>'Barajas V'
        ]);

        $coordinador=User::factory()->create([
                        'name' => 'Coordinador Barajas V',
                        'email' => 'coordinador@gmail.com',
                        'password'=>bcrypt('10203040')
                    ])->assignRole('Coordinador');

        Perfil::create([
            'user_id'=>$coordinador->id,
            'country_id'=>1,
            'sector_id'=>1,
            'estado_id'=>1,
            'regimen_salud_id'=>1,
            'tipo_documento'=>'cédula de ciudadanía',
            'documento'=>52314764,
            'name'=>'coordinador',
            'lastname'=>'Barajas V'
        ]);

        $aux=User::factory()->create([
            'name' => 'Auxiliar Barajas V',
            'email' => 'auxiliar@gmail.com',
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
            'estado_id'=>1,
            'regimen_salud_id'=>1,
            'tipo_documento'=>'cédula de ciudadanía',
            'documento'=>79844911,
            'name'=>'auxiliar',
            'lastname'=>'Barajas V'
        ]);

        $profesor=User::factory()->create([
                    'name' => 'Profesor Barajas V',
                    'email' => 'profesor@gmail.com',
                    'password'=>bcrypt('10203040')
                ])->assignRole('Profesor');

        Perfil::create([
            'user_id'=>$profesor->id,
            'country_id'=>1,
            'sector_id'=>1,
            'estado_id'=>1,
            'regimen_salud_id'=>1,
            'tipo_documento'=>'cédula de ciudadanía',
            'documento'=>1233491475,
            'name'=>'profesor',
            'lastname'=>'Barajas V'
        ]);

        $estudiante=User::factory()->create([
                        'name' => 'Estudiante Barajas V',
                        'email' => 'estudiante@gmail.com',
                        'password'=>bcrypt('10203040')
                    ])->assignRole('Estudiante');

        Perfil::create([
            'user_id'=>$estudiante->id,
            'country_id'=>1,
            'sector_id'=>1,
            'estado_id'=>1,
            'regimen_salud_id'=>1,
            'tipo_documento'=>'cédula de ciudadanía',
            'documento'=>41717453,
            'name'=>'estudiante',
            'lastname'=>'Barajas V'
        ]);

        $id=0;
        $documento=1030535000;
        while ($id <= 1200) {

            $usu = User::factory()->create()->assignRole('Estudiante');

            Perfil::create([
                'user_id'=>$usu->id,
                'country_id'=>1,
                'sector_id'=>1,
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
