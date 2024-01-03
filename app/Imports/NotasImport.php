<?php

namespace App\Imports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;

class NotasImport implements ToCollection
{
    public $registro=0;
    public $carga=[];

    /**
    * @param array $this->carga
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function collection($rows)
    {

        foreach($rows as $row){

                unset($this->carga);
                $this->carga=array();

                for ($i=0; $i <= 28; $i++) {

                    if(isset($row[$i])){

                        if($i<8){
                            array_push($this->carga, $row[$i]);
                        }else if($i>=8){
                            if( $row[$i]>=5){
                                array_push($this->carga,5);
                            }
                            if( $row[$i]<=0){
                                array_push($this->carga,0);
                            }
                        }
                    }else{
                        array_push($this->carga, null);
                    }
                }

            DB::table('notas_detalle')
                ->insert([
                    'nota_id'       =>$this->carga[0],
                    'alumno_id'     =>$this->carga[1],
                    'alumno'        =>$this->carga[2],
                    'profesor_id'   =>$this->carga[3],
                    'profesor'      =>$this->carga[4],
                    'grupo_id'      =>$this->carga[5],
                    'grupo'         =>$this->carga[6],
                    'observaciones' =>$this->carga[7],
                    'acumulado'     =>$this->carga[8],
                    'nota1'         =>$this->carga[9],
                    'porcen1'       =>$this->carga[10],
                    'nota2'         =>$this->carga[11],
                    'porcen2'       =>$this->carga[12],
                    'nota3'         =>$this->carga[13],
                    'porcen3'       =>$this->carga[14],
                    'nota4'         =>$this->carga[15],
                    'porcen4'       =>$this->carga[16],
                    'nota5'         =>$this->carga[17],
                    'porcen5'       =>$this->carga[18],
                    'nota6'         =>$this->carga[19],
                    'porcen6'       =>$this->carga[20],
                    'nota7'         =>$this->carga[21],
                    'porcen7'       =>$this->carga[22],
                    'nota8'         =>$this->carga[23],
                    'porcen8'       =>$this->carga[24],
                    'nota9'         =>$this->carga[25],
                    'porcen9'       =>$this->carga[26],
                    'nota10'        =>$this->carga[27],
                    'porcen10'      =>$this->carga[28],
                    'created_at'    =>now(),
                    'updated_at'    =>now()
                ]);

        }

    }
}
