<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Submenu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $m1=Menu::create([
                'name'              => 'ACÁDEMICO',
                'identificaRuta'    => 'academico.*',
                'permiso'           => 'Academico',
                'icono'             => 'fa-solid fa-graduation-cap  text-gray-500'
            ]);

            Submenu::create([
                'permiso'           => 'ac_gestion',
                'ruta'              => 'academico.gestion',
                'identificaRuta'    => 'academico.gestion',
                'name'              => 'Gestión',
                'icono'             => 'fa-solid fa-book text-gray-500',
                'menu_id'           => $m1->id

            ]);

            Submenu::create([
                'permiso'           => 'ac_estudiantes',
                'ruta'              => 'academico.estudiantes',
                'identificaRuta'    => 'academico.estudiantes',
                'name'              => 'Estudiantes',
                'icono'             => 'fa-solid fa-book text-gray-500',
                'menu_id'           => $m1->id

            ]);

            Submenu::create([
                'permiso'           => 'ac_matriculas',
                'ruta'              => 'academico.matriculas',
                'identificaRuta'    => 'academico.matriculas',
                'name'              => 'Matriculas',
                'icono'             => 'fa-solid fa-book text-gray-500',
                'menu_id'           => $m1->id
            ]);

            Submenu::create([
                'permiso'           => 'ac_cursos',
                'ruta'              => 'academico.cursos',
                'identificaRuta'    => 'academico.curs*',
                'name'              => 'Cursos',
                'icono'             => 'fa-solid fa-book text-gray-500',
                'menu_id'           => $m1->id
            ]);

            Submenu::create([
                'permiso'           => 'ac_modulos',
                'ruta'              => 'academico.modulos',
                'identificaRuta'    => 'academico.modulos',
                'name'              => 'Módulos',
                'icono'             => 'fa-solid fa-book text-gray-500',
                'menu_id'           => $m1->id
            ]);

            Submenu::create([
                'permiso'           => 'ac_grupos',
                'ruta'              => 'academico.grupos',
                'identificaRuta'    => 'academico.grupos',
                'name'              => 'Grupos',
                'icono'             => 'fa-solid fa-book text-gray-500',
                'menu_id'           => $m1->id
            ]);

            Submenu::create([
                'permiso'           => 'ac_grupos',
                'ruta'              => 'academico.ciclos',
                'identificaRuta'    => 'academico.ciclos',
                'name'              => 'Programación',
                'icono'             => 'fa-solid fa-book text-gray-500',
                'menu_id'           => $m1->id
            ]);

            Submenu::create([
                'permiso'           => 'ac_notas',
                'ruta'              => 'academico.notas',
                'identificaRuta'    => 'academico.notas',
                'name'              => 'Notas - Asistencias',
                'icono'             => 'fa-solid fa-book text-gray-500',
                'menu_id'           => $m1->id
            ]);

        $m2=Menu::create([
                    'name'              => 'CARTERA',
                    'identificaRuta'    => 'cartera.*',
                    'permiso'           => 'ca_carteras',
                    'icono'             => 'fa-solid fa-cash-register text-gray-500'
                ]);

                Submenu::create([
                    'permiso'           => 'ac_grupos',
                    'ruta'              => 'cartera.carteras',
                    'identificaRuta'    => 'cartera.carteras',
                    'name'              => 'Cartera',
                    'icono'             => 'fa-solid fa-credit-card text-gray-500',
                    'menu_id'           => $m2->id
                ]);

        $m3=Menu::create([
                    'name'              => 'FINANCIERA',
                    'identificaRuta'    => 'financiera.*',
                    'permiso'           => 'Financiera',
                    'icono'             => 'fa-solid fa-chart-line text-gray-500'
                ]);

                Submenu::create([
                    'permiso'           => 'fi_recibopagos',
                    'ruta'              => 'financiera.recibopagos',
                    'identificaRuta'    => 'financiera.recibopagos',
                    'name'              => 'Recibos Pago',
                    'icono'             => 'fa-solid fa-ranking-star text-gray-500',
                    'menu_id'           => $m3->id
                ]);

                Submenu::create([
                    'permiso'           => 'fi_cierrecaja',
                    'ruta'              => 'financiera.cierrecaja',
                    'identificaRuta'    => 'financiera.cierrecaja',
                    'name'              => 'Cierre Caja',
                    'icono'             => 'fa-solid fa-ranking-star text-gray-500',
                    'menu_id'           => $m3->id
                ]);

                Submenu::create([
                    'permiso'           => 'fi_cierrecajaCajero',
                    'ruta'              => 'financiera.cajero',
                    'identificaRuta'    => 'financiera.cajero',
                    'name'              => 'Cierre Caja',
                    'icono'             => 'fa-solid fa-ranking-star text-gray-500',
                    'menu_id'           => $m3->id
                ]);

                Submenu::create([
                    'permiso'           => 'fi_conceptopagos',
                    'ruta'              => 'financiera.conceptopagos',
                    'identificaRuta'    => 'financiera.conceptopagos',
                    'name'              => 'Concepto Pago',
                    'icono'             => 'fa-solid fa-ranking-star text-gray-500',
                    'menu_id'           => $m3->id
                ]);

                Submenu::create([
                    'permiso'           => 'fi_configuracionpagos',
                    'ruta'              => 'financiera.configpagos',
                    'identificaRuta'    => 'financiera.configpagos',
                    'name'              => 'Configuración Pago',
                    'icono'             => 'fa-solid fa-ranking-star text-gray-500',
                    'menu_id'           => $m3->id
                ]);

        $m4=Menu::create([
                    'name'              => 'INVENTARIO',
                    'identificaRuta'    => 'inventario.*',
                    'permiso'           => 'Inventario',
                    'icono'             => 'fa-solid fa-cart-flatbed text-gray-500'
                ]);

                Submenu::create([
                    'permiso'           => 'in_inventarios',
                    'ruta'              => 'inventario.inventarios',
                    'identificaRuta'    => 'inventario.inventarios',
                    'name'              => 'Movimiento Inventario',
                    'icono'             => 'fa-solid fa-warehouse text-gray-500',
                    'menu_id'           => $m4->id
                ]);

                Submenu::create([
                    'permiso'           => 'in_productos',
                    'ruta'              => 'inventario.productos',
                    'identificaRuta'    => 'inventario.productos',
                    'name'              => 'Productos',
                    'icono'             => 'fa-solid fa-warehouse text-gray-500',
                    'menu_id'           => $m4->id
                ]);

                Submenu::create([
                    'permiso'           => 'in_almacens',
                    'ruta'              => 'inventario.almacens',
                    'identificaRuta'    => 'inventario.almacens',
                    'name'              => 'Almacenes',
                    'icono'             => 'fa-solid fa-warehouse text-gray-500',
                    'menu_id'           => $m4->id
                ]);

                Submenu::create([
                    'permiso'           => 'in_pagoconfig',
                    'ruta'              => 'inventario.pagoConfig',
                    'identificaRuta'    => 'inventario.pagoConfig',
                    'name'              => 'Configura Pago',
                    'icono'             => 'fa-solid fa-warehouse text-gray-500',
                    'menu_id'           => $m4->id
                ]);

        $m5=Menu::create([
                    'name'              => 'REPORTES',
                    'identificaRuta'    => 'admin.countries.*',
                    'permiso'           => 'Reportes',
                    'icono'             => 'fa-solid fa-headset text-gray-500'
                ]);

                Submenu::create([
                    'permiso'           => 'in_almacens',
                    'ruta'              => 'admin.countries.index',
                    'identificaRuta'    => 'admin.countries.index',
                    'name'              => 'De Matricula',
                    'icono'             => 'fa-solid fa-book text-gray-500',
                    'menu_id'           => $m5->id
                ]);

                Submenu::create([
                    'permiso'           => 'in_almacens',
                    'ruta'              => 'admin.countries.index',
                    'identificaRuta'    => 'admin.countries.index',
                    'name'              => 'De Ingresos',
                    'icono'             => 'fa-solid fa-book text-gray-500',
                    'menu_id'           => $m5->id
                ]);

                Submenu::create([
                    'permiso'           => 'in_almacens',
                    'ruta'              => 'admin.countries.index',
                    'identificaRuta'    => 'admin.countries.index',
                    'name'              => 'De Cartera',
                    'icono'             => 'fa-solid fa-book text-gray-500',
                    'menu_id'           => $m5->id
                ]);

        $m6=Menu::create([
                    'name'              => 'ADMINISTRACIÓN',
                    'identificaRuta'    => 'admin.*',
                    'permiso'           => 'Administracion',
                    'icono'             => 'fa-solid fa-toolbox text-gray-500'
                ]);

                Submenu::create([
                    'permiso'           => 'ad_profesores',
                    'ruta'              => 'admin.profesores',
                    'identificaRuta'    => 'admin.profesores',
                    'name'              => 'Profesores',
                    'icono'             => 'fa-solid fa-screwdriver text-gray-500',
                    'menu_id'           => $m6->id
                ]);

                Submenu::create([
                    'permiso'           => 'ad_saluds',
                    'ruta'              => 'admin.saluds',
                    'identificaRuta'    => 'admin.saluds',
                    'name'              => 'Regímenes de Salud',
                    'icono'             => 'fa-solid fa-screwdriver text-gray-500',
                    'menu_id'           => $m6->id
                ]);

                Submenu::create([
                    'permiso'           => 'ad_multis',
                    'ruta'              => 'admin.multis',
                    'identificaRuta'    => 'admin.multis',
                    'name'              => 'Personas Multiculturales',
                    'icono'             => 'fa-solid fa-screwdriver text-gray-500',
                    'menu_id'           => $m6->id
                ]);

                Submenu::create([
                    'permiso'           => 'ad_multis',
                    'ruta'              => 'admin.multis',
                    'identificaRuta'    => 'admin.multis',
                    'name'              => 'Tipo de Contrato',
                    'icono'             => 'fa-solid fa-screwdriver text-gray-500',
                    'menu_id'           => $m6->id
                ]);

        $m7=Menu::create([
                    'name'              => 'ARCHIVO',
                    'identificaRuta'    => 'admin.countries.*',
                    'permiso'           => 'Archivo',
                    'icono'             => 'fa-solid fa-folder-tree text-gray-500'
                ]);

                Submenu::create([
                    'permiso'           => 'Archivo',
                    'ruta'              => 'admin.countries.index',
                    'identificaRuta'    => 'admin.countries.index',
                    'name'              => 'Listado Archivo',
                    'icono'             => 'fa-solid fa-floppy-disk text-gray-500',
                    'menu_id'           => $m7->id
                ]);

        $m8=Menu::create([
                    'name'              => 'CONFIGURACIÓN',
                    'identificaRuta'    => 'configuracion.*',
                    'permiso'           => 'Configuracion',
                    'icono'             => 'fa-solid fa-screwdriver-wrench text-gray-500'
                ]);

                Submenu::create([
                    'permiso'           => 'co_estados',
                    'ruta'              => 'configuracion.estados',
                    'identificaRuta'    => 'configuracion.estados',
                    'name'              => 'Estados Usuarios',
                    'icono'             => 'fa-solid fa-wrench text-gray-500',
                    'menu_id'           => $m8->id
                ]);

                Submenu::create([
                    'permiso'           => 'co_sedes',
                    'ruta'              => 'configuracion.sedes',
                    'identificaRuta'    => 'configuracion.sed*',
                    'name'              => 'Sedes',
                    'icono'             => 'fa-solid fa-wrench text-gray-500',
                    'menu_id'           => $m8->id
                ]);

                Submenu::create([
                    'permiso'           => 'co_countrys',
                    'ruta'              => 'configuracion.ubicacionCountry',
                    'identificaRuta'    => 'configuracion.ubica*',
                    'name'              => 'Ubicación',
                    'icono'             => 'fa-solid fa-wrench text-gray-500',
                    'menu_id'           => $m8->id
                ]);

                Submenu::create([
                    'permiso'           => 'co_users',
                    'ruta'              => 'configuracion.users',
                    'identificaRuta'    => 'configuracion.users',
                    'name'              => 'Usuarios',
                    'icono'             => 'fa-solid fa-wrench text-gray-500',
                    'menu_id'           => $m8->id
                ]);

                Submenu::create([
                    'permiso'           => 'co_rols',
                    'ruta'              => 'configuracion.roles',
                    'identificaRuta'    => 'configuracion.roles',
                    'name'              => 'Roles',
                    'icono'             => 'fa-solid fa-wrench text-gray-500',
                    'menu_id'           => $m8->id
                ]);

                Submenu::create([
                    'permiso'           => 'co_documentos',
                    'ruta'              => 'configuracion.documentos',
                    'identificaRuta'    => 'configuracion.documentos',
                    'name'              => 'Documentos',
                    'icono'             => 'fa-solid fa-wrench text-gray-500',
                    'menu_id'           => $m8->id
                ]);
    }
}
