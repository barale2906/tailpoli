<?php

namespace Database\Seeders;

use App\Models\Inventario\Almacen;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AlmacenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $row = 0;

        if(($handle = fopen(public_path() . '/csv/9-almacenes-19.csv', 'r')) !== false) {

                while(($data = fgetcsv($handle, 26000, ';')) !== false) {

                    $row++;

                    try {

                        $creado=new Carbon($data[4]);
                        $crea=$creado->format('Y-m-d H:i:s');

                        $actualiza=new Carbon($data[5]);
                        $actua=$actualiza->format('Y-m-d H:i:s');

                        DB::table('almacens')->insert([
                            'id'            => intval($data[0]),
                            'name'          => strtolower($data[1]),
                            'status'        => intval($data[2]),
                            'sede_id'       => intval($data[3]),
                            'created_at'    => $data[4],
                            'updated_at'    => $data[5]
                        ]);

                    }catch(Exception $exception){
                        Log::info('Line: ' . $row . ' 9-almacenes-19 with error: ' . $exception->getMessage());
                    }
                }
        }

        fclose($handle);

        /* Almacen::create([
            'name' => 'ropas',
            'sede_id'=> 1
        ]);

        Almacen::create([
            'name' => 'insumos aseo',
            'sede_id'=> 1
        ]);

        Almacen::create([
            'name' => 'papelería',
            'sede_id'=> 1
        ]);

        Almacen::create([
            'name' => 'ropas sede 2',
            'sede_id'=> 2
        ]);

        Almacen::create([
            'name' => 'insumos aseo sede 2',
            'sede_id'=> 2
        ]);

        Almacen::create([
            'name' => 'papelería sede 2',
            'sede_id'=> 2
        ]); */
    }
}
