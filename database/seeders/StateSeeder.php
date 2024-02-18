<?php

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $row = 0;

        if(($handle = fopen(public_path() . '/csv/5-states-5.csv', 'r')) !== false) {

                while(($data = fgetcsv($handle, 26000, ';')) !== false) {

                    $row++;

                    try {

                        DB::table('states')->insert([
                            'id'            => intval($data[0]),
                            'country_id'    => strtolower($data[1]),
                            'name'          => strtolower($data[2]),
                            'status'        => intval($data[3]),
                            'created_at'    => $data[4],
                            'updated_at'    => $data[5]
                        ]);

                    }catch(Exception $exception){
                        Log::info('Line: ' . $row . ' with error: ' . $exception->getMessage());
                    }
                }
            }

            fclose($handle);


        /*State::create([
            'name' => 'Bogotá',
            'country_id' => 1,
            'created_at'=>'2019-05-16 20:58:16',
            'updated_at'=>'2019-05-16 20:58:16',
        ]);

        State::create([
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
