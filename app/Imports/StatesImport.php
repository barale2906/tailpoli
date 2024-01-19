<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StatesImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection($rows)
    {
        foreach($rows as $row){

            DB::table('states')->insert([
                'id'            => intval($row[0]),
                'country_id'    => strtolower($row[1]),
                'name'          => strtolower($row[2]),
                'status'        => intval($row[3]),
                'created_at'    => Carbon::instance(Date::excelToDateTimeObject($row[4])),
                'updated_at'    => Carbon::instance(Date::excelToDateTimeObject($row[5]))
            ]);

        }
    }
}
