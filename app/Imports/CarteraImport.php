<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CarteraImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection($rows)
    {
        foreach($rows as $row){
            DB::table('carteras')->insert([
                'id'                    => intval($row[0]),
                'fecha_pago'            => Carbon::instance(Date::excelToDateTimeObject($row[1])),
                'fecha_real'            => Carbon::instance(Date::excelToDateTimeObject($row[2])),
                'valor'                 => intval($row[3]),
                'saldo'                 => intval($row[4]),
                'observaciones'         => strtolower($row[5]),
                'status'                => intval($row[6]),
                'matricula_id'          => intval($row[7]),
                'estado_cartera_id'     => intval($row[8]),
                'concepto_pago_id'      => intval($row[9]),
                'concepto'              => strtolower($row[10]),
                'responsable_id'        => intval($row[11]),
                'created_at'            => Carbon::instance(Date::excelToDateTimeObject($row[12])),
                'updated_at'            => Carbon::instance(Date::excelToDateTimeObject($row[13]))
            ]);
        }
    }
}
