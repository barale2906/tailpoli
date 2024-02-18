<?php

namespace Database\Seeders;

use App\Livewire\Configuracion\User\Perfil;
use App\Models\Configuracion\Sector;
use App\Models\User;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EstudianteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $row = 0;

        if(($handle = fopen(public_path() . '/csv/10-grupos-23.csv', 'r')) !== false) {

                while(($data = fgetcsv($handle, 26000, ';')) !== false) {

                    $row++;

                    try {

                        $password=bcrypt($data[3]);
                        $name=$data[1]." ".$data[2];

                        DB::table('users')->insert([
                                'id'            => intval($data[0]),
                                'name'          => strtolower($name),
                                'email'         => strtolower($data[10]),
                                'documento'     => strtolower($data[3]),
                                'password'      => $password,
                                'status'        => intval($data[4]),
                                'rol_id'        => intval($data[5]),
                                'created_at'    => intval($data[6]),
                                'updated_at'    => intval($data[7]),
                            ]);

                        $usu=User::orderBy('id', 'DESC')->first();
                        //$role=Role::where('id', intval($data[5]))->select('name')->first();
                        $usu->assignRole('Estudiante');

                        $sector=Sector::where('state_id', intval($data[9]))->first();

                        if($sector){
                            $sec=$sector->id;
                        }else{
                            $sec=1;
                        }

                        if(intval($data[9])){
                            $state=intval($data[9]);
                        }else{
                            $state=1;
                        }

                        Perfil::create([
                            'user_id'=>$usu->id,
                            'country_id'=>intval($data[8]),
                            'state_id'=>$state,
                            'sector_id'=>$sec,
                            'estado_id'=>1,
                            'regimen_salud_id'=>intval($data[11]),
                            'tipo_documento'=>strtolower($data[12]),
                            'documento'=>strtolower($data[3]),
                            'name'=>strtolower($data[1]),
                            'lastname'=>strtolower($data[2]),
                            'fecha_documento'=>$data[13],
                            'lugar_expedicion'=>strtolower($data[14]),
                            'direccion'=>strtolower($data[15]),
                            'fecha_nacimiento'=>$data[16],
                            'barrio'=>strtolower($data[17]),
                            'celular'=>strtolower($data[18]),
                            'wa'=>strtolower($data[19]),
                            'fijo'=>strtolower($data[20]),
                            'email'=>strtolower($data[10]),
                            'contacto'=>strtolower($data[21]),
                            'documento_contacto'=>strtolower($data[22]),
                            'parentesco_contacto'=>strtolower($data[23]),
                            'telefono_contacto'=>strtolower($data[24]),
                            'talla'=>strtolower($data[25]),
                            'calzado'=>strtolower($data[26]),
                            'genero'=>strtolower($data[27]),
                            'estado_civil'=>strtolower($data[28]),
                            'estrato'=>strtolower($data[29]),
                            'nivel_educativo'=>strtolower($data[30]),
                            'ocupacion'=>strtolower($data[31]),
                            'discapacidad'=>strtolower($data[32]),
                            'enfermedad'=>strtolower($data[33]),
                            'empresa_usuario'=>strtolower($data[34]),
                            'autoriza_imagen'=>strtolower($data[35]),
                            'carnet'=>strtolower($data[36]),
                            'arl_usuario'=>strtolower($data[37]),
                            'rh_usuario'=>$data[38],
                        ]);

                    }catch(Exception $exception){
                        Log::info('Line: ' . $row . ' with error: ' . $exception->getMessage());
                    }
                }
        }

        fclose($handle);
    }
}
