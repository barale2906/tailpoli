<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModuloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Academico\Modulo::create([
            'name'              =>'kit de arrastre',
            'curso_id'          =>1
        ]);

        \App\Models\Academico\Modulo::create([
            'name'              =>'sistema de arranque',
            'curso_id'          =>1
        ]);

        \App\Models\Academico\Modulo::create([
            'name'              =>'manejo de computadora',
            'curso_id'          =>1
        ]);

        \App\Models\Academico\Modulo::create([
            'name'              =>'transmisión',
            'curso_id'          =>2
        ]);

        \App\Models\Academico\Modulo::create([
            'name'              =>'diferenciales',
            'curso_id'          =>2
        ]);

        \App\Models\Academico\Modulo::create([
            'name'              =>'frenos',
            'curso_id'          =>2
        ]);

        \App\Models\Academico\Modulo::create([
            'name'              =>'bajos',
            'curso_id'          =>3
        ]);

        \App\Models\Academico\Modulo::create([
            'name'              =>'equalizadores',
            'curso_id'          =>3
        ]);

        \App\Models\Academico\Modulo::create([
            'name'              =>'video',
            'curso_id'          =>3
        ]);

        \App\Models\Academico\Modulo::create([
            'name'              =>'tiempos de sincronización',
            'curso_id'          =>4
        ]);

        \App\Models\Academico\Modulo::create([
            'name'              =>'tiempos de explosión',
            'curso_id'          =>4
        ]);

        \App\Models\Academico\Modulo::create([
            'name'              =>'ajustes de mezcla',
            'curso_id'          =>4
        ]);
    }
}
