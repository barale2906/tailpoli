<?php

namespace Database\Seeders;

use App\Models\Financiera\ConfiguracionPago;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfiguracioPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hoy=Carbon::now();
        $hoyo=Carbon::now();
        $fin=$hoyo->addMonths(6);

        ConfiguracionPago::create([
            'inicia'                =>$hoy,
            'finaliza'              =>$fin,
            'valor_curso'           =>1350000,
            'valor_matricula'       =>1350000,
            //'valor_cuota_inicial'   =>1200000,
            'cuotas'                =>0,
            'valor_cuota'           =>0,
            'descripcion'           =>'Curso 1 Sede 1 contado',
            'sector_id'             =>1,
            'curso_id'              =>1
        ]);

        ConfiguracionPago::create([
            'inicia'                =>$hoy,
            'finaliza'              =>$fin,
            'valor_curso'           =>1650000,
            'valor_matricula'       =>250000,
            //'valor_cuota_inicial'   =>100000,
            'cuotas'                =>4,
            'valor_cuota'           =>350000,
            'descripcion'           =>'Curso 1 Sede 1 crédito',
            'sector_id'             =>1,
            'curso_id'              =>1
        ]);

        ConfiguracionPago::create([
            'inicia'                =>$hoy,
            'finaliza'              =>$fin,
            'valor_curso'           =>1650000,
            'valor_matricula'       =>1650000,
            //'valor_cuota_inicial'   =>1550000,
            'cuotas'                =>0,
            'valor_cuota'           =>0,
            'descripcion'           =>'Curso 2 Sede 1 contado',
            'sector_id'             =>1,
            'curso_id'              =>2
        ]);

        ConfiguracionPago::create([
            'inicia'                =>$hoy,
            'finaliza'              =>$fin,
            'valor_curso'           =>1700000,
            'valor_matricula'       =>200000,
            //'valor_cuota_inicial'   =>100000,
            'cuotas'                =>5,
            'valor_cuota'           =>300000,
            'descripcion'           =>'Curso 2 Sede 1 crédito',
            'sector_id'             =>1,
            'curso_id'              =>2
        ]);



        ConfiguracionPago::create([
            'inicia'                =>$hoy,
            'finaliza'              =>$fin,
            'valor_curso'           =>1600000,
            'valor_matricula'       =>1650000,
            //'valor_cuota_inicial'   =>1450000,
            'cuotas'                =>0,
            'valor_cuota'           =>0,
            'descripcion'           =>'Curso 1 Sede 2 contado',
            'sector_id'             =>2,
            'curso_id'              =>1
        ]);

        ConfiguracionPago::create([
            'inicia'                =>$hoy,
            'finaliza'              =>$fin,
            'valor_curso'           =>1650000,
            'valor_matricula'       =>250000,
            //'valor_cuota_inicial'   =>100000,
            'cuotas'                =>5,
            'valor_cuota'           =>280000,
            'descripcion'           =>'Curso 1 Sede 2 crédito',
            'sector_id'             =>2,
            'curso_id'              =>1
        ]);

        ConfiguracionPago::create([
            'inicia'                =>$hoy,
            'finaliza'              =>$fin,
            'valor_curso'           =>1950000,
            'valor_matricula'       =>1950000,
            //'valor_cuota_inicial'   =>1950000,
            'cuotas'                =>0,
            'valor_cuota'           =>0,
            'descripcion'           =>'Curso 2 Sede 2 contado',
            'sector_id'             =>2,
            'curso_id'              =>2
        ]);

        ConfiguracionPago::create([
            'inicia'                =>$hoy,
            'finaliza'              =>$fin,
            'valor_curso'           =>2050000,
            'valor_matricula'       =>250000,
            //'valor_cuota_inicial'   =>150000,
            'cuotas'                =>6,
            'valor_cuota'           =>300000,
            'descripcion'           =>'Curso 2 Sede 2 crédito',
            'sector_id'             =>2,
            'curso_id'              =>2
        ]);
    }
}
