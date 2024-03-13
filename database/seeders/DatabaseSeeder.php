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
            ProductoSeeder::class,
            CursoSeeder::class,
            ConceptoPagoSeeder::class,
            AreaSeeder::class,
            //HorarioSeeder::class, //Este se bloquea cuando se hacen seeders completos.
            StateSeeder::class,
            SectorSeeder::class,
            SedeSeeder::class,
            AlmacenSeeder::class, //inventory whirehouses
            ModuloSeeder::class,
            RoleSeeder::class,
            UserSeeder::class, //Solo se carga el superusuario
            GrupoSeeder::class,
            //GruponSeeder::class,
            //HorarionSeeder::class,
            //CicloSeeder::class,
            EstudianteSeeder::class,
            PalabrasSeeder::class,
            DocumentoSeeder::class, //se carga depués de cargar las sedes y usuarios
            //InventarioSeeder::class,

            MatriculaSeeder::class, //Este se bloquea cuando se hacen seeders completos.
            EstadoCarteraSeeder::class,
            CarteraSeeder::class,
            CarteraEspSeeder::class,
            CarteratresieteSeeder::class,
            CarterafinSeeder::class,
            RecibopagoSeeder::class,
            RecibopagodetalleSeeder::class,
            RecibopagoinvSeeder::class,
            RecibopagodetalleinvSeeder::class,
            //ConfiguracioPagoSeeder::class,
        ]);
    }
}
