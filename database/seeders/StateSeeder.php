<?php

namespace Database\Seeders;

use App\Models\Configuracion\State;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        State::create([
            'name' => 'Bogotá',
            'country_id' => 1,
            'created_at'=>'2019-05-16 20:58:16',
            'updated_at'=>'2019-05-16 20:58:16',
        ]);

        /* State::create([
            'name' => 'Bogotá D.C.',
            'country_id' => 1,
        ]);
        State::create([
            'name' => 'Risaralda',
            'country_id' => 1,
        ]);
        State::create([
            'name' => 'Nariño',
            'country_id' => 1,
        ]);
        State::create([
            'name' => 'Santander',
            'country_id' => 1,
        ]); */
    }
}
