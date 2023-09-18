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
        Permission::create(['name'=>'ac_cursos'])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);
        Permission::create(['name'=>'ac_cursoCrear'])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);
        Permission::create(['name'=>'ac_cursoEditar'])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);
        Permission::create(['name'=>'ac_cursoInactivar'])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);

        Permission::create(['name'=>'ac_horarios'])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);
        Permission::create(['name'=>'ac_horarioCrear'])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);
        Permission::create(['name'=>'ac_horarioEditar'])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);
        Permission::create(['name'=>'ac_horarioInactivar'])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);

        Permission::create(['name'=>'ac_modulos'])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);
        Permission::create(['name'=>'ac_moduloCrear'])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);
        Permission::create(['name'=>'ac_moduloEditar'])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);
        Permission::create(['name'=>'ac_moduloInactivar'])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);


        Permission::create(['name'=>'Cartera'])->syncRoles([$Superusuario,$Administrador,$Coordinador]);



        Permission::create(['name'=>'Financiera'])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
        Permission::create(['name'=>'fi_conceptopagos'])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
        Permission::create(['name'=>'fi_conceptopagoCrear'])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
        Permission::create(['name'=>'fi_conceptopagoEditar'])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
        Permission::create(['name'=>'fi_conceptopagoInactivar'])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);


        Permission::create(['name'=>'Inventario'])->syncRoles([$Superusuario,$Administrador,$Coordinador,]);
        Permission::create(['name'=>'in_productos'])->syncRoles([$Superusuario,$Administrador,$Coordinador,]);
        Permission::create(['name'=>'in_productoCrear'])->syncRoles([$Superusuario,$Administrador,$Coordinador,]);
        Permission::create(['name'=>'in_productoEditar'])->syncRoles([$Superusuario,$Administrador,$Coordinador,]);
        Permission::create(['name'=>'in_productoInactivar'])->syncRoles([$Superusuario,$Administrador,$Coordinador,]);

        Permission::create(['name'=>'in_almacens'])->syncRoles([$Superusuario,$Administrador,$Coordinador,]);
        Permission::create(['name'=>'in_almacenCrear'])->syncRoles([$Superusuario,$Administrador,$Coordinador,]);
        Permission::create(['name'=>'in_almacenEditar'])->syncRoles([$Superusuario,$Administrador,$Coordinador,]);
        Permission::create(['name'=>'in_almacenInactivar'])->syncRoles([$Superusuario,$Administrador,$Coordinador,]);

        Permission::create(['name'=>'in_inventarios'])->syncRoles([$Superusuario,$Administrador,$Coordinador,]);
        Permission::create(['name'=>'in_inventarioCrear'])->syncRoles([$Superusuario,$Administrador,$Coordinador,]);
        Permission::create(['name'=>'in_inventarioEditar'])->syncRoles([$Superusuario,$Administrador,$Coordinador,]);
        Permission::create(['name'=>'in_inventarioInactivar'])->syncRoles([$Superusuario,$Administrador,$Coordinador,]);


        Permission::create(['name'=>'Reportes'])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);



        Permission::create(['name'=>'Administracion'])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
        Permission::create(['name'=>'ad_saluds'])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
        Permission::create(['name'=>'ad_saludCrear'])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
        Permission::create(['name'=>'ad_saludEditar'])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
        Permission::create(['name'=>'ad_saludInactivar'])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);

        Permission::create(['name'=>'ad_multis'])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
        Permission::create(['name'=>'ad_multiCrear'])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
        Permission::create(['name'=>'ad_multiEditar'])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
        Permission::create(['name'=>'ad_multiInactivar'])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);


        Permission::create(['name'=>'Archivo'])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);


        Permission::create(['name'=>'Configuracion'])->syncRoles([$Superusuario]);
        Permission::create(['name'=>'co_estados'])->syncRoles([$Superusuario]);
        Permission::create(['name'=>'co_estadoCrear'])->syncRoles([$Superusuario]);
        Permission::create(['name'=>'co_estadoEditar'])->syncRoles([$Superusuario]);
        Permission::create(['name'=>'co_estadoInactivar'])->syncRoles([$Superusuario]);

        Permission::create(['name'=>'co_countrys'])->syncRoles([$Superusuario]);
        Permission::create(['name'=>'co_countryCrear'])->syncRoles([$Superusuario]);
        Permission::create(['name'=>'co_countryEditar'])->syncRoles([$Superusuario]);
        Permission::create(['name'=>'co_countryInactivar'])->syncRoles([$Superusuario]);

        Permission::create(['name'=>'co_areas'])->syncRoles([$Superusuario]);
        Permission::create(['name'=>'co_areaCrear'])->syncRoles([$Superusuario]);
        Permission::create(['name'=>'co_areaEditar'])->syncRoles([$Superusuario]);
        Permission::create(['name'=>'co_areaInactivar'])->syncRoles([$Superusuario]);

        Permission::create(['name'=>'co_sedes'])->syncRoles([$Superusuario]);
        Permission::create(['name'=>'co_sedeCrear'])->syncRoles([$Superusuario]);
        Permission::create(['name'=>'co_sedeEditar'])->syncRoles([$Superusuario]);
        Permission::create(['name'=>'co_sedeInactivar'])->syncRoles([$Superusuario]);




    }
}
