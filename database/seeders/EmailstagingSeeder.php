<?php

namespace Database\Seeders;

use App\Models\User;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class EmailstagingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estudiantes=User::where('rol_id', 6)->get();

        foreach ($estudiantes as $value) {
            try {
                $emailMod='--st1--'.$value->email;
                $value->update([
                    'email'=>$emailMod
                ]);
                $value->perfil->update([
                    'email'=>$emailMod
                ]);
            } catch(Exception $exception){
                Log::info('fila: '.$value->id.' Error al modificar el email: '. $exception->getMessage().' linea código: '.$exception->getLine() );
            }
        }
    }
}
