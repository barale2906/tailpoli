<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AlamcenesImnport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection($rows)
    {
        foreach($rows as $row){
            DB::table('almacens')->insert([
                'id'            => intval($row[0]),
                'name'          => strtolower($row[1]),
                'status'        => intval($row[2]),
                'sede_id'      => intval($row[3]),
                'created_at'    => Carbon::instance(Date::excelToDateTimeObject($row[4])),
                'updated_at'    => Carbon::instance(Date::excelToDateTimeObject($row[5]))
            ]);
        }
    }
}
