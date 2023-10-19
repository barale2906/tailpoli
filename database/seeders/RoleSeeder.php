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
                            'name'=>'ac_estudiantes',
                            'descripcion'=>'ver cursos'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);
        Permission::create([
                            'name'=>'ac_estudianteCrear',
                            'descripcion'=>'crear estudiantes'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);
        Permission::create([
                            'name'=>'ac_estudianteEditar',
                            'descripcion'=>'editar estudiantes'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);

        Permission::create([
                            'name'=>'ac_estudianteInactivar',
                            'descripcion'=>'inactivar estudiantes'
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
                            'name'=>'ac_grupos',
                            'descripcion'=>'ver grupos'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);
        Permission::create([
                            'name'=>'ac_grupoCrear',
                            'descripcion'=>'crear grupos'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);
        Permission::create([
                            'name'=>'ac_grupoEditar',
                            'descripcion'=>'editar grupos'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);
        Permission::create([
                            'name'=>'ac_grupoAsignar',
                            'descripcion'=>'asignar grupos a estudiantes'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);
        Permission::create([
                            'name'=>'ac_grupoInactivar',
                            'descripcion'=>'inactivar grupos'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);

        Permission::create([
                            'name'=>'ac_matriculas',
                            'descripcion'=>'ver matriculas'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);
        Permission::create([
                            'name'=>'ac_matriculaCrear',
                            'descripcion'=>'crear matriculas'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);
        Permission::create([
                            'name'=>'ac_matriculaAnular',
                            'descripcion'=>'anular matriculas'
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
                            'name'=>'fi_recibopagos',
                            'descripcion'=>'ver recibos de pago'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
        Permission::create([
                            'name'=>'fi_recibopagoCrear',
                            'descripcion'=>'crear recibo de pago'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
        Permission::create([
                            'name'=>'fi_recibopagoAnular',
                            'descripcion'=>'anular recibo de pago'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);


        Permission::create([
                            'name'=>'fi_cierrecaja',
                            'descripcion'=>'ver cierre de caja'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador]);
        Permission::create([
                            'name'=>'fi_cierrecajaCrear',
                            'descripcion'=>'crear cierre de caja'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador]);
        Permission::create([
                            'name'=>'fi_cierrecajaAprobar',
                            'descripcion'=>'aprobar cierre de caja'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador]);

        Permission::create([
                            'name'=>'fi_cierrecajaCajero',
                            'descripcion'=>'Generar cierre de caja por parte del cajero'
                            ])->syncRoles([$Auxiliar]);


        Permission::create([
                            'name'=>'fi_configuracionpagos',
                            'descripcion'=>'ver configuraciones de pago'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
        Permission::create([
                            'name'=>'fi_configuracionpagoCrear',
                            'descripcion'=>'crear configuracion de pago'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);

        Permission::create([
                            'name'=>'fi_configuracionpagoEditar',
                            'descripcion'=>'editar configuración de pago'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,]);
        Permission::create([
                            'name'=>'fi_configuracionpagoInactivar',
                            'descripcion'=>'inactivar configuración de pago'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,]);



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
                            'name'=>'in_pagoconfig',
                            'descripcion'=>'ver configuraciones de pago'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,]);
        Permission::create([
                            'name'=>'in_pagoconfigCrear',
                            'descripcion'=>'crear configuraciones de pago'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,]);
        Permission::create([
                            'name'=>'in_pagoconfigEditar',
                            'descripcion'=>'editar configuraciones de pago'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,]);
        Permission::create([
                            'name'=>'in_pagoconfigInactivar',
                            'descripcion'=>'inactivar configuraciones de pago'
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
                            'name'=>'ad_profesores',
                            'descripcion'=>'ver lista de profesores'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
        Permission::create([
                            'name'=>'ad_profesoreCrear',
                            'descripcion'=>'crear profesores'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
        Permission::create([
                            'name'=>'ad_profesoreEditar',
                            'descripcion'=>'editar profesores'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
        Permission::create([
                            'name'=>'ad_profesoreInactivar',
                            'descripcion'=>'inactivar profesores'
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

        Permission::create([
                            'name'=>'co_usersPerfil',
                            'descripcion'=>'perfil usuarios'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);


        Permission::create([
                            'name'=>'co_estados',
                            'descripcion'=>'ver estados de usuarios'
                            ])->syncRoles([$Superusuario]);
        Permission::create([
                            'name'=>'co_estadoCrear',
                            'descripcion'=>'crear estados de usuario'
                            ])->syncRoles([$Superusuario]);
        Permission::create([
                            'name'=>'co_estadoEditar',
                            'descripcion'=>'editar estados de usuario'
                            ])->syncRoles([$Superusuario]);
        Permission::create([
                            'name'=>'co_estadoInactivar',
                            'descripcion'=>'inactivar estados de usuario'
                            ])->syncRoles([$Superusuario]);



    }
}
