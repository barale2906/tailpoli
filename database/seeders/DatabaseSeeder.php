<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Financiera\EstadoCartera;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CountrySeeder::class,
            MenuSeeder::class,
            RegimenSaludSeeder::class,
            PersonaMulticulturalSeeder::class,
            EstadoSeeder::class,
            //ProductoSeeder::class,
            //CursoSeeder::class,
            ConceptoPagoSeeder::class,
            AreaSeeder::class,
            //HorarioSeeder::class,
            StateSeeder::class,
            SectorSeeder::class,
            SedeSeeder::class,
            //AlmacenSeeder::class, //inventory whirehouses
            //ModuloSeeder::class,
            RoleSeeder::class,
            UserSeeder::class, //Solo se carga el superusuario
            //InventarioSeeder::class,
            //GrupoSeeder::class,
            //MatriculaSeeder::class,
            EstadoCarteraSeeder::class,
            //ConfiguracioPagoSeeder::class,
            PalabrasSeeder::class,
            //DocumentoSeeder::class, //se carga depués de cargar las sedes y usuarios
        ]);
    }
}
