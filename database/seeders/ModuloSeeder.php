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
            'slug'              =>'KitArra',
            'curso_id'          =>1,
        ]);

        $m2=Modulo::create([
                'name'              =>'sistema de arranque',
                'curso_id'          =>1,
                'slug'              =>'SisArra',
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
                    'slug'              =>'ManCompu',
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
            'curso_id'          =>2,
            'slug'              =>'Trans',
        ]);

        $m5=Modulo::create([
                    'name'              =>'diferenciales',
                    'curso_id'          =>2,
                    'slug'              =>'diferen',
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
            'curso_id'          =>2,
            'slug'              =>'frenos',
        ]);

        $m7=Modulo::create([
            'name'              =>'bajos',
            'curso_id'          =>3,
            'slug'              =>'bajos',
        ]);

        $m8=Modulo::create([
                        'name'              =>'equalizadores',
                        'curso_id'          =>3,
                        'slug'              =>'equaliz',
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
            'curso_id'          =>3,
            'slug'              =>'vid',
        ]);

        $m10=Modulo::create([
            'name'              =>'tiempos de sincronización',
            'curso_id'          =>4,
            'slug'              =>'TiemSinc',
        ]);

        $m11=Modulo::create([
                        'name'              =>'tiempos de explosión',
                        'curso_id'          =>4,
                        'slug'              =>'TiemExplo',
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
                        'slug'              =>'AjusMez',
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
