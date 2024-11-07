<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Academico\Grupo;
use App\Models\Academico\Nota;
use Exception;
use Illuminate\Support\Facades\Log;

class NotaEncabezadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /* $con=Grupo::where('inscritos', '>',0)
                    ->orderBy('id', 'DESC')
                    ->get(); */

        $con=Grupo::all();

        foreach ($con as $value) {
            try {
                $nota=Nota::where('grupo_id', $value->id)
                                    ->first();

                if($nota){
                    Log::info('Line: ' . $value->id . ' YA TENIA');
                }else{
                    Nota::create([
                        'profesor_id'   =>$value->profesor_id,
                        'grupo_id'      =>$value->id,
                        'descripcion'   =>'Creado ERP Poliandino -- Seeder',
                        'registros'     =>1,
                        'nota1'         =>'final',
                        'porcen1'       =>100
                    ]);
                    Log::info('Line: ' . $value->id . ' GESTIONADO');
                }

            } catch (Exception $exception) {
                Log::info('Line: ' . $value->id . ' encabezados: ' . $exception->getMessage().' código: '.$exception->getCode().' linea: '.$exception->getLine());
            }
        }


    }
}
