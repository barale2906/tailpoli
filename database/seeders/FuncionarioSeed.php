<?php

namespace Database\Seeders;

use App\Models\Humana\Funcionario;
use App\Models\User;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class FuncionarioSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $funcionarios=User::where('rol_id','<',6)
                            ->get();

        foreach ($funcionarios as $value) {
            try {
                $rol=Role::find($value->rol_id);
                Funcionario::create([
                    'user_id'=>$value->id,
                    'cargo'=>$rol->name,
                    'tipo_contrato'=>1,
                    'educacion'=>'básico',
                    'contrato'=>now(),
                    'salario'=>0,
                    'fecha_inicio'=>now(),
                    'banco'=>'Banco',
                    'cuenta'=>'pendiente',
                    'arl'=>'Sura',
                    'porcen_arl'=>0.522,
                    'pension'=>'pendiente',
                    'eps'=>'pendiente',
                    'caja'=>'pendiente',
                    'conyuge'=>' ',
                    'observaciones'=>now().': se carga a la base de funcionarios.',
                ]);
            } catch(Exception $exception){
                Log::info('Line: ' . $value->id . ' FuncionarioSeed with error: ' . $exception->getMessage());
            }

        }
    }
}
