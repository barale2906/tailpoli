<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PalabrasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('palabras_clave')
                ->insert([
                    'palabra'=>'fopaprimerdia',
                    'descripcion'=>'Día de pago de la primer cuota.',
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ]);

        DB::table('palabras_clave')
                ->insert([
                    'palabra'=>'fopaprimermes',
                    'descripcion'=>'Mes de pago de la primer cuota.',
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ]);

        DB::table('palabras_clave')
                ->insert([
                    'palabra'=>'fopaprimeryear',
                    'descripcion'=>'Mes de pago de la primer cuota.',
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ]);

        /* DB::table('palabras_clave')
                ->insert([
                    'palabra'=>'matriculaEstu',
                    'descripcion'=>'Numero de matricula del estudiante',
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ]);

        DB::table('palabras_clave')
                ->insert([
                    'palabra'=>'matriculaInicia',
                    'descripcion'=>'Fecha de inicio del estudiante',
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ]);

        DB::table('palabras_clave')
                ->insert([
                    'palabra'=>'nombreEstu',
                    'descripcion'=>'Nombre del estudiante',
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ]);

        DB::table('palabras_clave')
                ->insert([
                    'palabra'=>'documentoEstu',
                    'descripcion'=>'documento del estudiante',
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ]);

        DB::table('palabras_clave')
                ->insert([
                    'palabra'=>'tipodocuEstu',
                    'descripcion'=>'tipo de documento del estudiante',
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ]);

        DB::table('palabras_clave')
                ->insert([
                    'palabra'=>'docuExpedi',
                    'descripcion'=>'Lugar de expedición de la cédula del estudiante',
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ]);

        DB::table('palabras_clave')
                ->insert([
                    'palabra'=>'direccionEstu',
                    'descripcion'=>'direccion del estudiante',
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ]);

        DB::table('palabras_clave')
                ->insert([
                    'palabra'=>'ciudadEstu',
                    'descripcion'=>'ciudad del estudiante',
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ]);

        DB::table('palabras_clave')
                ->insert([
                    'palabra'=>'telefonoEstu',
                    'descripcion'=>'teléfono del estudiante',
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ]);

        DB::table('palabras_clave')
                ->insert([
                    'palabra'=>'cursoEstu',
                    'descripcion'=>'Curso al que se inscribio estudiante',
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ]);

        DB::table('palabras_clave')
                ->insert([
                    'palabra'=>'valorMatricula',
                    'descripcion'=>'Valor de la matricula del estudiante',
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ]);

        DB::table('palabras_clave')
                ->insert([
                    'palabra'=>'valorMatLetras',
                    'descripcion'=>'Valor de la matricula en letras',
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ]);

        DB::table('palabras_clave')
                ->insert([
                    'palabra'=>'nitInsti',
                    'descripcion'=>'NIT del poliandino',
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ]);
        DB::table('palabras_clave')
                ->insert([
                    'palabra'=>'nombreInsti',
                    'descripcion'=>'Nombre del poliandino',
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ]);

        DB::table('palabras_clave')
                ->insert([
                    'palabra'=>'rlInsti',
                    'descripcion'=>'Representante Legal del poliandino',
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ]);

        DB::table('palabras_clave')
                ->insert([
                    'palabra'=>'rldocInsti',
                    'descripcion'=>'Documento Representante Legal del poliandino',
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ]);

        DB::table('palabras_clave')
                ->insert([
                    'palabra'=>'dirInsti',
                    'descripcion'=>'dirección legal del poliandino',
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ]);

        DB::table('palabras_clave')
                ->insert([
                    'palabra'=>'telInsti',
                    'descripcion'=>'teléfono legal del poliandino',
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ]);

        DB::table('palabras_clave')
                ->insert([
                    'palabra'=>'deuda',
                    'descripcion'=>'valor en mora',
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ]);
 */

    }
}
