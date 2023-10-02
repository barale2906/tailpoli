<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfiguracioPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Financiera\ConfiguracionPago::create([
            'valor_curso'           =>1350000,
            'valor_matricula'       =>150000,
            'valor_cuota_inicial'   =>1200000,
            'cuotas'                =>0,
            'valor_cuota'           =>0,
            'descripcion'           =>'Curso 1 Sede 1 contado',
            'sede_id'               =>1,
            'curso_id'              =>1
        ]);

        \App\Models\Financiera\ConfiguracionPago::create([
            'valor_curso'           =>1350000,
            'valor_matricula'       =>150000,
            'valor_cuota_inicial'   =>100000,
            'cuotas'                =>4,
            'valor_cuota'           =>350000,
            'descripcion'           =>'Curso 1 Sede 1 crédito',
            'sede_id'               =>1,
            'curso_id'              =>1
        ]);

        \App\Models\Financiera\ConfiguracionPago::create([
            'valor_curso'           =>1650000,
            'valor_matricula'       =>100000,
            'valor_cuota_inicial'   =>1550000,
            'cuotas'                =>0,
            'valor_cuota'           =>0,
            'descripcion'           =>'Curso 2 Sede 1 contado',
            'sede_id'               =>1,
            'curso_id'              =>2
        ]);

        \App\Models\Financiera\ConfiguracionPago::create([
            'valor_curso'           =>1650000,
            'valor_matricula'       =>100000,
            'valor_cuota_inicial'   =>100000,
            'cuotas'                =>5,
            'valor_cuota'           =>290000,
            'descripcion'           =>'Curso 2 Sede 1 crédito',
            'sede_id'               =>1,
            'curso_id'              =>2
        ]);



        \App\Models\Financiera\ConfiguracionPago::create([
            'valor_curso'           =>1600000,
            'valor_matricula'       =>150000,
            'valor_cuota_inicial'   =>1450000,
            'cuotas'                =>0,
            'valor_cuota'           =>0,
            'descripcion'           =>'Curso 1 Sede 2 contado',
            'sede_id'               =>2,
            'curso_id'              =>1
        ]);

        \App\Models\Financiera\ConfiguracionPago::create([
            'valor_curso'           =>1600000,
            'valor_matricula'       =>150000,
            'valor_cuota_inicial'   =>100000,
            'cuotas'                =>6,
            'valor_cuota'           =>225000,
            'descripcion'           =>'Curso 1 Sede 2 crédito',
            'sede_id'               =>2,
            'curso_id'              =>1
        ]);

        \App\Models\Financiera\ConfiguracionPago::create([
            'valor_curso'           =>1950000,
            'valor_matricula'       =>0,
            'valor_cuota_inicial'   =>1950000,
            'cuotas'                =>0,
            'valor_cuota'           =>0,
            'descripcion'           =>'Curso 2 Sede 2 contado',
            'sede_id'               =>2,
            'curso_id'              =>2
        ]);

        \App\Models\Financiera\ConfiguracionPago::create([
            'valor_curso'           =>2050000,
            'valor_matricula'       =>100000,
            'valor_cuota_inicial'   =>150000,
            'cuotas'                =>6,
            'valor_cuota'           =>300000,
            'descripcion'           =>'Curso 2 Sede 2 crédito',
            'sede_id'               =>2,
            'curso_id'              =>2
        ]);
    }
}
