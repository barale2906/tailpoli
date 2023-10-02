<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MatriculaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Academico\Matricula::create([
            'medio' => 'google',
            'nivel'=>'pre grado',
            'anula'=>'',
            'anula_user'=>'',
            'valor'=>'1250000',
            'metodo'=>'contado',
            'alumno_id'=>'2',
            'comercial_id'=>'124',
            'creador_id'=>'125',
            'curso_id'=>1
        ]);

        \App\Models\Academico\Matricula::create([
            'medio' => 'amigo',
            'nivel'=>'bachiller',
            'anula'=>'',
            'anula_user'=>'',
            'valor'=>'1300000',
            'metodo'=>'contado',
            'alumno_id'=>'4',
            'comercial_id'=>'125',
            'creador_id'=>'124',
            'curso_id'=>2
        ]);
    }
}
