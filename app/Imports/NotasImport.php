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
            'nota_id'       =>$row[0],
            'alumno_id'     =>$row[1],
            'alumno'        =>$row[2],
            'profesor_id'   =>$row[3],
            'profesor'      =>$row[4],
            'grupo_id'      =>$row[5],
            'grupo'         =>$row[6],
            'acumulado'     =>$row[7],
            'observaciones' =>$row[8],
            'nota1'         =>$row[9],
            'porcen1'       =>$row[10],
            'nota2'         =>$row[11],
            'porcen2'       =>$row[12],
            'nota3'         =>$row[13],
            'porcen3'       =>$row[14],
            'nota4'         =>$row[15],
            'porcen4'       =>$row[16],
            'nota5'         =>$row[17],
            'porcen5'       =>$row[18],
            'nota6'         =>$row[19],
            'porcen6'       =>$row[20],
            'nota7'         =>$row[21],
            'porcen7'       =>$row[22],
            'nota8'         =>$row[23],
            'porcen8'       =>$row[24],
            'nota9'         =>$row[25],
            'porcen9'       =>$row[26],
            'nota10'        =>$row[27],
            'porcen10'      =>$row[28],
        ]);
    }
}
