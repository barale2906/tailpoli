<?php

namespace Database\Seeders;

use App\Models\Admin\RegimenSalud;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RegimenSaludSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /* RegimenSalud::create([
            'name' => 'sisben v2 nivel 1',
            'created_at'=>'2019-05-17 09:16:08',
            'updated_at'=>'2019-05-17 09:16:08',
        ]);

        RegimenSalud::create([
            'name' => 'Sisben 1',
        ]);

        RegimenSalud::create([
            'name' => 'Sisben 2',
        ]);

        RegimenSalud::create([
            'name' => 'Sisben 3',
        ]);

        RegimenSalud::create([
            'name' => 'Sisben 4',
        ]); */

        $row = 0;

        if(($handle = fopen(public_path() . '/csv/1-health_regimes-8.csv', 'r')) !== false) {

            while(($data = fgetcsv($handle, 26000, ';')) !== false) {

                $row++;

                try {

                    $data[3]=date("Y-m-d H:i:s");
                    $data[4]=date("Y-m-d H:i:s");

                    DB::table('regimen_saluds')->insert([
                        'id'            => intval($data[0]),
                        'name'          => strtolower($data[1]),
                        'status'        => intval($data[2]),
                        'created_at'    => $data[3],
                        'updated_at'    => $data[4]
                    ]);

                }catch(Exception $exception){
                    Log::info('Line: ' . $row . ' 1-health_regimes-8 with error: ' . $exception->getMessage());
                }
            }
        }

        fclose($handle);


    }
}
