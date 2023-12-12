<?php

namespace App\Imports;

use App\Models\Academico\Nota as AcademicoNota;
use Maatwebsite\Excel\Concerns\ToModel;

class NotasImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new AcademicoNota([
            //defino todas las columnas
        ]);
    }
}
