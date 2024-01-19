<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SectorsImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection($rows)
    {
        foreach($rows as $row){

            DB::table('sectors')->insert([
                'id'            => intval($row[0]),
                'state_id'      => strtolower($row[1]),
                'name'          => strtolower($row[2]),
                'slug'          => strtolower($row[3]),
                'status'        => intval($row[4]),
                'created_at'    => Carbon::instance(Date::excelToDateTimeObject($row[5])),
                'updated_at'    => Carbon::instance(Date::excelToDateTimeObject($row[6]))
            ]);

        }
    }
}
