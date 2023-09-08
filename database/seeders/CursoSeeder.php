<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CursoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Academico\Curso::create([
            'name'              =>'Técnico Mantenimiento De Motocicletas',
            'tipo'              =>'técnico',
            'duracion_horas'    =>159,
            'duracion_meses'   =>6
        ]);

        \App\Models\Academico\Curso::create([
            'name'              =>'Técnico En Mecánica De Vehículos Automotores',
            'tipo'              =>'técnico',
            'duracion_horas'    =>159,
            'duracion_meses'   =>6
        ]);

        \App\Models\Academico\Curso::create([
            'name'              =>'Instalación De Car Audio Y Alarmas',
            'tipo'              =>'práctico',
            'duracion_horas'    =>159,
            'duracion_meses'   =>6
        ]);
        \App\Models\Academico\Curso::create([
            'name'              =>'Inyección Electrónica Y Alto Cilindraje De Motos',
            'tipo'              =>'práctico',
            'duracion_horas'    =>159,
            'duracion_meses'   =>6
        ]);
    }
}
