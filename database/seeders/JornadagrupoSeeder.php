<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Academico\Grupo;
use Exception;
use Illuminate\Support\Facades\Log;

class JornadagrupoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grupos=Grupo::where('status', true)
                        ->orderBy('id', 'DESC')
                        ->get();

        foreach ($grupos as $value) {
            try {

                $name=$value->name;
                $fin='Fin Semana';
                $noche='Noche';
                $tarde='Tarde';
                $man='Mañana';

                $crt=0;

                $string = "Esta es una cadena de ejemplo.";
                $word = "cadena";

                if (strpos($name, $man) !== false) {
                    $crt=1;
                }

                if (strpos($name, $tarde) !== false) {
                    $crt=2;
                }

                if (strpos($name, $noche) !== false) {
                    $crt=3;
                }

                if (strpos($name, $fin) !== false) {
                    $crt=4;
                }

                Grupo::where('id', $value->id)
                        ->update([
                            'jornada' => $crt
                        ]);

            } catch (Exception $exception) {

                Log::info('registro: ' . $value->id . ' jornadagrupoSeeder with error: ' . $exception->getMessage().' código: '.$exception->getCode().' linea: '.$exception->getLine());

            }
        }
    }
}
