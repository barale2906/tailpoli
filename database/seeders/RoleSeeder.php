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

        Permission::create([
                            'name'=>'Academico',
                            'descripcion'=>'Ingreso al menú Acádemico'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);
        Permission::create([
                            'name'=>'ac_cursos',
                            'descripcion'=>'ver cursos'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);
        Permission::create([
                            'name'=>'ac_cursoCrear',
                            'descripcion'=>'crear cursos'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);
        Permission::create([
                            'name'=>'ac_cursoEditar',
                            'descripcion'=>'editar cursos'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);
        Permission::create([
                            'name'=>'ac_cursoInactivar',
                            'descripcion'=>'inactivar cursos'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);

        Permission::create([
                            'name'=>'ac_horarios',
                            'descripcion'=>'ver horarios'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);
        Permission::create([
                            'name'=>'ac_horarioCrear',
                            'descripcion'=>'crear horarios'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);
        Permission::create([
                            'name'=>'ac_horarioEditar',
                            'descripcion'=>'editar horarios'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);
        Permission::create([
                            'name'=>'ac_horarioInactivar',
                            'descripcion'=>'inactivar horarios'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);

        Permission::create([
                            'name'=>'ac_modulos',
                            'descripcion'=>'ver modulos'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);
        Permission::create([
                            'name'=>'ac_moduloCrear',
                            'descripcion'=>'crear modulos'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);
        Permission::create([
                            'name'=>'ac_moduloEditar',
                            'descripcion'=>'editar modulos'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);
        Permission::create([
                            'name'=>'ac_moduloInactivar',
                            'descripcion'=>'inactivar modulos'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);


        Permission::create([
                            'name'=>'Cartera',
                            'descripcion'=>'ingreso al menú cartera'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador]);



        Permission::create([
                            'name'=>'Financiera',
                            'descripcion'=>'ingreso al menú financiera'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
        Permission::create([
                            'name'=>'fi_conceptopagos',
                            'descripcion'=>'ver conceptos de pago'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
        Permission::create([
                            'name'=>'fi_conceptopagoCrear',
                            'descripcion'=>'crear concepto de pago'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
        Permission::create([
                            'name'=>'fi_conceptopagoEditar',
                            'descripcion'=>'editar concepto de pago'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
        Permission::create([
                            'name'=>'fi_conceptopagoInactivar',
                            'descripcion'=>'inactivar concepto de pago'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);


        Permission::create([
                            'name'=>'Inventario',
                            'descripcion'=>'ingreso al menú inventario'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,]);
        Permission::create([
                            'name'=>'in_productos',
                            'descripcion'=>'ver productos'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,]);
        Permission::create([
                            'name'=>'in_productoCrear',
                            'descripcion'=>'crear productos'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,]);
        Permission::create([
                            'name'=>'in_productoEditar',
                            'descripcion'=>'editar productos'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,]);
        Permission::create([
                            'name'=>'in_productoInactivar',
                            'descripcion'=>'inactivar producto'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,]);

        Permission::create([
                            'name'=>'in_almacens',
                            'descripcion'=>'ver almacenes'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,]);
        Permission::create([
                            'name'=>'in_almacenCrear',
                            'descripcion'=>'crear almacenes'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,]);
        Permission::create([
                            'name'=>'in_almacenEditar',
                            'descripcion'=>'editar almacenes'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,]);
        Permission::create([
                            'name'=>'in_almacenInactivar',
                            'descripcion'=>'inactivar almacenes'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,]);

        Permission::create([
                            'name'=>'in_inventarios',
                            'descripcion'=>'ver inventarios'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,]);
        Permission::create([
                            'name'=>'in_inventarioCrear',
                            'descripcion'=>'crear inventarios'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,]);
        Permission::create([
                            'name'=>'in_inventarioAnular',
                            'descripcion'=>'anular inventarios'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,]);
        Permission::create([
                            'name'=>'in_inventarioConsultar',
                            'descripcion'=>'consultar inventarios'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,]);


        Permission::create([
                            'name'=>'Reportes',
                            'descripcion'=>'ingreso al menú reportes'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);



        Permission::create([
                            'name'=>'Administracion',
                            'descripcion'=>'ingreso al menú administración'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
        Permission::create([
                            'name'=>'ad_saluds',
                            'descripcion'=>'ver regímenes de salud'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
        Permission::create([
                            'name'=>'ad_saludCrear',
                            'descripcion'=>'crear regímenes de salud'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
        Permission::create([
                            'name'=>'ad_saludEditar',
                            'descripcion'=>'editar regímenes de salud'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
        Permission::create([
                            'name'=>'ad_saludInactivar',
                            'descripcion'=>'inactivar regímenes de salud'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);

        Permission::create([
                            'name'=>'ad_multis',
                            'descripcion'=>'ver personas multiculturales'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
        Permission::create([
                            'name'=>'ad_multiCrear',
                            'descripcion'=>'crear personas multiculturales'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
        Permission::create([
                            'name'=>'ad_multiEditar',
                            'descripcion'=>'editar personas multiculturales'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
        Permission::create([
                            'name'=>'ad_multiInactivar',
                            'descripcion'=>'inactivar personas multiculturales'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);


        Permission::create([
                            'name'=>'Archivo',
                            'descripcion'=>'ingreso al menú archivo'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);


        Permission::create([
                            'name'=>'Configuracion',
                            'descripcion'=>'ingreso al menú configuración'
                            ])->syncRoles([$Superusuario]);
        Permission::create([
                            'name'=>'co_rols',
                            'descripcion'=>'ver roles'
                            ])->syncRoles([$Superusuario]);
        Permission::create([
                            'name'=>'co_rolCrear',
                            'descripcion'=>'crear roles'
                            ])->syncRoles([$Superusuario]);
        Permission::create([
                            'name'=>'co_rolEditar',
                            'descripcion'=>'editar roles'
                            ])->syncRoles([$Superusuario]);
        Permission::create([
                            'name'=>'co_rolInactivar',
                            'descripcion'=>'inactivar roles'
                            ])->syncRoles([$Superusuario]);

        Permission::create([
                            'name'=>'co_countrys',
                            'descripcion'=>'ver países, departamentos, ciudades'
                            ])->syncRoles([$Superusuario]);
        Permission::create([
                            'name'=>'co_countryCrear',
                            'descripcion'=>'crear países, departamentos, ciudades'
                            ])->syncRoles([$Superusuario]);
        Permission::create([
                            'name'=>'co_countryEditar',
                            'descripcion'=>'editar países, departamentos, ciudades'
                            ])->syncRoles([$Superusuario]);
        Permission::create([
                            'name'=>'co_countryInactivar',
                            'descripcion'=>'inactivar países, departamentos, ciudades'
                            ])->syncRoles([$Superusuario]);

        Permission::create([
                            'name'=>'co_sedes',
                            'descripcion'=>'ver sedes'
                            ])->syncRoles([$Superusuario]);
        Permission::create([
                            'name'=>'co_sedeCrear',
                            'descripcion'=>'crear sede'
                            ])->syncRoles([$Superusuario]);
        Permission::create([
                            'name'=>'co_sedeEditar',
                            'descripcion'=>'editar sede'
                            ])->syncRoles([$Superusuario]);
        Permission::create([
                            'name'=>'co_sedeInactivar',
                            'descripcion'=>'inactivar sede'
                            ])->syncRoles([$Superusuario]);

        Permission::create([
                            'name'=>'co_areas',
                            'descripcion'=>'ver áreas'
                            ])->syncRoles([$Superusuario]);
        Permission::create([
                            'name'=>'co_areaCrear',
                            'descripcion'=>'crear área'
                            ])->syncRoles([$Superusuario]);
        Permission::create([
                            'name'=>'co_areaEditar',
                            'descripcion'=>'editar área'
                            ])->syncRoles([$Superusuario]);
        Permission::create([
                            'name'=>'co_areaInactivar',
                            'descripcion'=>'inactivar área'
                            ])->syncRoles([$Superusuario]);


        Permission::create([
                            'name'=>'co_users',
                            'descripcion'=>'ver usuarios'
                            ])->syncRoles([$Superusuario]);
        Permission::create([
                            'name'=>'co_userCrear',
                            'descripcion'=>'crear Usuario'
                            ])->syncRoles([$Superusuario]);
        Permission::create([
                            'name'=>'co_userEditar',
                            'descripcion'=>'editar usuario'
                            ])->syncRoles([$Superusuario]);
        Permission::create([
                            'name'=>'co_userInactivar',
                            'descripcion'=>'inactivar usuario'
                            ])->syncRoles([$Superusuario]);

    }
}