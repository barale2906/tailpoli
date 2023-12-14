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
                            'descripcion'=>'Ingreso al menú Acádemico',
                            'modulo'=>'academico'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor]);
        Permission::create([
                            'name'=>'ac_cursos',
                            'descripcion'=>'ver cursos',
                            'modulo'=>'academico'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
        Permission::create([
                            'name'=>'ac_cursoCrear',
                            'descripcion'=>'crear cursos',
                            'modulo'=>'academico'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador]);
        Permission::create([
                            'name'=>'ac_cursoEditar',
                            'descripcion'=>'editar cursos',
                            'modulo'=>'academico'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador]);
        Permission::create([
                            'name'=>'ac_cursoInactivar',
                            'descripcion'=>'inactivar cursos',
                            'modulo'=>'academico'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador]);

        Permission::create([
                            'name'=>'ac_estudiantes',
                            'descripcion'=>'ver listado de estudiantes',
                            'modulo'=>'academico'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
        Permission::create([
                            'name'=>'ac_estudianteCrear',
                            'descripcion'=>'crear estudiantes',
                            'modulo'=>'academico'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
        Permission::create([
                            'name'=>'ac_estudianteEditar',
                            'descripcion'=>'editar estudiantes',
                            'modulo'=>'academico'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);

        Permission::create([
                            'name'=>'ac_estudianteInactivar',
                            'descripcion'=>'inactivar estudiantes',
                            'modulo'=>'academico'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);


        Permission::create([
                            'name'=>'ac_horarios',
                            'descripcion'=>'ver horarios',
                            'modulo'=>'academico'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);
        Permission::create([
                            'name'=>'ac_horarioCrear',
                            'descripcion'=>'crear horarios',
                            'modulo'=>'academico'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);
        Permission::create([
                            'name'=>'ac_horarioEditar',
                            'descripcion'=>'editar horarios',
                            'modulo'=>'academico'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);
        Permission::create([
                            'name'=>'ac_horarioInactivar',
                            'descripcion'=>'inactivar horarios',
                            'modulo'=>'academico'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);

        Permission::create([
                            'name'=>'ac_modulos',
                            'descripcion'=>'ver modulos',
                            'modulo'=>'academico'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);
        Permission::create([
                            'name'=>'ac_moduloCrear',
                            'descripcion'=>'crear modulos',
                            'modulo'=>'academico'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);
        Permission::create([
                            'name'=>'ac_moduloEditar',
                            'descripcion'=>'editar modulos',
                            'modulo'=>'academico'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);
        Permission::create([
                            'name'=>'ac_moduloInactivar',
                            'descripcion'=>'inactivar modulos',
                            'modulo'=>'academico'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);

        Permission::create([
                            'name'=>'ac_grupos',
                            'descripcion'=>'ver grupos',
                            'modulo'=>'academico'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);
        Permission::create([
                            'name'=>'ac_grupoCrear',
                            'descripcion'=>'crear grupos',
                            'modulo'=>'academico'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);
        Permission::create([
                            'name'=>'ac_grupoEditar',
                            'descripcion'=>'editar grupos',
                            'modulo'=>'academico'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);
        Permission::create([
                            'name'=>'ac_grupoAsignar',
                            'descripcion'=>'asignar grupos a estudiantes',
                            'modulo'=>'academico'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);
        Permission::create([
                            'name'=>'ac_grupoInactivar',
                            'descripcion'=>'inactivar grupos',
                            'modulo'=>'academico'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);

        Permission::create([
                            'name'=>'ac_ciclos',
                            'descripcion'=>'ver ciclos',
                            'modulo'=>'academico'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador]);
        Permission::create([
                            'name'=>'ac_cicloCrear',
                            'descripcion'=>'crear ciclos',
                            'modulo'=>'academico'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador]);
        Permission::create([
                            'name'=>'ac_cicloEditar',
                            'descripcion'=>'editar ciclos',
                            'modulo'=>'academico'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador]);
        Permission::create([
                            'name'=>'ac_cicloAsignar',
                            'descripcion'=>'asignar ciclos a estudiantes',
                            'modulo'=>'academico'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador]);
        Permission::create([
                            'name'=>'ac_cicloInactivar',
                            'descripcion'=>'inactivar ciclos',
                            'modulo'=>'academico'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador]);

        Permission::create([
                            'name'=>'ac_gestion',
                            'descripcion'=>'ver gestion',
                            'modulo'=>'academico'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
        Permission::create([
                            'name'=>'ac_gestionCrear',
                            'descripcion'=>'crear gestion',
                            'modulo'=>'academico'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);


        Permission::create([
                            'name'=>'ac_matriculas',
                            'descripcion'=>'ver matriculas',
                            'modulo'=>'academico'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);
        Permission::create([
                            'name'=>'ac_matriculaCrear',
                            'descripcion'=>'crear matriculas',
                            'modulo'=>'academico'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);
        Permission::create([
                            'name'=>'ac_matriculaAnular',
                            'descripcion'=>'anular matriculas',
                            'modulo'=>'academico'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);


        Permission::create([
                            'name'=>'ac_notas',
                            'descripcion'=>'ver notas',
                            'modulo'=>'academico'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);
        Permission::create([
                            'name'=>'ac_notaCrear',
                            'descripcion'=>'crear notas',
                            'modulo'=>'academico'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);
        Permission::create([
                            'name'=>'ac_notaEditar',
                            'descripcion'=>'editar notas',
                            'modulo'=>'academico'
                            ])->syncRoles([$Superusuario,$Administrador,$Profesor]);

        Permission::create([
                            'name'=>'ac_asistenciaCrear',
                            'descripcion'=>'crear asistencias',
                            'modulo'=>'academico'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor]);
        Permission::create([
                            'name'=>'ac_asistenciaEditar',
                            'descripcion'=>'editar asistencias',
                            'modulo'=>'academico'
                            ])->syncRoles([$Superusuario,$Administrador,$Profesor]);

        Permission::create([
                            'name'=>'ac_export',
                            'descripcion'=>'exportar listados en excel',
                            'modulo'=>'academico'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador]);

        Permission::create([
                            'name'=>'ac_export_profe',
                            'descripcion'=>'exportar listados en excel Profesor',
                            'modulo'=>'academico'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador, $Profesor]);



        Permission::create([
                            'name'=>'ca_carteras',
                            'descripcion'=>'visualizar cartera',
                            'modulo'=>'cartera'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador]);


        Permission::create([
                            'name'=>'ca_convenio',
                            'descripcion'=>'convenios de pago',
                            'modulo'=>'cartera'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador]);

        Permission::create([
                            'name'=>'ca_export',
                            'descripcion'=>'exportar listados en excel',
                            'modulo'=>'cartera'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador]);




        Permission::create([
                            'name'=>'Financiera',
                            'descripcion'=>'ingreso al menú financiera',
                            'modulo'=>'financiera'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
        Permission::create([
                            'name'=>'fi_conceptopagos',
                            'descripcion'=>'ver conceptos de pago',
                            'modulo'=>'financiera'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
        Permission::create([
                            'name'=>'fi_conceptopagoCrear',
                            'descripcion'=>'crear concepto de pago',
                            'modulo'=>'financiera'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
        Permission::create([
                            'name'=>'fi_conceptopagoEditar',
                            'descripcion'=>'editar concepto de pago',
                            'modulo'=>'financiera'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
        Permission::create([
                            'name'=>'fi_conceptopagoInactivar',
                            'descripcion'=>'inactivar concepto de pago',
                            'modulo'=>'financiera'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);

        Permission::create([
                            'name'=>'fi_recibopagos',
                            'descripcion'=>'ver recibos de pago',
                            'modulo'=>'financiera'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
        Permission::create([
                            'name'=>'fi_recibopagoCrear',
                            'descripcion'=>'crear recibo de pago',
                            'modulo'=>'financiera'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
        Permission::create([
                            'name'=>'fi_recibopagoAnular',
                            'descripcion'=>'anular recibo de pago',
                            'modulo'=>'financiera'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);


        Permission::create([
                            'name'=>'fi_cierrecaja',
                            'descripcion'=>'ver cierre de caja',
                            'modulo'=>'financiera'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador]);
        Permission::create([
                            'name'=>'fi_cierrecajaCrear',
                            'descripcion'=>'crear cierre de caja',
                            'modulo'=>'financiera'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
        Permission::create([
                            'name'=>'fi_cierrecajaAprobar',
                            'descripcion'=>'aprobar cierre de caja',
                            'modulo'=>'financiera'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador]);

        Permission::create([
                            'name'=>'fi_cierrecajaCajero',
                            'descripcion'=>'Generar cierre de caja por parte del cajero',
                            'modulo'=>'financiera'
                            ])->syncRoles([$Auxiliar]);


        Permission::create([
                            'name'=>'fi_configuracionpagos',
                            'descripcion'=>'ver configuraciones de pago',
                            'modulo'=>'financiera'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
        Permission::create([
                            'name'=>'fi_configuracionpagoCrear',
                            'descripcion'=>'crear configuracion de pago',
                            'modulo'=>'financiera'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);

        Permission::create([
                            'name'=>'fi_configuracionpagoEditar',
                            'descripcion'=>'editar configuración de pago',
                            'modulo'=>'financiera'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,]);
        Permission::create([
                            'name'=>'fi_configuracionpagoInactivar',
                            'descripcion'=>'inactivar configuración de pago',
                            'modulo'=>'financiera'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,]);

        Permission::create([
                            'name'=>'fi_transacciones',
                            'descripcion'=>'ver solicitudes de transacción',
                            'modulo'=>'financiera'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
        Permission::create([
                            'name'=>'fi_transaccionesCrear',
                            'descripcion'=>'crear solicitudes de transacción',
                            'modulo'=>'financiera'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);

        Permission::create([
                            'name'=>'fi_transaccionesEditar',
                            'descripcion'=>'editar solicitudes de transacción',
                            'modulo'=>'financiera'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,]);

        Permission::create([
                            'name'=>'fi_export',
                            'descripcion'=>'exportar listados en excel',
                            'modulo'=>'financiera'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador]);
        Permission::create([
                            'name'=>'fi_activarecibos',
                            'descripcion'=>'Desbloquea creación de recibos de caja - cierres de caja',
                            'modulo'=>'financiera'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador]);





        Permission::create([
                            'name'=>'Inventario',
                            'descripcion'=>'ingreso al menú inventario',
                            'modulo'=>'inventario'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,]);
        Permission::create([
                            'name'=>'in_productos',
                            'descripcion'=>'ver productos',
                            'modulo'=>'inventario'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,]);
        Permission::create([
                            'name'=>'in_productoCrear',
                            'descripcion'=>'crear productos',
                            'modulo'=>'inventario'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,]);
        Permission::create([
                            'name'=>'in_productoEditar',
                            'descripcion'=>'editar productos',
                            'modulo'=>'inventario'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,]);
        Permission::create([
                            'name'=>'in_productoInactivar',
                            'descripcion'=>'inactivar producto',
                            'modulo'=>'inventario'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,]);

        Permission::create([
                            'name'=>'in_almacens',
                            'descripcion'=>'ver almacenes',
                            'modulo'=>'inventario'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,]);
        Permission::create([
                            'name'=>'in_almacenCrear',
                            'descripcion'=>'crear almacenes',
                            'modulo'=>'inventario'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,]);
        Permission::create([
                            'name'=>'in_almacenEditar',
                            'descripcion'=>'editar almacenes',
                            'modulo'=>'inventario'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,]);
        Permission::create([
                            'name'=>'in_almacenInactivar',
                            'descripcion'=>'inactivar almacenes',
                            'modulo'=>'inventario'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,]);

        Permission::create([
                            'name'=>'in_inventarios',
                            'descripcion'=>'ver inventarios',
                            'modulo'=>'inventario'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,]);
        Permission::create([
                            'name'=>'in_inventarioCrear',
                            'descripcion'=>'crear inventarios',
                            'modulo'=>'inventario'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
        Permission::create([
                            'name'=>'in_inventarioAnular',
                            'descripcion'=>'anular inventarios',
                            'modulo'=>'inventario'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,]);
        Permission::create([
                            'name'=>'in_inventarioConsultar',
                            'descripcion'=>'consultar inventarios',
                            'modulo'=>'inventario'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,]);


        Permission::create([
                            'name'=>'in_recibopago',
                            'descripcion'=>'ver recibos de pago inventarios',
                            'modulo'=>'inventario'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,]);
        Permission::create([
                            'name'=>'in_pagoconfig',
                            'descripcion'=>'ver configuraciones de pago',
                            'modulo'=>'inventario'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,]);
        Permission::create([
                            'name'=>'in_pagoconfigCrear',
                            'descripcion'=>'crear configuraciones de pago',
                            'modulo'=>'inventario'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,]);
        Permission::create([
                            'name'=>'in_pagoconfigEditar',
                            'descripcion'=>'editar configuraciones de pago',
                            'modulo'=>'inventario'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,]);
        Permission::create([
                            'name'=>'in_pagoconfigInactivar',
                            'descripcion'=>'inactivar configuraciones de pago',
                            'modulo'=>'inventario'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,]);



        Permission::create([
                            'name'=>'re_export',
                            'descripcion'=>'exportar listados en excel',
                            'modulo'=>'inventario'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador]);
        Permission::create([
                            'name'=>'Reportes',
                            'descripcion'=>'ingreso al menú reportes',
                            'modulo'=>'inventario'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);

        Permission::create([
                            'name'=>'in_export',
                            'descripcion'=>'exportar listados en excel',
                            'modulo'=>'inventario'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador]);





        Permission::create([
                            'name'=>'Administracion',
                            'descripcion'=>'ingreso al menú administración',
                            'modulo'=>'Administracion'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
        Permission::create([
                            'name'=>'ad_saluds',
                            'descripcion'=>'ver regímenes de salud',
                            'modulo'=>'Administracion'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
        Permission::create([
                            'name'=>'ad_saludCrear',
                            'descripcion'=>'crear regímenes de salud',
                            'modulo'=>'Administracion'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
        Permission::create([
                            'name'=>'ad_saludEditar',
                            'descripcion'=>'editar regímenes de salud',
                            'modulo'=>'Administracion'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
        Permission::create([
                            'name'=>'ad_saludInactivar',
                            'descripcion'=>'inactivar regímenes de salud',
                            'modulo'=>'Administracion'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);


        Permission::create([
                            'name'=>'ad_profesores',
                            'descripcion'=>'ver lista de profesores',
                            'modulo'=>'Administracion'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
        Permission::create([
                            'name'=>'ad_profesoreCrear',
                            'descripcion'=>'crear profesores',
                            'modulo'=>'Administracion'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
        Permission::create([
                            'name'=>'ad_profesoreEditar',
                            'descripcion'=>'editar profesores',
                            'modulo'=>'Administracion'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
        Permission::create([
                            'name'=>'ad_profesoreInactivar',
                            'descripcion'=>'inactivar profesores',
                            'modulo'=>'Administracion'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);


        Permission::create([
                            'name'=>'ad_multis',
                            'descripcion'=>'ver personas multiculturales',
                            'modulo'=>'Administracion'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
        Permission::create([
                            'name'=>'ad_multiCrear',
                            'descripcion'=>'crear personas multiculturales',
                            'modulo'=>'Administracion'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
        Permission::create([
                            'name'=>'ad_multiEditar',
                            'descripcion'=>'editar personas multiculturales',
                            'modulo'=>'Administracion'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);
        Permission::create([
                            'name'=>'ad_multiInactivar',
                            'descripcion'=>'inactivar personas multiculturales',
                            'modulo'=>'Administracion'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);

        Permission::create([
                            'name'=>'ad_export',
                            'descripcion'=>'exportar listados en excel',
                            'modulo'=>'Administracion'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador]);




        Permission::create([
                            'name'=>'Archivo',
                            'descripcion'=>'ingreso al menú archivo',
                            'modulo'=>'archivo'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar]);

        Permission::create([
                            'name'=>'ar_export',
                            'descripcion'=>'exportar listados en excel',
                            'modulo'=>'archivo'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador]);




        Permission::create([
                            'name'=>'Configuracion',
                            'descripcion'=>'ingreso al menú configuración',
                            'modulo'=>'configuracion'
                            ])->syncRoles([$Superusuario]);
        Permission::create([
                            'name'=>'co_rols',
                            'descripcion'=>'ver roles',
                            'modulo'=>'configuracion'
                            ])->syncRoles([$Superusuario]);
        Permission::create([
                            'name'=>'co_rolCrear',
                            'descripcion'=>'crear roles',
                            'modulo'=>'configuracion'
                            ])->syncRoles([$Superusuario]);
        Permission::create([
                            'name'=>'co_rolEditar',
                            'descripcion'=>'editar roles',
                            'modulo'=>'configuracion'
                            ])->syncRoles([$Superusuario]);
        Permission::create([
                            'name'=>'co_rolInactivar',
                            'descripcion'=>'inactivar roles',
                            'modulo'=>'configuracion'
                            ])->syncRoles([$Superusuario]);

        Permission::create([
                            'name'=>'co_countrys',
                            'descripcion'=>'ver países, departamentos, ciudades',
                            'modulo'=>'configuracion'
                            ])->syncRoles([$Superusuario]);
        Permission::create([
                            'name'=>'co_countryCrear',
                            'descripcion'=>'crear países, departamentos, ciudades',
                            'modulo'=>'configuracion'
                            ])->syncRoles([$Superusuario]);
        Permission::create([
                            'name'=>'co_countryEditar',
                            'descripcion'=>'editar países, departamentos, ciudades',
                            'modulo'=>'configuracion'
                            ])->syncRoles([$Superusuario]);
        Permission::create([
                            'name'=>'co_countryInactivar',
                            'descripcion'=>'inactivar países, departamentos, ciudades',
                            'modulo'=>'configuracion'
                            ])->syncRoles([$Superusuario]);

        Permission::create([
                            'name'=>'co_sedes',
                            'descripcion'=>'ver sedes',
                            'modulo'=>'configuracion'
                            ])->syncRoles([$Superusuario]);
        Permission::create([
                            'name'=>'co_sedeCrear',
                            'descripcion'=>'crear sede',
                            'modulo'=>'configuracion'
                            ])->syncRoles([$Superusuario]);
        Permission::create([
                            'name'=>'co_sedeEditar',
                            'descripcion'=>'editar sede',
                            'modulo'=>'configuracion'
                            ])->syncRoles([$Superusuario]);
        Permission::create([
                            'name'=>'co_sedeInactivar',
                            'descripcion'=>'inactivar sede',
                            'modulo'=>'configuracion'
                            ])->syncRoles([$Superusuario]);

        Permission::create([
                            'name'=>'co_areas',
                            'descripcion'=>'ver áreas',
                            'modulo'=>'configuracion'
                            ])->syncRoles([$Superusuario]);
        Permission::create([
                            'name'=>'co_areaCrear',
                            'descripcion'=>'crear área',
                            'modulo'=>'configuracion'
                            ])->syncRoles([$Superusuario]);
        Permission::create([
                            'name'=>'co_areaEditar',
                            'descripcion'=>'editar área',
                            'modulo'=>'configuracion'
                            ])->syncRoles([$Superusuario]);
        Permission::create([
                            'name'=>'co_areaInactivar',
                            'descripcion'=>'inactivar área',
                            'modulo'=>'configuracion'
                            ])->syncRoles([$Superusuario]);


        Permission::create([
                            'name'=>'co_users',
                            'descripcion'=>'ver usuarios',
                            'modulo'=>'configuracion'
                            ])->syncRoles([$Superusuario]);
        Permission::create([
                            'name'=>'co_userCrear',
                            'descripcion'=>'crear Usuario',
                            'modulo'=>'configuracion'
                            ])->syncRoles([$Superusuario]);
        Permission::create([
                            'name'=>'co_userEditar',
                            'descripcion'=>'editar usuario',
                            'modulo'=>'configuracion'
                            ])->syncRoles([$Superusuario]);
        Permission::create([
                            'name'=>'co_userInactivar',
                            'descripcion'=>'inactivar usuario',
                            'modulo'=>'configuracion'
                            ])->syncRoles([$Superusuario]);

        Permission::create([
                            'name'=>'co_usersPerfil',
                            'descripcion'=>'perfil usuarios',
                            'modulo'=>'configuracion'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador,$Auxiliar,$Profesor,$Estudiante]);


        Permission::create([
                            'name'=>'co_estados',
                            'descripcion'=>'ver estados de usuarios',
                            'modulo'=>'configuracion'
                            ])->syncRoles([$Superusuario]);
        Permission::create([
                            'name'=>'co_estadoCrear',
                            'descripcion'=>'crear estados de usuario',
                            'modulo'=>'configuracion'
                            ])->syncRoles([$Superusuario]);
        Permission::create([
                            'name'=>'co_estadoEditar',
                            'descripcion'=>'editar estados de usuario',
                            'modulo'=>'configuracion'
                            ])->syncRoles([$Superusuario]);
        Permission::create([
                            'name'=>'co_estadoInactivar',
                            'descripcion'=>'inactivar estados de usuario',
                            'modulo'=>'configuracion'
                            ])->syncRoles([$Superusuario]);


        Permission::create([
                            'name'=>'co_documentos',
                            'descripcion'=>'Ver los tipos de documentos que se generan',
                            'modulo'=>'configuracion'
                            ])->syncRoles([$Superusuario]);

        Permission::create([
                            'name'=>'co_documentosCrear',
                            'descripcion'=>'crear documentos según tipo',
                            'modulo'=>'configuracion'
                            ])->syncRoles([$Superusuario]);

        Permission::create([
                            'name'=>'co_export',
                            'descripcion'=>'exportar listados en excel',
                            'modulo'=>'configuracion'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador]);

        Permission::create([
                            'name'=>'co_impornotas',
                            'descripcion'=>'importar notas',
                            'modulo'=>'configuracion'
                            ])->syncRoles([$Superusuario,$Administrador,$Coordinador]);

    }
}
