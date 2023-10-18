<?php

namespace Database\Seeders;

use App\Models\Academico\Curso;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CursoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Curso::create([
            'name'              =>'Técnico Mantenimiento De Motocicletas',
            'tipo'              =>'técnico',
            'duracion_horas'    =>159,
            'duracion_meses'   =>6
        ]);

        Curso::create([
            'name'              =>'Técnico En Mecánica De Vehículos Automotores',
            'tipo'              =>'técnico',
            'duracion_horas'    =>159,
            'duracion_meses'   =>6
        ]);

        Curso::create([
            'name'              =>'Instalación De Car Audio Y Alarmas',
            'tipo'              =>'práctico',
            'duracion_horas'    =>159,
            'duracion_meses'   =>6
        ]);
        Curso::create([
            'name'              =>'Inyección Electrónica Y Alto Cilindraje De Motos',
            'tipo'              =>'práctico',
            'duracion_horas'    =>159,
            'duracion_meses'   =>6
        ]);
    }
}
