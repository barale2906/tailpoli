<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Academico\Ciclo;
use App\Models\Academico\Control;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CicloinactivaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $row = 0;

        if(($handle = fopen(public_path() . '/csv/24-asigna_Ciclos_Nuevos.csv', 'r')) !== false) {

                while(($data = fgetcsv($handle, 26000, ';')) !== false) {

                    try {

                        $control=Control::where('matricula_id',intval($data[0]))->first();

                        if($control){

                            $ciclo=Ciclo::find($control->ciclo_id);

                            // borrar modulos
                            foreach ($ciclo->ciclogrupos as $value) {
                                //Cargar estudiante al grupo
                                DB::table('grupo_user')
                                    ->where('user_id', $control->estudiante_id)
                                    ->where('grupo_id', $value->grupo->id)
                                    ->delete();
                            }

                            DB::table('grupo_matricula')
                                    ->where('matricula_id',intval($data[0]))
                                    ->delete();

                            DB::table('matricula_modulos_aprobacion')
                                ->where('matricula_id', intval($data[0]))
                                ->delete();

                            //Restar usuario al ciclo
                            $tota=$ciclo->registrados-1;

                            $ciclo->update([
                                'registrados'=>$tota
                            ]);

                            $control->delete();

                            Log::info('Line: ' . $row . ' gestionada matricula: '. $data[0]);

                        }else{
                            Log::info('Line: ' . $row . ' matricula no tenia control: '. $data[0]);
                        }




                    }catch(Exception $exception){
                        Log::info('Line: ' . $row . ' inactivar ciclo with error: ' . $exception->getMessage().' codigo: '.$exception->getLine());
                    }
                    $row++;
                }
        }

        fclose($handle);
    }
}
