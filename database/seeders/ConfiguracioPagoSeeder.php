<?php

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ConfiguracioPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $row = 0;

        if(($handle = fopen(public_path() . '/csv/20-config-pago.csv', 'r')) !== false) {

                while(($data = fgetcsv($handle, 26000, ';')) !== false) {

                    $row++;

                    try {

                        DB::table('configuracion_pagos')->insert([
                            'id'                => intval($data[0]),
                            'inicia'            => $data[1],
                            'finaliza'          => $data[2],
                            'valor_curso'       => intval($data[3]),
                            'valor_matricula'   => intval($data[4]),
                            'cuotas'            => intval($data[5]),
                            'valor_cuota'       => intval($data[6]),
                            'descripcion'       => strtolower($data[7]),
                            'sector_id'         => intval($data[8]),
                            'curso_id'          => intval($data[9]),
                            'status'            => intval($data[10]),
                            'created_at'        => $data[11],
                            'updated_at'        => $data[12],

                        ]);


                    }catch(Exception $exception){
                        Log::info('Line: ' . $row . ' 20-config-pago with error: ' . $exception->getMessage());
                    }
                }
        }

        fclose($handle);


        /* $hoy=Carbon::now();
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
            'descripcion'           =>'Curso 1 contado',
            'sector_id'             =>4,
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
            'descripcion'           =>'Curso 1 crédito',
            'sector_id'             =>4,
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
            'descripcion'           =>'Curso 2 contado',
            'sector_id'             =>4,
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
            'descripcion'           =>'Curso 2 crédito',
            'sector_id'             =>4,
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
        ]); */
    }
}
