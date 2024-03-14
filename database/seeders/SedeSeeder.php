<?php

namespace Database\Seeders;

use App\Models\Academico\Horario;
use App\Models\Configuracion\Sede;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SedeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $row = 0;

        if(($handle = fopen(public_path() . '/csv/7-sedes-17.csv', 'r')) !== false) {

                while(($data = fgetcsv($handle, 26000, ';')) !== false) {

                    $row++;

                    try {

                        $creado=new Carbon($data[11]);
                        $crea=$creado->format('Y-m-d H:i:s');

                        $actualiza=new Carbon($data[12]);
                        $actua=$actualiza->format('Y-m-d H:i:s');

                        DB::table('sedes')->insert([
                            'id'                        => intval($data[0]),
                            'sector_id'                 => strtolower($data[1]),
                            'name'                      => strtolower($data[2]),
                            'slug'                      => strtolower($data[3]),
                            'address'                   => strtolower($data[4]),
                            'nit'                       => strtolower($data[5]),
                            'phone'                     => strtolower($data[6]),
                            'portfolio_assistant_name'  => strtolower($data[7]),
                            'portfolio_assistant_phone' => strtolower($data[8]),
                            'portfolio_assistant_email' => strtolower($data[9]),
                            'start'                     => '06:00:00',
                            'finish'                    => '22:00:00',
                            'status'                    => intval($data[10]),
                            'created_at'                => $crea,
                            'updated_at'                => $actua
                        ]);

                        $sede=Sede::orderBy('id', 'DESC')->first();
                        DB::table('area_sede')
                            ->insert([
                                'area_id'=>4,
                                'sede_id'=>$sede->id,
                                'created_at'=>$crea,
                                'updated_at'=>$actua,
                            ]);

                        DB::table('area_sede')
                            ->insert([
                                'area_id'=>5,
                                'sede_id'=>$sede->id,
                                'created_at'=>$crea,
                                'updated_at'=>$actua,
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
                                'created_at'                =>$crea,
                                'updated_at'                =>$actua,
                            ]);

                        }


                    }catch(Exception $exception){
                        Log::info('Line: ' . $row . ' 7-sedes-17 with error: ' . $exception->getMessage());
                    }
                }
        }

        fclose($handle);

        /*$s1=Sede::create([
            'name'                      => 'bogotá Sede a Principal',
            'slug'                      => 'bta1',
            'address'                   => 'Cra. 12A BIS Nro. 22-12 SUR - SAN JOSÉ Localidad Rafael Uribe Uribe',
            'phone'                     => '--',
            'nit'                       =>'900656857-5',
            'portfolio_assistant_name'  =>'Marcela Quiceno',
            'portfolio_assistant_phone' =>'314-5490446',
            'portfolio_assistant_email' =>'cobranzasycarterapoliandino@gmail.com',
            'start'                     =>'06:00',
            'finish'                    =>'22:00',
            'sector_id'                 =>1,
            'created_at'=>'2019-05-31 09:16:08',
            'updated_at'=>'2019-05-31 09:16:08',
        ]);

        //Asignar áreas
        for ($i=1; $i <= 15; $i++) {
            DB::table('area_sede')
                ->insert([
                    'area_id'=>$i,
                    'sede_id'=>$s1->id,
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ]);
        }

        //Asignar horarios
        for ($i=1; $i <= 7; $i++) {

            if($i===6){
                $inicia="08:00:00";
                $finaliza="18:00:00";
            }else if($i===7){
                $inicia="08:00:00";
                $finaliza="13:00:00";
            }else{
                $inicia="06:00:00";
                $finaliza="22:00:00";
            }


            switch ($i) {
                case 1:
                    $dia='lunes';
                    break;

                case 2:
                    $dia='martes';
                    break;

                case 3:
                    $dia='miercoles';
                    break;

                case 4:
                    $dia='jueves';
                    break;

                case 5:
                    $dia='viernes';
                    break;

                case 6:
                    $dia='sabado';
                    break;

                case 7:
                    $dia='domingo';
                    break;
            }

            Horario::create([
                'sede_id'       =>$s1->id,
                'area_id'       =>1,
                'tipo'          =>true,
                'periodo'       =>true,
                'dia'           =>$dia,
                'hora'          =>$inicia,
            ]);

            //fin
            Horario::create([
                'sede_id'       =>$s1->id,
                'area_id'       =>1,
                'tipo'          =>true,
                'periodo'       =>false,
                'dia'           =>$dia,
                'hora'          =>$finaliza,
            ]);
        }


        $s2=Sede::create([
            'name'                      => 'chía a',
            'slug'                      => 'chiaa',
            'address'                   => 'Cerca a la casa',
            'phone'                     => '2627700',
            'nit'                       =>'900656857-5',
            'portfolio_assistant_name'  =>'Stehany Izquierdo',
            'portfolio_assistant_phone' =>'314-5490446',
            'portfolio_assistant_email' =>'stephanyIz@gmail.com',
            'start'                     =>'06:00',
            'finish'                    =>'20:59',
            'sector_id'                 =>2
        ]);

        //Asignar áreas
        for ($i=1; $i <= 15; $i++) {
            DB::table('area_sede')
                ->insert([
                    'area_id'=>$i,
                    'sede_id'=>$s2->id,
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ]);
        }

        //Asignar horarios
        for ($i=1; $i <= 7; $i++) {

            if($i===6){
                $inicia="08:00:00";
                $finaliza="18:00:00";
            }else if($i===7){
                $inicia="08:00:00";
                $finaliza="13:00:00";
            }else{
                $inicia="06:00:00";
                $finaliza="22:00:00";
            }


            switch ($i) {
                case 1:
                    $dia='lunes';
                    break;

                case 2:
                    $dia='martes';
                    break;

                case 3:
                    $dia='miercoles';
                    break;

                case 4:
                    $dia='jueves';
                    break;

                case 5:
                    $dia='viernes';
                    break;

                case 6:
                    $dia='sabado';
                    break;

                case 7:
                    $dia='domingo';
                    break;
            }

            Horario::create([
                'sede_id'       =>$s2->id,
                'area_id'       =>1,
                'tipo'          =>true,
                'periodo'       =>true,
                'dia'           =>$dia,
                'hora'          =>$inicia,
            ]);

            //fin
            Horario::create([
                'sede_id'       =>$s2->id,
                'area_id'       =>1,
                'tipo'          =>true,
                'periodo'       =>false,
                'dia'           =>$dia,
                'hora'          =>$finaliza,
            ]);
        } */
    }
}
