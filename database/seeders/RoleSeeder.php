<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $Superusuario=Role::create(['name'=>'Superusuario']);
        $Administrador=Role::create(['name'=>'Administrador']);
        $Coordinador=Role::create(['name'=>'Coordinador']);
        $Auxiliar=Role::create(['name'=>'Auxiliar']);
        $Profesor=Role::create(['name'=>'Profesor']);
        $Estudiante=Role::create(['name'=>'Estudiante']);

        Permission::create(['name'=>'Academico'])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);
        Permission::create(['name'=>'Cartera'])->syncRoles([$Superusuario,$Administrador,$Coordinador]);
        Permission::create(['name'=>'Financiera'])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
        Permission::create(['name'=>'Reportes'])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
        Permission::create(['name'=>'Administracion'])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
        Permission::create(['name'=>'Archivo'])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
        Permission::create(['name'=>'Configuracion'])->syncRoles([$Superusuario]);



    }
}
