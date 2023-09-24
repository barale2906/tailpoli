<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConceptoPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Financiera\ConceptoPago::create([
            'name'              =>'Matricula',
        ]);

        \App\Models\Financiera\ConceptoPago::create([
            'name'              =>'Cuota Inicial',
        ]);

        \App\Models\Financiera\ConceptoPago::create([
            'name'              =>'Semestre',
        ]);

        \App\Models\Financiera\ConceptoPago::create([
            'name'              =>'Mensualidad',
        ]);

        \App\Models\Financiera\ConceptoPago::create([
            'name'              =>'Inventario',
        ]);
    }
}
