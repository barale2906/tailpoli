<?php

namespace Database\Seeders;

use App\Models\Financiera\ConceptoPago;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConceptoPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ConceptoPago::create([
            'name'              =>'Matricula',
            'tipo'              =>'cartera'
        ]);

        ConceptoPago::create([
            'name'              =>'Mensualidad',
            'tipo'              =>'cartera'
        ]);

        ConceptoPago::create([
            'name'              =>'Inicial convenio',
            'tipo'              =>'cartera'
        ]);

        ConceptoPago::create([
            'name'              =>'Convenio mes',
            'tipo'              =>'cartera'
        ]);

        ConceptoPago::create([
            'name'              =>'Recargo Tarjeta',
            'tipo'              =>'financiero',
            'valor'             =>3
        ]);

        ConceptoPago::create([
            'name'              =>'Recargo Mora',
            'tipo'              =>'financiero',
            'valor'             =>10000
        ]);

        ConceptoPago::create([
            'name'              =>'Inventario',
            'tipo'              =>'inventario'
        ]);

        ConceptoPago::create([
            'name'              =>'Proyecto Grado',
            'tipo'              =>'otro'
        ]);

        ConceptoPago::create([
            'name'              =>'Recuperación Modulo',
            'tipo'              =>'otro'
        ]);

        ConceptoPago::create([
            'name'              =>'Ceremonia de Grado',
            'tipo'              =>'otro'
        ]);

        ConceptoPago::create([
            'name'              =>'Supletorio Modulo',
            'tipo'              =>'otro'
        ]);

        ConceptoPago::create([
            'name'              =>'Certificado o Constancia Final',
            'tipo'              =>'otro'
        ]);

        ConceptoPago::create([
            'name'              =>'Convalidación',
            'tipo'              =>'otro'
        ]);

        ConceptoPago::create([
            'name'              =>'Descuento',
            'tipo'              =>'financiero',
            'valor'             =>2
        ]);

        ConceptoPago::create([
            'name'              =>'Exámenes Médicos',
            'tipo'              =>'otro'
        ]);

        ConceptoPago::create([
            'name'              =>'Clase Téorica',
            'tipo'              =>'otro'
        ]);

        ConceptoPago::create([
            'name'              =>'Sábana de Notas',
            'tipo'              =>'otro'
        ]);

        ConceptoPago::create([
            'name'              =>'Recuperación',
            'tipo'              =>'otro'
        ]);
    }
}
