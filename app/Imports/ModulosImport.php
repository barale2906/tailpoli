<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ModulosImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection($rows)
    {
        foreach($rows as $row){
            DB::table('modulos')->insert([
                'id'            => intval($row[0]),
                'name'          => strtolower($row[1]),
                'slug'          => strtolower($row[2]),
                'status'        => intval($row[3]),
                'curso_id'      => intval($row[4]),
                'created_at'    => Carbon::instance(Date::excelToDateTimeObject($row[5])),
                'updated_at'    => Carbon::instance(Date::excelToDateTimeObject($row[6]))
            ]);
        }
    }
}
