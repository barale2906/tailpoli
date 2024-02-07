<?php

namespace App\Imports;

use App\Models\Academico\Horario;
use App\Models\Configuracion\Sede;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SedesImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection($rows)
    {
        foreach($rows as $row){

            DB::table('sedes')->insert([
                'id'                        => intval($row[0]),
                'sector_id'                 => strtolower($row[1]),
                'name'                      => strtolower($row[2]),
                'slug'                      => strtolower($row[3]),
                'address'                   => strtolower($row[4]),
                'nit'                       => strtolower($row[5]),
                'phone'                     => strtolower($row[6]),
                'portfolio_assistant_name'  => strtolower($row[7]),
                'portfolio_assistant_phone' => strtolower($row[8]),
                'portfolio_assistant_email' => strtolower($row[9]),
                'start'                     => '06:00:00',
                'finish'                    => '22:00:00',
                'status'                    => intval($row[10]),
                'created_at'                => Carbon::instance(Date::excelToDateTimeObject($row[11])),
                'updated_at'                => Carbon::instance(Date::excelToDateTimeObject($row[12]))
            ]);

            $sede=Sede::orderBy('id', 'DESC')->first();
            DB::table('area_sede')
                ->insert([
                    'area_id'=>4,
                    'sede_id'=>$sede->id,
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ]);

            DB::table('area_sede')
                ->insert([
                    'area_id'=>5,
                    'sede_id'=>$sede->id,
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ]);

                $start='06:00:00';
                $finish='22:00:00';

                //Crear horarios de cierre
            for ($i=1; $i <= 7; $i++) {

                switch ($i) {
                    case 1:
                        $dia="lunes";
                        $horai=$start;
                        $horaf=$finish;
                        break;

                    case 2:
                        $dia="martes";
                        $horai=$start;
                        $horaf=$finish;
                        break;

                    case 3:
                        $dia="miercoles";
                        $horai=$start;
                        $horaf=$finish;
                        break;

                    case 4:
                        $dia="jueves";
                        $horai=$start;
                        $horaf=$finish;
                        break;

                    case 5:
                        $dia="viernes";
                        $horai=$start;
                        $horaf=$finish;
                        break;

                    case 6:
                        $dia="sabado";
                        $horai=$start;
                        $horaf=$finish;
                        break;

                    case 7:
                        $dia="domingo";
                        $horai=$start;
                        $horaf=$finish;
                        break;

                }

                if($horai){
                    //inicia
                    Horario::create([
                        'sede_id'       =>$sede->id,
                        'area_id'       =>4,
                        'tipo'          =>true,
                        'periodo'       =>true,
                        'dia'           =>$dia,
                        'hora'          =>$horai,
                    ]);

                    //fin
                    Horario::create([
                        'sede_id'       =>$sede->id,
                        'area_id'       =>4,
                        'tipo'          =>true,
                        'periodo'       =>false,
                        'dia'           =>$dia,
                        'hora'          =>$horaf,
                    ]);
                }
            }

            //Asignar sedes a los superusuarios
            $superusuarios = User::where('status', true)
                                    ->with('roles')->get()->filter(
                                        fn ($user) => $user->roles->where('name', 'Superusuario')->toArray()
                                    );

            foreach($superusuarios as $item){

                DB::table('sede_user')
                ->insert([
                    'user_id'                   =>$item->id,
                    'sede_id'                   =>$sede->id,
                    'created_at'                =>now(),
                    'updated_at'                =>now(),
                ]);

            }

        }
    }
}
