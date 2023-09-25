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
            'tipo'              =>'cartera'
        ]);

        \App\Models\Financiera\ConceptoPago::create([
            'name'              =>'Cuota Inicial',
            'tipo'              =>'cartera'
        ]);

        \App\Models\Financiera\ConceptoPago::create([
            'name'              =>'Semestre',
            'tipo'              =>'cartera'
        ]);

        \App\Models\Financiera\ConceptoPago::create([
            'name'              =>'Mensualidad',
            'tipo'              =>'cartera'
        ]);

        \App\Models\Financiera\ConceptoPago::create([
            'name'              =>'Inventario',
            'tipo'              =>'inventario'
        ]);

        \App\Models\Financiera\ConceptoPago::create([
            'name'              =>'Proyecto Grado',
            'tipo'              =>'otro'
        ]);

        \App\Models\Financiera\ConceptoPago::create([
            'name'              =>'Recuperación Modulo',
            'tipo'              =>'otro'
        ]);

        \App\Models\Financiera\ConceptoPago::create([
            'name'              =>'Ceremonia de Grado',
            'tipo'              =>'otro'
        ]);
    }
}
