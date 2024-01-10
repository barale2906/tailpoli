<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Shared\Date;
class RegimenSaludImport implements ToCollection
{

    /**
    * @param Collection $collection
    */
    public function collection($rows)
    {
        DB::table('regimen_saluds')->where('id', '>', 1)->delete();

        foreach($rows as $row){

            DB::table('regimen_saluds')->insert([
                'id'            => intval($row[0]),
                'name'          => strtolower($row[1]),
                'status'        => intval($row[2]),
                'created_at'    => Carbon::instance(Date::excelToDateTimeObject($row[3])),
                'updated_at'    => Carbon::instance(Date::excelToDateTimeObject($row[4]))
            ]);

        }
    }
}
