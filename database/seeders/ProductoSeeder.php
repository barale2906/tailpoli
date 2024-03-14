<?php

namespace Database\Seeders;

use App\Models\Inventario\Producto;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $row = 0;

        if(($handle = fopen(public_path() . '/csv/2-inventory_products-11.csv', 'r')) !== false) {

            while(($data = fgetcsv($handle, 26000, ';')) !== false) {

                $row++;

                try {


                    $creado=new Carbon($data[4]);
                    $crea=$creado->format('Y-m-d H:i:s');

                    $actualiza=new Carbon($data[5]);
                    $actua=$actualiza->format('Y-m-d H:i:s');


                    DB::table('productos')->insert([
                        'id'            => intval($data[0]),
                        'name'          => strtolower($data[1]),
                        'descripcion'   => strtolower($data[2]),
                        'status'        => intval($data[3]),
                        'created_at'    => $data[4],
                        'updated_at'    => $data[5]
                    ]);

                }catch(Exception $exception){
                    Log::info('Line: ' . $row . ' 2-inventory_products-11 with error: ' . $exception->getMessage());
                }
            }
        }

        fclose($handle);
        /* Producto::create([
            'name' => 'kit overol manga corta xs',
            'descripcion'=> 'kit overol manga corta xs'
        ]);

        Producto::create([
            'name' => 'kit overol manga corta x',
            'descripcion'=> 'kit overol manga corta x'
        ]);

        Producto::create([
            'name' => 'kit overol manga corta xl',
            'descripcion'=> 'kit overol manga corta xl'
        ]);

        Producto::create([
            'name' => 'kit overol manga larga xs',
            'descripcion'=> 'kit overol manga larga xs'
        ]);

        Producto::create([
            'name' => 'kit overol manga larga x',
            'descripcion'=> 'kit overol manga larga x'
        ]);

        Producto::create([
            'name' => 'kit overol manga larga xl',
            'descripcion'=> 'kit overol manga larga xl'
        ]); */
    }
}
