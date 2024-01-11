<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GruposImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection($rows)
    {
        foreach($rows as $row){
            DB::table('grupos')->insert([
                'id'                => intval($row[0]),
                'name'              => strtolower($row[1]),
                'quantity_limit'    => intval($row[2]),
                'inscritos'         => intval($row[3]),
                'status'            => intval($row[4]),
                'sede_id'           => intval($row[5]),
                'profesor_id'       => intval($row[6]),
                'modulo_id'         => intval($row[7]),
                'created_at'        => Carbon::instance(Date::excelToDateTimeObject($row[8])),
                'updated_at'        => Carbon::instance(Date::excelToDateTimeObject($row[9]))
            ]);

            // Ojo cargar los horarios
        }
    }
}
