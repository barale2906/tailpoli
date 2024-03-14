<?php

namespace Database\Seeders;

use App\Models\Configuracion\Perfil;
use App\Models\Configuracion\Sector;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class EstudianteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $row = 0;

        if(($handle = fopen(public_path() . '/csv/11-students-completo.csv', 'r')) !== false) {

                while(($data = fgetcsv($handle, 90000, ';')) !== false) {

                    $row++;

                    try {

                        $password=bcrypt($data[3]);
                        $name=$data[1]." ".$data[2];

                        //fechas
                        $creado=new Carbon($data[6]);
                        $crea=$creado->format('Y-m-d H:i:s');

                        $actualiza=new Carbon($data[7]);
                        $actua=$actualiza->format('Y-m-d H:i:s');

                        DB::table('users')->insert([
                                'id'            => intval($data[0]),
                                'name'          => strtolower($name),
                                'email'         => strtolower($data[10]),
                                'documento'     => strtolower($data[3]),
                                'password'      => $password,
                                'status'        => intval($data[4]),
                                'rol_id'        => intval($data[5]),
                                'created_at'    => $data[6],
                                'updated_at'    => $data[7],
                            ]);

                        $usu=User::orderBy('id', 'DESC')->first();
                        $role=Role::where('id', intval($data[5]))->select('name')->first();
                        //$usu->assignRole('Estudiante');
                        $usu->assignRole($role->name);

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

                        $fecha=new Carbon($data[13]);
                        $fech=$fecha->format('Y-m-d');

                        $fechaa=new Carbon($data[16]);
                        $fechb=$fechaa->format('Y-m-d');

                        if($data[13]===null){
                            $fedocumento=$data[13];
                        }else{
                            $fedocumento=null;
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
                            'fecha_documento'=>$fedocumento,
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
                        Log::info('Line: ' . $row . ' 11-students-completo with error: ' . $exception->getMessage());
                    }
                }
        }

        fclose($handle);
    }
}
