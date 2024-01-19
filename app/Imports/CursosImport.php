<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CursosImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection($rows)
    {
        foreach($rows as $row){

            DB::table('cursos')->insert([
                'id'            => intval($row[0]),
                'name'          => strtolower($row[1]),
                'slug'          => strtolower($row[2]),
                'tipo'          => strtolower($row[3]),
                'duracion_horas'=> $row[4],
                'duracion_meses'=> $row[5],
                'status'        => intval($row[6]),
                'created_at'    => Carbon::instance(Date::excelToDateTimeObject($row[7])),
                'updated_at'    => Carbon::instance(Date::excelToDateTimeObject($row[8]))
            ]);

        }
    }
}
