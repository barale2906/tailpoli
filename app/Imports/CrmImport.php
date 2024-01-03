<?php

namespace App\Imports;

use App\Models\Clientes\Crm;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class CrmImport implements ToCollection
{
    public $fecha;


    /**
    * @param array $this->carga
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function collection($rows)
    {
        $this->fecha=now();
        $this->fecha=date('m');

        $obs=now()." cargado por: ".Auth::user()->name;

        foreach($rows as $row){

            Crm::create([
                'gestiona_id'   =>intval($row[0]),
                'sector_id'     =>intval($row[1]),
                'fecha_carga'   =>now(),
                //'fecha_registro'=>Carbon::createFromFormat('d-m-Y',$row[2]),
                'fecha_registro'=>Carbon::instance(Date::excelToDateTimeObject($row[2])),
                'fecha_gestion' =>now(),
                'mes'           =>$this->fecha,
                'curso'         =>strtolower($row[3]),
                'name'          =>strtolower($row[4]),
                'telefono'      =>strtolower($row[5]),
                'email'         =>strtolower($row[6]),
                'historial'     =>$obs,

            ]);
        }

    }
}
