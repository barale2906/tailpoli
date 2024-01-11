<?php

namespace App\Imports;

use App\Models\Configuracion\Perfil;
use App\Models\Configuracion\Sector;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EstudianteImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection($rows)
    {
        foreach($rows as $row){

            $password=bcrypt($row[3]);
            $name=$row[1]." ".$row[2];

            DB::table('users')->insert([
                    'id'            => intval($row[0]),
                    'name'          => strtolower($name),
                    'email'         => strtolower($row[10]),
                    'documento'     => strtolower($row[3]),
                    'password'      => $password,
                    'status'        => intval($row[4]),
                    'rol_id'        => intval($row[5]),
                    'created_at'    => Carbon::instance(Date::excelToDateTimeObject($row[6])),
                    'updated_at'    => Carbon::instance(Date::excelToDateTimeObject($row[7]))
                ]);

            $usu=User::orderBy('id', 'DESC')->first();

            $sector=Sector::where('state_id', intval($row[9]))->first();

            $per=Perfil::create([
                'user_id'=>$usu->id,
                'country_id'=>intval($row[8]),
                'state_id'=>intval($row[9]),
                'sector_id'=>$sector->id,
                'estado_id'=>1,
                'regimen_salud_id'=>intval($row[11]),
                'tipo_documento'=>strtolower($row[12]),
                'documento'=>strtolower($row[3]),
                'name'=>strtolower($row[1]),
                'lastname'=>strtolower($row[2]),
                'fecha_documento'=>Carbon::instance(Date::excelToDateTimeObject($row[13])),
                'lugar_expedicion'=>strtolower($row[14]),
                'direccion'=>strtolower($row[15]),
                'fecha_nacimiento'=>Carbon::instance(Date::excelToDateTimeObject($row[16])),
                'barrio'=>strtolower($row[17]),
                'celular'=>strtolower($row[18]),
                'wa'=>strtolower($row[19]),
                'fijo'=>strtolower($row[20]),
                'email'=>strtolower($row[10]),
                'contacto'=>strtolower($row[21]),
                'documento_contacto'=>strtolower($row[22]),
                'parentesco_contacto'=>strtolower($row[23]),
                'telefono_contacto'=>strtolower($row[24]),
                'talla'=>strtolower($row[25]),
                'calzado'=>strtolower($row[26]),
                'genero'=>strtolower($row[27]),
                'estado_civil'=>strtolower($row[28]),
                'estrato'=>strtolower($row[29]),
                'nivel_educativo'=>strtolower($row[30]),
                'ocupacion'=>strtolower($row[31]),
                'discapacidad'=>strtolower($row[32]),
                'enfermedad'=>strtolower($row[33]),
                'empresa_usuario'=>strtolower($row[34]),
                'autoriza_imagen'=>strtolower($row[35]),
                'carnet'=>strtolower($row[36]),
                'arl_usuario'=>strtolower($row[37]),
                'rh_usuario'=>$row[38],
            ]);
        }
    }
}
