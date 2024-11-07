<?php

namespace Database\Seeders;

use App\Models\Academico\Grupo;
use App\Models\Academico\Nota;
use App\Models\User;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NotaantiguosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $row = 0;

        if(($handle = fopen(public_path() . '/csv/36-notaantiguos.csv', 'r')) !== false) {

            while(($data = fgetcsv($handle, 26000, ';')) !== false) {

                $row++;

                try {
                    $grupos=DB::table('grupo_user')
                                ->where('user_id',intval($data[0]))
                                ->get();

                    if($grupos){
                        foreach ($grupos as $value) {
                            $este=Grupo::where('id',$value->grupo_id)
                                        ->where('modulo_id', intval($data[1]))
                                        ->first();

                            if($este){
                                $profe=User::find($este->profesor_id);
                                $nota=Nota::where('profesor_id',$profe->id)
                                            ->where('grupo_id',$este->id)
                                            ->first();

                                $alum=User::find(intval($data[0]));

                                $ya=DB::table('notas_detalle')
                                        ->where('profesor_id',$profe->id)
                                        ->where('alumno_id',$alum->id)
                                        ->where('grupo_id',$este->id)
                                        ->count('id');

                                if($ya>0){
                                    Log::info('Line: ,' . $row . ', 36-notaantiguos, ya se cargo');
                                }else{
                                    DB::table('notas_detalle')
                                        ->insert([
                                            'nota_id'       =>$nota->id,
                                            'alumno_id'     =>$alum->id,
                                            'alumno'        =>$alum->name,
                                            'profesor_id'   =>$profe->id,
                                            'profesor'      =>$profe->name,
                                            'grupo_id'      =>$este->id,
                                            'grupo'         =>$este->name,
                                            'acumulado'     =>$data[2],
                                            'observaciones' =>$data[3],
                                            'nota1'         =>$data[2],
                                            'porcen1'       =>$data[2],
                                            'nota2'         =>null,
                                            'porcen2'       =>null,
                                            'nota3'         =>null,
                                            'porcen3'       =>null,
                                            'nota4'         =>null,
                                            'porcen4'       =>null,
                                            'nota5'         =>null,
                                            'porcen5'       =>null,
                                            'nota6'         =>null,
                                            'porcen6'       =>null,
                                            'nota7'         =>null,
                                            'porcen7'       =>null,
                                            'nota8'         =>null,
                                            'porcen8'       =>null,
                                            'nota9'         =>null,
                                            'porcen9'       =>null,
                                            'nota10'        =>null,
                                            'porcen10'      =>null,
                                            'created_at'    =>now(),
                                            'updated_at'    =>now()
                                        ]);

                                    Log::info('Line: ,' . $row . ', 36-notaantiguos, Cargado para el grupo: ,'.$este->name);
                                }

                            }else{
                                Log::info('Line: ,' . $row . ', 36-notaantiguos, no hay grupo');
                            }

                        }
                    }else{
                        Log::info('Line: ,' . $row . ', 36-notaantiguos, NO TIENE ASIGNADO CICLO');
                    }

                }catch(Exception $exception){
                    Log::info('Line: ,' . $row . ', 36-notaantiguos with error: ,' . $exception->getMessage().', código: ,'.$exception->getCode().', linea: ,'.$exception->getLine());
                }
            }
        }

        fclose($handle);
    }
}
