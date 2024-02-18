<?php

namespace App\Imports;

use App\Models\Configuracion\Perfil;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UsersImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection($rows)
    {

        foreach($rows as $row){

            set_time_limit(600);
            $password=bcrypt($row[3]);
            $email=$row[3]."@poliandinovirtual.com";
            $name=$row[1]." ".$row[2];

            DB::table('users')->insert([
                    'id'            => intval($row[0]),
                    'name'          => strtolower($name),
                    'email'         => strtolower($email),
                    'documento'     => strtolower($row[3]),
                    'password'      => $password,
                    'status'        => intval($row[4]),
                    'rol_id'        => intval($row[5]),
                    'created_at'    => Carbon::instance(Date::excelToDateTimeObject($row[6])),
                    'updated_at'    => Carbon::instance(Date::excelToDateTimeObject($row[7]))
                ]);

            $usu=User::orderBy('id', 'DESC')->first();
            $role=Role::whereId(intval($row[5]))->select('name')->first();
            $usu->assignRole($role->name);

            DB::table('sede_user')
                ->insert([
                    'user_id'       =>$usu->id,
                    'sede_id'       =>$row[8],
                    'created_at'    => Carbon::instance(Date::excelToDateTimeObject($row[6])),
                    'updated_at'    => Carbon::instance(Date::excelToDateTimeObject($row[7]))
                ]);

            Perfil::create([
                        'user_id'=>$usu->id,
                        'country_id'=>1,
                        'state_id'=>1,
                        'sector_id'=>1,
                        'estado_id'=>1,
                        'regimen_salud_id'=>1,
                        'tipo_documento'=>'cédula de ciudadanía',
                        'documento'=>strtolower($row[3]),
                        'name'=>strtolower($row[1]),
                        'lastname'=>strtolower($row[2])
            ]);
        }
    }
}
