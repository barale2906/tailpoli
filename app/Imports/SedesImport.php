<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SedesImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection($rows)
    {
        foreach($rows as $row){

            DB::table('sedes')->insert([
                'id'                        => intval($row[0]),
                'sector_id'                 => strtolower($row[1]),
                'name'                      => strtolower($row[2]),
                'slug'                      => strtolower($row[3]),
                'address'                   => strtolower($row[4]),
                'nit'                       => strtolower($row[5]),
                'phone'                     => strtolower($row[6]),
                'portfolio_assistant_name'  => strtolower($row[7]),
                'portfolio_assistant_phone' => strtolower($row[8]),
                'portfolio_assistant_email' => strtolower($row[9]),
                'start'                     => '06:00:00',
                'finish'                    => '22:00:00',
                'status'                    => intval($row[10]),
                'created_at'                => Carbon::instance(Date::excelToDateTimeObject($row[11])),
                'updated_at'                => Carbon::instance(Date::excelToDateTimeObject($row[12]))
            ]);

        }
    }
}
