<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GrupoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Academico\Grupo::create([
            'name'              => 'entresemana sede pricipal en la mañana',
            'start_date'        => '2023-09-01',
            'finish_date'       => '2023-10-30',
            'quantity_limit'    => 20,
            'sede_id'           => 1,
            'profesor_id'       => 125,
            'modulo_id'         => 1
        ]);

        \App\Models\Academico\Grupo::create([
            'name'              => 'fin de semana sede principal',
            'start_date'        => '2023-09-01',
            'finish_date'       => '2023-10-30',
            'quantity_limit'    => 20,
            'sede_id'           => 1,
            'profesor_id'       => 124,
            'modulo_id'         => 2
        ]);

        \App\Models\Academico\Grupo::create([
            'name'              => 'entresemana sede chia en la mañana',
            'start_date'        => '2023-09-01',
            'finish_date'       => '2023-10-30',
            'quantity_limit'    => 20,
            'sede_id'           => 2,
            'profesor_id'       => 125,
            'modulo_id'         => 1
        ]);

        \App\Models\Academico\Grupo::create([
            'name'              => 'fin de semana sede chia',
            'start_date'        => '2023-09-01',
            'finish_date'       => '2023-10-30',
            'quantity_limit'    => 20,
            'sede_id'           => 2,
            'profesor_id'       => 124,
            'modulo_id'         => 2
        ]);
    }
}
