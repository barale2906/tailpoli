<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Academico\Matricula;
use Illuminate\Support\Facades\Log;

class FaltantesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $row = 0;

        if(($handle = fopen(public_path() . '/csv/faltantes.csv', 'r')) !== false) {

                while(($data = fgetcsv($handle, 90000, ';')) !== false) {

                    $row++;

                    try {

                        $esta=Matricula::where('alumno_id', $data[0])
                                        ->get();

                        foreach ($esta as $value) {
                            Log::info('_ Line: _' . $value->id.'_ estud: _'.$value->alumno_id.'_ documento: _'.$value->alumno->documento.'_ nombre: _'.$value->alumno->name.'_ curso: _'.$value->curso_id.'_ Nombre curso: _'.$value->curso->name.'_ inicia: _'.$value->fecha_inicia.'_ status _'.$value->status);
                        }

                    }catch(Exception $exception){
                        Log::info('Line: ' . $row . ' faltantes.csv with error: ' . $exception->getMessage());
                    }
                }
        }
    }
}
