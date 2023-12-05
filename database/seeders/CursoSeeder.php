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
            'slug'              =>'TecManMoto',
            'tipo'              =>'técnico',
            'duracion_horas'    =>159,
            'duracion_meses'   =>6
        ]);

        Curso::create([
            'name'              =>'Técnico En Mecánica De Vehículos Automotores',
            'slug'              =>'TecMecVehiAuto',
            'tipo'              =>'técnico',
            'duracion_horas'    =>159,
            'duracion_meses'   =>6
        ]);

        Curso::create([
            'name'              =>'Instalación De Car Audio Y Alarmas',
            'slug'              =>'InsCarAudAla',
            'tipo'              =>'práctico',
            'duracion_horas'    =>159,
            'duracion_meses'   =>6
        ]);
        Curso::create([
            'name'              =>'Inyección Electrónica Y Alto Cilindraje De Motos',
            'slug'              =>'inyEleAltCiliMoto',
            'tipo'              =>'práctico',
            'duracion_horas'    =>159,
            'duracion_meses'   =>6
        ]);
    }
}
