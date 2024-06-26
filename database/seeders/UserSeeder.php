<?php

namespace Database\Seeders;

use App\Models\Configuracion\Perfil;
use App\Models\Configuracion\Sede;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /* $super = User::factory()->create([
            'name' => 'Ing Alexander Barajas V',
            'email' => 'alexanderbarajas@gmail.com',
            'documento'=>10215300,
            'password'=>bcrypt('10203040'),
            'rol_id'=>1
        ])->assignRole('Superusuario');

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
        ]); */


                $row = 0;

                if(($handle = fopen(public_path() . '/csv/8-empleados.csv', 'r')) !== false) {

                        while(($data = fgetcsv($handle, 26000, ';')) !== false) {

                            $row++;

                            try {

                                $password=bcrypt($data[3]);
                                $email=$data[3]."@poliandinovirtual.com";
                                $name=$data[1]." ".$data[2];

                                $creado=new Carbon($data[6]);
                                $crea=$creado->format('Y-m-d H:i:s');

                                $actualiza=new Carbon($data[7]);
                                $actua=$actualiza->format('Y-m-d H:i:s');

                                DB::table('users')->insert([
                                        'id'            => intval($data[0]),
                                        'name'          => strtolower($name),
                                        'email'         => strtolower($email),
                                        'documento'     => strtolower($data[3]),
                                        'password'      => $password,
                                        'status'        => intval($data[4]),
                                        'rol_id'        => intval($data[5]),
                                        'created_at'    => $data[6],
                                        'updated_at'    => $data[7]
                                    ]);

                                $usu=User::orderBy('id', 'DESC')->first();
                                $role=Role::whereId(intval($data[5]))->select('name')->first();
                                $usu->assignRole($role->name);

                                if(intval($data[5])>1){
                                    DB::table('sede_user')
                                        ->insert([
                                            'user_id'       =>$usu->id,
                                            'sede_id'       =>$data[8],
                                            'created_at'    => $data[6],
                                            'updated_at'    => $data[7]
                                    ]);
                                }

                                Perfil::create([
                                            'user_id'=>$usu->id,
                                            'country_id'=>1,
                                            'state_id'=>1,
                                            'sector_id'=>1,
                                            'estado_id'=>1,
                                            'regimen_salud_id'=>1,
                                            'tipo_documento'=>'cédula de ciudadanía',
                                            'documento'=>strtolower($data[3]),
                                            'name'=>strtolower($data[1]),
                                            'lastname'=>strtolower($data[2])
                                ]);

                            }catch(Exception $exception){
                                Log::info('Line: ' . $row . ' 8-empleados with error: ' . $exception->getMessage());
                            }
                        }
                    }

                    fclose($handle);

                    //Cargar sedes a los superusuarios
                    $superusuarios=User::where('rol_id', 1)->get();

                    $sedes=Sede::all();

                    foreach ($sedes as $value) {
                        foreach ($superusuarios as $item) {
                            DB::table('sede_user')
                                        ->insert([
                                            'user_id'       =>$item->id,
                                            'sede_id'       =>$value->id,
                                            'created_at'    => now(),
                                            'updated_at'    => now()
                                    ]);
                        }
                    }


        /* DB::table('sede_user')
                ->insert([
                    'user_id'=>$super->id,
                    'sede_id'=>2,
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ]); */



        /* $stephany = User::factory()->create([
                    'name' => 'stephany izquierdo ocampo',
                    'email' => 'direccion@gmail.com',
                    'documento'=>10215301,
                    'password'=>bcrypt('10203040'),
                    'rol_id'=>1
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
            'password'=>bcrypt('10203040'),
            'rol_id'=>2
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
                        'password'=>bcrypt('10203040'),
                        'rol_id'=>3
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
            'password'=>bcrypt('10203040'),
            'rol_id'=>4
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
                    'password'=>bcrypt('10203040'),
                    'rol_id'=>5
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
                        'password'=>bcrypt('10203040'),
                        'rol_id'=>6
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
        $documento=9000000;
        while ($is <= 300) {

            $usu = User::factory()->create([
                'documento'=>$documento,
                'rol_id'=>5
            ])->assignRole('Profesor');

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
        $docu=10000000;
        while ($id <= 18000) {

            $usu = User::factory()->create([
                'documento'=>$docu,
                'rol_id'=>6
            ])->assignRole('Estudiante');

            Perfil::create([
                'user_id'=>$usu->id,
                'country_id'=>1,
                'sector_id'=>1,
                'state_id'=>1,
                'estado_id'=>1,
                'regimen_salud_id'=>1,
                'tipo_documento'=>'cédula de ciudadanía',
                'documento'=>$docu,
                'name'=>'estudiante '.$usu->id,
                'lastname'=>'apellido '.$usu->id
            ]);

            $id++;
            $docu++;

        } */

    }
}
