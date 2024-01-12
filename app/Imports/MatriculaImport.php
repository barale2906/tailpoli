<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MatriculaImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection($rows)
    {
        foreach($rows as $row){
            DB::table('matriculas')->insert([
                'id'            => intval($row[0]),
                'fecha_inicia'  => Carbon::instance(Date::excelToDateTimeObject($row[1])),
                'medio'         => strtolower($row[2]),
                'nivel'         => strtolower($row[3]),
                'valor'         => $row[4],
                'metodo'        => strtolower($row[5]),
                'status'        => intval($row[6]),
                'configpago'    => intval($row[7]),
                'alumno_id'     => intval($row[8]),
                'curso_id'      => intval($row[9]),
                'comercial_id'  => intval($row[10]),
                'creador_id'    => intval($row[11]),
                'sede_id'       => intval($row[12]),
                'created_at'    => Carbon::instance(Date::excelToDateTimeObject($row[13])),
                'updated_at'    => Carbon::instance(Date::excelToDateTimeObject($row[14]))
            ]);

            // Ojo cargar los horarios
        }
    }
}
