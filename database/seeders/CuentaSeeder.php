<?php

namespace Database\Seeders;

use App\Models\Financiera\Cuenta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CuentaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cuenta::create([
                'sede_id'   =>1,
                'name'  =>'Transferencia Bancolombia',
                'numero_cuenta' =>11200502,
                'tipo'  =>'Transferencia',
                'banco' => 'Bancolombia Ahorros'
            ]);

        Cuenta::create([
                'sede_id'   =>1,
                'name'  =>'Transferencia Colpatria',
                'numero_cuenta' =>1111111,
                'tipo'  =>'Transferencia',
                'banco' => 'Colpatria Ahorros'
            ]);

        Cuenta::create([
                'sede_id'   =>1,
                'name'  =>'Transferencia Davivienda Ahorros',
                'numero_cuenta' =>222222,
                'tipo'  =>'Transferencia',
                'banco' => 'Davivienda Ahorros'
            ]);

        Cuenta::create([
                'sede_id'   =>1,
                'name'  =>'Transferencia Davivienda Corriente',
                'numero_cuenta' =>3333333,
                'tipo'  =>'Transferencia',
                'banco' => 'Davivienda Corriente'
            ]);

        Cuenta::create([
                'sede_id'   =>1,
                'name'  =>'Efectivo Bogotá',
                'numero_cuenta' =>11200502,
                'tipo'  =>'efectivo',
            ]);

        Cuenta::create([
                'sede_id'   =>4,
                'name'  =>'Efectivo Chapinero',
                'numero_cuenta' =>11050504,
                'tipo'  =>'efectivo',
            ]);

        Cuenta::create([
                'sede_id'   =>7,
                'name'  =>'Efectivo Cali',
                'numero_cuenta' =>11050502,
                'tipo'  =>'efectivo',
            ]);

        Cuenta::create([
                'sede_id'   =>10,
                'name'  =>'Efectivo Ibague',
                'numero_cuenta' =>11050503,
                'tipo'  =>'efectivo',
            ]);

        Cuenta::create([
                'sede_id'   =>9,
                'name'  =>'Efectivo Medellin',
                'numero_cuenta' =>11050507,
                'tipo'  =>'efectivo',
            ]);

        Cuenta::create([
                'sede_id'   =>8,
                'name'  =>'Efectivo Villavicencio',
                'numero_cuenta' =>11050509,
                'tipo'  =>'efectivo',
            ]);
    }
}
