<?php

namespace Database\Seeders;

use App\Models\Academico\Control;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AsisestadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fechacrt=Carbon::now()->subDays(15);
        //Buscar estudiantes en control
        $crt=Control::whereNotIn('status_est',[2,4,6,11,13])
                        ->get();
        //Buscar en asistencia detalle no mayor a 15 días
        foreach ($crt as $value) {
            //REcorrer con foreach -> Buscar el detalle_registro para encontrar el último y validar contra control.
            $detalle=DB::table('asistencia_detalle')
                        ->where('alumno_id',$value->estudiante_id)
                        ->get();

            foreach ($detalle as $item) {

                //Comparar fecha del detalle contra fecha del control y actualizar si es menor
                $actual=DB::table('asistencia_detalle_registro')
                            ->where('asistencia_detalle_id',$item->id)
                            ->where('fecha_asis','>',$fechacrt)
                            ->orderBy('fecha_asis','DESC')
                            ->first();

                if($actual){

                    $control=Control::find($value->id);

                    Log::info('Control: ' . $value->id . ' alumno: '.$item->alumno_id.' registro detalle: '.$actual->fecha_asis.': Control asistencia: '.$control->ultima_asistencia);

                    if($control->ultima_asistencia<$actual->fecha_asis){
                        $control->update([
                            'ultima_asistencia' => $actual->fecha_asis
                        ]);

                        Log::info('Control: ' . $value->id . ' se actualizo. '.$fechacrt.' FEcha registrada: '.$actual->fecha_asis);
                    }
                }
            }
        }


    }
}
