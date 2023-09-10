<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SedeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Configuracion\Sede::create([
            'name'                      => 'SEDE A - PRINCIPAL',
            'address'                   => 'Cra. 12A BIS Nro. 22-12 SUR - SAN JOSÉ Localidad Rafael Uribe Uribe',
            'phone'                     => '2627700',
            'nit'                       =>'900656857-5',
            'portfolio_assistant_name'  =>'Marcela Quiceno',
            'portfolio_assistant_phone' =>'314-5490446',
            'portfolio_assistant_email' =>'cobranzasycarterapoliandino@gmail.com',
            'start'                     =>'06:00:00',
            'finish'                    =>'21:59:59',
            'sector_id'                 =>1
        ]);
        \App\Models\Configuracion\Sede::create([
            'name'                      => 'SEDE - BOGOTÁ',
            'address'                   => 'Cerca a la casa',
            'phone'                     => '2627700',
            'nit'                       =>'900656857-5',
            'portfolio_assistant_name'  =>'Stehany Izquierdo',
            'portfolio_assistant_phone' =>'314-5490446',
            'portfolio_assistant_email' =>'stephanyIz@gmail.com',
            'start'                     =>'06:00:00',
            'finish'                    =>'20:59:59',
            'sector_id'                 =>2
        ]);
    }
}
