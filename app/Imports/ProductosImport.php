<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProductosImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection($rows)
    {
        foreach($rows as $row){

            DB::table('productos')->insert([
                'id'            => intval($row[0]),
                'name'          => strtolower($row[1]),
                'descripcion'   => strtolower($row[2]),
                'status'        => intval($row[3]),
                'created_at'    => Carbon::instance(Date::excelToDateTimeObject($row[4])),
                'updated_at'    => Carbon::instance(Date::excelToDateTimeObject($row[5]))
            ]);

        }
    }
}
