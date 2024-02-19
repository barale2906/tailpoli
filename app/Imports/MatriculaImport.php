<?php

namespace App\Imports;

use App\Models\Academico\Grupo;
use App\Models\Academico\Modulo;
use App\Models\Clientes\Pqrs;
use App\Models\Configuracion\Documento;
use App\Models\User;
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

            $modCar=Grupo::find(intval($row[15]));
            $creador=User::where('id',intval($row[16]))->select('id', 'name')->first();

            // Cargar modulos
            $modulos=Modulo::where('curso_id', intval($row[9]))
                                ->orderBy('name')
                                ->get();

            foreach ($modulos as $value) {
                DB::table('matricula_modulos_aprobacion')
                    ->insert([
                        'matricula_id'  =>intval($row[0]),
                        'alumno_id'     =>intval($row[8]),
                        'modulo_id'     =>$value->id,
                        'name'          =>$value->name,
                        'dependencia'   =>$value->dependencia,
                        'observaciones' =>Carbon::instance(Date::excelToDateTimeObject($row[13]))." ".$creador->name." Genera el registro.",
                        'created_at'    =>Carbon::instance(Date::excelToDateTimeObject($row[13])),
                        'updated_at'    =>Carbon::instance(Date::excelToDateTimeObject($row[14]))
                    ]);

                    //Identificar y cargar los grupos por modulo

                    if($value->id===$modCar->modulo_id){

                        DB::table('grupo_matricula')
                            ->insert([
                                'grupo_id'      =>intval($row[15]),
                                'matricula_id'  =>intval($row[0]),
                                'created_at'    =>Carbon::instance(Date::excelToDateTimeObject($row[13])),
                                'updated_at'    =>Carbon::instance(Date::excelToDateTimeObject($row[14]))
                            ]);


                        //Cargar estudiante al grupo
                        DB::table('grupo_user')
                            ->insert([
                                'grupo_id'      =>intval($row[15]),
                                'user_id'       =>intval($row[8]),
                                'created_at'    =>Carbon::instance(Date::excelToDateTimeObject($row[13])),
                                'updated_at'    =>Carbon::instance(Date::excelToDateTimeObject($row[14]))
                            ]);



                        //Sumar usuario al grupo

                        $tot=$modCar->inscritos+1;

                        $modCar->update([
                            'inscritos'=>$tot
                        ]);

                    }else{

                        //Sumar usuario al grupo
                        $inscritos=Grupo::where('modulo_id', $value->id)
                                        ->inRandomOrder()
                                        ->first();

                        DB::table('grupo_matricula')
                            ->insert([
                                'grupo_id'      =>$inscritos->id,
                                'matricula_id'  =>intval($row[0]),
                                'created_at'    =>Carbon::instance(Date::excelToDateTimeObject($row[13])),
                                'updated_at'    =>Carbon::instance(Date::excelToDateTimeObject($row[14]))
                            ]);

                        //Cargar estudiante al grupo
                        DB::table('grupo_user')
                            ->insert([
                                'grupo_id'      =>$inscritos->id,
                                'user_id'       =>intval($row[8]),
                                'created_at'    =>Carbon::instance(Date::excelToDateTimeObject($row[13])),
                                'updated_at'    =>Carbon::instance(Date::excelToDateTimeObject($row[14]))
                            ]);

                        $tot=$inscritos->inscritos+1;

                        $inscritos->update([
                            'inscritos'=>$tot
                        ]);
                    }
            }

            // Cargar documentos
            $documentos=Documento::where('status', 3)
                                ->whereIn('tipo', ['contrato','pagare','cartapagare','actaPago','comproCredito','comproEntrega','gastocertifinal','matricula'])
                                ->orderBy('titulo')
                                ->select('id')
                                ->get();

            //Asignar documentos base
            foreach ($documentos as $value) {
                DB::table('documento_matricula')
                        ->insert([
                            'documento_id'   =>$value->id,
                            'matricula_id'   =>intval($row[0]),
                            'created_at'     =>Carbon::instance(Date::excelToDateTimeObject($row[13])),
                            'updated_at'     =>Carbon::instance(Date::excelToDateTimeObject($row[14]))
                        ]);
            }

            // Cargar PQRS
            Pqrs::create([
                'estudiante_id' =>intval($row[8]),
                'gestion_id'    =>$creador->id,
                'fecha'         =>Carbon::instance(Date::excelToDateTimeObject($row[13])),
                'tipo'          =>4,
                'observaciones' =>'ACÁDEMICO: Matriculado ----- ',
                'status'        =>4
            ]);
        }
    }
}
