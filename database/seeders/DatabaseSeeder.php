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
            Menuseeder::class,
            RegimenSaludSeeder::class,
            PersonaMulticulturalSeeder::class,
            EstadoSeeder::class,
            ProductoSeeder::class,
            CursoSeeder::class,
            ConceptoPagoSeeder::class,
            AreaSeeder::class,
            HorarioSeeder::class,
            StateSeeder::class,
            SectorSeeder::class,
            SedeSeeder::class,
            AlmacenSeeder::class,
            ModuloSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            InventarioSeeder::class,
            GrupoSeeder::class,
            //MatriculaSeeder::class,
            EstadoCarteraSeeder::class,
            ConfiguracioPagoSeeder::class,
        ]);
    }
}
