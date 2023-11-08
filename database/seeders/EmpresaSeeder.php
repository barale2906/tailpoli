<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('empresa')
                ->insert([
                    'nombre'            =>'INSTITUTO DE CAPACITACIÓN POLIANDINO CENTRAL',
                    'direccion'         =>' CRA. 12A BIS No. 22-12 SUR',
                    'nit'               =>'900656857-5',
                    'telefono'          =>'6950220 - 8130745 - 4796112',
                    'resolucionfact'    =>'18031 del 02/11/2017 de la SED Bogotá',
                    'rl'                =>'JAIME MANUEL NASTAR VALLEJO',
                    'documentoRl'       =>'',
                    'telRl'             =>'',
                    'created_at'        =>now(),
                    'updated_at'        =>now(),
                ]);
    }
}
