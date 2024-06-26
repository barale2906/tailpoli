<?php

namespace Database\Seeders;

use App\Models\Academico\Grupo;
use App\Models\Academico\Horario;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GrupoSeeder extends Seeder
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

                        $creado=new Carbon($data[7]);
                        $crea=$creado->format('Y-m-d H:i:s');

                        $actualiza=new Carbon($data[8]);
                        $actua=$actualiza->format('Y-m-d H:i:s');

                        DB::table('grupos')->insert([
                            'id'                => intval($data[0]),
                            'name'              => strtolower($data[1]),
                            'quantity_limit'    => intval($data[2]),
                            'sede_id'           => intval($data[3]),
                            'profesor_id'       => intval($data[4]),
                            'modulo_id'         => intval($data[5]),
                            'status'            => 0,
                            'created_at'        => $data[6],
                            'updated_at'        => $data[7]
                        ]);

                    }catch(Exception $exception){
                        Log::info('Line: ' . $row . ' 10-grupos-23 with error: ' . $exception->getMessage());
                    }
                }
        }

        fclose($handle);

        /* $hoy=Carbon::now();
        $hoyo=Carbon::now();
        $fin=$hoyo->addMonths(6);

        $g1=Grupo::create([
            'name'              => 'manteMoto - kit - bogotá a - mañana',
            //'start_date'        => $hoy,
            //'finish_date'       => $fin,
            'quantity_limit'    => 20,
            'sede_id'           => 1,
            'profesor_id'       => 6,
            'modulo_id'         => 1
        ]);

        //Asignar horarios
        for ($i=1; $i <= 7; $i++) {

            if($i===6){
                $inicia="08:00:00";
            }else if($i===7){
                $inicia="08:00:00";
            }else{
                $inicia="06:00:00";
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
                'sede_id'       =>1,
                'area_id'       =>1,
                'grupo'         =>$g1->name,
                'grupo_id'      =>$g1->id,
                'tipo'          =>false,
                'periodo'       =>true,
                'dia'           =>$dia,
                'hora'          =>$inicia,
            ]);
        }

        $g2=Grupo::create([
            'name'              => 'manteMoto - arranque - bogotá a - mañana',
            //'start_date'        => $hoy,
            //'finish_date'       => $fin,
            'quantity_limit'    => 20,
            'sede_id'           => 1,
            'profesor_id'       => 6,
            'modulo_id'         => 2
        ]);

        //Asignar horarios
        for ($i=1; $i <= 7; $i++) {

            if($i===6){
                $inicia="08:00:00";
            }else if($i===7){
                $inicia="08:00:00";
            }else{
                $inicia="06:00:00";
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
                'sede_id'       =>1,
                'area_id'       =>2,
                'grupo'         =>$g2->name,
                'grupo_id'      =>$g2->id,
                'tipo'          =>false,
                'periodo'       =>true,
                'dia'           =>$dia,
                'hora'          =>$inicia,
            ]);
        }

        $g3=Grupo::create([
            'name'              => 'manteMoto - computadora - bogotá a - mañana',
            //'start_date'        => $hoy,
            //'//finish_date'       => $fin,
            'quantity_limit'    => 20,
            'sede_id'           => 1,
            'profesor_id'       => 6,
            'modulo_id'         => 3
        ]);

        //Asignar horarios
        for ($i=1; $i <= 7; $i++) {

            if($i===6){
                $inicia="08:00:00";
            }else if($i===7){
                $inicia="08:00:00";
            }else{
                $inicia="06:00:00";
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
                'sede_id'       =>1,
                'area_id'       =>3,
                'grupo'         =>$g3->name,
                'grupo_id'      =>$g3->id,
                'tipo'          =>false,
                'periodo'       =>true,
                'dia'           =>$dia,
                'hora'          =>$inicia,
            ]);
        }

        $g4=Grupo::create([
            'name'              => 'manteMoto - kit - bogotá a - tarde',
            //'start_date'        => $hoy,
            //'finish_date'       => $fin,
            'quantity_limit'    => 20,
            'sede_id'           => 1,
            'profesor_id'       => 6,
            'modulo_id'         => 1
        ]);

        //Asignar horarios
        for ($i=1; $i <= 7; $i++) {

            if($i===6){
                $inicia="14:00:00";
            }else if($i===7){
                $inicia="11:00:00";
            }else{
                $inicia="14:00:00";
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
                'sede_id'       =>1,
                'area_id'       =>4,
                'grupo'         =>$g4->name,
                'grupo_id'      =>$g4->id,
                'tipo'          =>false,
                'periodo'       =>true,
                'dia'           =>$dia,
                'hora'          =>$inicia,
            ]);
        }

        $g5=Grupo::create([
            'name'              => 'manteMoto - arranque - bogotá a - tarde',
            //'start_date'        => $hoy,
            //'finish_date'       => $fin,
            'quantity_limit'    => 20,
            'sede_id'           => 1,
            'profesor_id'       => 6,
            'modulo_id'         => 2
        ]);

        //Asignar horarios
        for ($i=1; $i <= 7; $i++) {

            if($i===6){
                $inicia="14:00:00";
            }else if($i===7){
                $inicia="11:00:00";
            }else{
                $inicia="14:00:00";
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
                'sede_id'       =>1,
                'area_id'       =>5,
                'grupo'         =>$g5->name,
                'grupo_id'      =>$g5->id,
                'tipo'          =>false,
                'periodo'       =>true,
                'dia'           =>$dia,
                'hora'          =>$inicia,
            ]);
        }

        $g6=Grupo::create([
            'name'              => 'manteMoto - computadora - bogotá a - tarde',
            //'start_date'        => $hoy,
            //'finish_date'       => $fin,
            'quantity_limit'    => 20,
            'sede_id'           => 1,
            'profesor_id'       => 6,
            'modulo_id'         => 3
        ]);

        //Asignar horarios
        for ($i=1; $i <= 7; $i++) {

            if($i===6){
                $inicia="14:00:00";
            }else if($i===7){
                $inicia="11:00:00";
            }else{
                $inicia="14:00:00";
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
                'sede_id'       =>1,
                'area_id'       =>6,
                'grupo'         =>$g6->name,
                'grupo_id'      =>$g6->id,
                'tipo'          =>false,
                'periodo'       =>true,
                'dia'           =>$dia,
                'hora'          =>$inicia,
            ]);
        } */
    }
}
