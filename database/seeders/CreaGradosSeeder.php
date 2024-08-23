<?php

namespace Database\Seeders;

use App\Models\Submenu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreaGradosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $Superusuario=Role::where('name','Superusuario')->first();
        $Administrador=Role::where('name','Administrador')->first();
        $Coordinador=Role::where('name','Coordinador')->first();
        $Auxiliar=Role::where('name','Auxiliar')->first();

        Permission::create([
                        'name'=>'ac_graduaciones',
                        'descripcion'=>'Acceso al modulo de graduaciones.',
                        'modulo'=>'academico'
                    ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);

        Permission::create([
                        'name'=>'ac_graduaciones_editar',
                        'descripcion'=>'Edita la información de graduaciones.',
                        'modulo'=>'academico'
                    ])->syncRoles([$Superusuario,$Administrador,$Coordinador]);

        Permission::create([
                        'name'=>'ac_graduaciones_aprobar',
                        'descripcion'=>'Aprueba la graduación de un estudiante.',
                        'modulo'=>'academico'
                    ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);

        Submenu::create([
            'permiso'           => 'ac_graduaciones',
            'ruta'              => 'academico.gradua',
            'identificaRuta'    => 'academico.gradua',
            'name'              => 'Graduaciones',
            'icono'             => 'fa-solid fa-book text-gray-500',
            'menu_id'           => 1

        ]);
    }
}
