<?php

namespace Database\Seeders;

use App\Models\Academico\Modulo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModuloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $m1=Modulo::create([
            'name'              =>'kit de arrastre',
            'curso_id'          =>1,
        ]);

        $m2=Modulo::create([
                'name'              =>'sistema de arranque',
                'curso_id'          =>1,
                //'dependencia'       =>true
            ]);

            /* DB::table('modulos_dependencias')
                    ->insert([
                        'modulo_id'     =>$m2->id,
                        'modulodep_id'  =>$m1->id,
                        'created_at'    =>now(),
                        'updated_at'    =>now(),
                    ]); */

        $m3=Modulo::create([
                    'name'              =>'manejo de computadora',
                    'curso_id'          =>1,
                    //'dependencia'       =>true
                ]);

            /* DB::table('modulos_dependencias')
                ->insert([
                    'modulo_id'     =>$m3->id,
                    'modulodep_id'  =>$m2->id,
                    'created_at'    =>now(),
                    'updated_at'    =>now(),
                ]);

            DB::table('modulos_dependencias')
                ->insert([
                    'modulo_id'     =>$m3->id,
                    'modulodep_id'  =>$m1->id,
                    'created_at'    =>now(),
                    'updated_at'    =>now(),
                ]); */

        $m4=Modulo::create([
            'name'              =>'transmisión',
            'curso_id'          =>2
        ]);

        $m5=Modulo::create([
                    'name'              =>'diferenciales',
                    'curso_id'          =>2,
                    //'dependencia'       =>true
                ]);

            /* DB::table('modulos_dependencias')
                ->insert([
                    'modulo_id'     =>$m5->id,
                    'modulodep_id'  =>$m4->id,
                    'created_at'    =>now(),
                    'updated_at'    =>now(),
                ]); */

        $m6=Modulo::create([
            'name'              =>'frenos',
            'curso_id'          =>2
        ]);

        $m7=Modulo::create([
            'name'              =>'bajos',
            'curso_id'          =>3
        ]);

        $m8=Modulo::create([
                        'name'              =>'equalizadores',
                        'curso_id'          =>3,
                        //'dependencia'       =>false
                    ]);

                /* DB::table('modulos_dependencias')
                    ->insert([
                        'modulo_id'     =>$m8->id,
                        'modulodep_id'  =>$m7->id,
                        'created_at'    =>now(),
                        'updated_at'    =>now(),
                    ]); */



        $m9=Modulo::create([
            'name'              =>'video',
            'curso_id'          =>3
        ]);

        $m10=Modulo::create([
            'name'              =>'tiempos de sincronización',
            'curso_id'          =>4
        ]);

        $m11=Modulo::create([
                        'name'              =>'tiempos de explosión',
                        'curso_id'          =>4,
                        //'dependencia'       =>true
                    ]);

                /* DB::table('modulos_dependencias')
                    ->insert([
                        'modulo_id'     =>$m11->id,
                        'modulodep_id'  =>$m10->id,
                        'created_at'    =>now(),
                        'updated_at'    =>now(),
                    ]); */

        $m12=Modulo::create([
                        'name'              =>'ajustes de mezcla',
                        'curso_id'          =>4,
                        //'dependencia'       =>true
                    ]);

                /* DB::table('modulos_dependencias')
                ->insert([
                    'modulo_id'     =>$m12->id,
                    'modulodep_id'  =>$m11->id,
                    'created_at'    =>now(),
                    'updated_at'    =>now(),
                ]); */
    }
}
