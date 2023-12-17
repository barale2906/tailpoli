<?php

namespace App\Imports;

use App\Models\Clientes\Crm;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;

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
                'fecha'         =>now(),
                'mes'           =>$this->fecha,
                'curso'         =>strtolower($row[2]),
                'name'          =>strtolower($row[3]),
                'telefono'      =>strtolower($row[4]),
                'email'         =>strtolower($row[5]),
                'historial'     =>$obs,

            ]);
        }

    }
}
