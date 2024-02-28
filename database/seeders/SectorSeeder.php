<?php

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $row = 0;

        if(($handle = fopen(public_path() . '/csv/6-sectors-16.csv', 'r')) !== false) {

                while(($data = fgetcsv($handle, 26000, ';')) !== false) {

                    $row++;

                    try {

                        DB::table('sectors')->insert([
                            'id'            => intval($data[0]),
                            'state_id'      => strtolower($data[1]),
                            'name'          => strtolower($data[2]),
                            'slug'          => strtolower($data[3]),
                            'status'        => intval($data[4]),
                            'created_at'    => $data[5],
                            'updated_at'    => $data[6]
                        ]);

                    }catch(Exception $exception){
                        Log::info('Line: ' . $row . ' 6-sectors-16 with error: ' . $exception->getMessage());
                    }
                }
            }

            fclose($handle);
        /*Sector::create([
            'name' => 'BOGOTA-BOGOTA, D.C. 11001',
            'slug' => 'bta',
            'state_id' => 1,
            'created_at'=>'2019-05-31 09:16:08',
            'updated_at'=>'2019-05-31 09:16:08',
        ]);

        Sector::create([
            'name' => 'Chía',
            'slug' => 'chia',
            'state_id' => 1,
        ]);
        Sector::create([
            'name' => 'Cajicá',
            'slug' => 'caji',
            'state_id' => 1,
        ]);
        Sector::create([
            'name' => 'Bogotá',
            'slug' => 'bta',
            'state_id' => 2,
        ]);
        Sector::create([
            'name' => 'Pereira',
            'slug' => 'pere',
            'state_id' => 3,
        ]);
        Sector::create([
            'name' => 'Pasto',
            'slug' => 'past',
            'state_id' => 4,
        ]);
        Sector::create([
            'name' => 'Bucaramanga',
            'slug' => 'buca',
            'state_id' => 5,
        ]);
        Sector::create([
            'name' => 'Malaga',
            'slug' => 'malag',
            'state_id' => 5,
        ]); */
    }
}
