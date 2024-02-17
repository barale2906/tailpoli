<?php

namespace App\Imports;

use App\Models\Clientes\Pqrs;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;

class RecibopagoImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection($rows)
    {
        foreach ($rows as $row) {

            //Cargar recibo y detalle desde el mismo archivo para academico e inventarios

            DB::table('recibo_pagos')->insert([

                'numero_recibo'     =>intval($row[0]),
                'origen'            =>intval($row[1]),                           //'false externo - dotaciones-otros, true interno - propio del instituto
                'fecha'             =>Carbon::instance(Date::excelToDateTimeObject($row[2])),
                'valor_total'       =>intval($row[3]),
                'medio'             =>strtolower($row[4]),
                'observaciones'     =>strtolower($row[5]),
                'status'            =>intval($row[6]),
                'sede_id'           =>intval($row[7]),
                'creador_id'        =>intval($row[8]),
                'paga_id'           =>intval($row[9]),
                'created_at'        =>Carbon::instance(Date::excelToDateTimeObject($row[10])),
                'updated_at'        =>Carbon::instance(Date::excelToDateTimeObject($row[11])),

            ]);

            //Cargar fecha de pago y observaciones al control
            Pqrs::create([
                'estudiante_id' =>intval($row[9]),
                'gestion_id'    =>intval($row[8]),
                'fecha'         =>Carbon::instance(Date::excelToDateTimeObject($row[2])),
                'tipo'          =>2,
                'observaciones' =>'PAGOS: '." realizo pago por $".number_format(intval($row[3]), 0, ',', '.').", con el recibo N°: ".intval($row[0]).". ----- ",
                'status'        =>4
            ]);
        }
    }
}
