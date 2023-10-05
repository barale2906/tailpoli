<aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-blue-200 border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
:class="{
    '-translate-x-full': !open,
    'transform-none': open,
}"
aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-blue-200 dark:bg-gray-800">
        <ul class="space-y-2 font-medium">
            <li>
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger" >
                        @can('Academico')
                            <button type="button" class="iflex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('academico.*') ? 'bg-gray-100' : ''}} ">
                                <i class="fa-solid fa-graduation-cap  text-gray-500"></i>
                                <span class="ml-3">ACÁDEMICO</span>
                            </button>
                        @endcan
                    </x-slot>
                    <x-slot name="content">
                        <a href="{{route('academico.cursos')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('academico.cursos') ? 'bg-gray-100' : ''}}">
                            <i class="fa-solid fa-book text-gray-500"></i>
                            <span class="ml-3">Estudiantes</span>
                        </a>
                        @can('ac_matriculas')
                            <a href="{{route('academico.matriculas')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('academico.matriculas') ? 'bg-gray-100' : ''}}">
                                <i class="fa-solid fa-book text-gray-500"></i>
                                <span class="ml-3">Matriculas</span>
                            </a>
                        @endcan
                        @can('ac_cursos')
                            <a href="{{route('academico.cursos')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('academico.curs*') ? 'bg-gray-100' : ''}}">
                                <i class="fa-solid fa-book text-gray-500"></i>
                                <span class="ml-3">Cursos</span>
                            </a>
                        @endcan

                        @can('ac_modulos')
                            <a href="{{route('academico.modulos')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('academico.modulos') ? 'bg-gray-100' : ''}}">
                                <i class="fa-solid fa-book text-gray-500"></i>
                                <span class="ml-3">Módulos</span>
                            </a>
                        @endcan

                        @can('ac_grupos')
                            <a href="{{route('academico.grupos')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('academico.grupos') ? 'bg-gray-100' : ''}}">
                                <i class="fa-solid fa-book text-gray-500"></i>
                                <span class="ml-3">Grupos</span>
                            </a>
                        @endcan

                        <a href="{{route('academico.cursos')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('academico.cursos') ? 'bg-gray-100' : ''}}">
                            <i class="fa-solid fa-book text-gray-500"></i>
                            <span class="ml-3">Notas</span>
                        </a>
                        <a href="{{route('academico.cursos')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('academico.cursos') ? 'bg-gray-100' : ''}}">
                            <i class="fa-solid fa-book text-gray-500"></i>
                            <span class="ml-3">Asistencias</span>
                        </a>
                    </x-slot>
                </x-dropdown>
            </li>
            <li>
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger" >
                        @can('Cartera')
                            <button type="button" class="iflex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('admin.countries.*') ? 'bg-gray-100' : ''}}">
                                <i class="fa-solid fa-cash-register text-gray-500"></i>
                                <span class="ml-3">CARTERA</span>
                            </button>
                        @endcan
                    </x-slot>
                    <x-slot name="content">
                        <a href="{{route('admin.countries.index')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('admin.countries.create') ? 'bg-gray-100' : ''}}">
                            <i class="fa-solid fa-credit-card text-gray-500"></i>
                            <span class="ml-3">Ingresos</span>
                        </a>
                        <a href="{{route('admin.countries.index')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('admin.countries.create') ? 'bg-gray-100' : ''}}">
                            <i class="fa-solid fa-credit-card text-gray-500"></i>
                            <span class="ml-3">Convenios Pago</span>
                        </a>
                    </x-slot>
                </x-dropdown>
            </li>
            <li>
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger" >
                        @can('Financiera')
                            <button type="button" class="iflex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('financiera.*') ? 'bg-gray-100' : ''}}">
                                <i class="fa-solid fa-chart-line text-gray-500"></i>
                                <span class="ml-3">FINANCIERA</span>
                            </button>
                        @endcan
                    </x-slot>
                    <x-slot name="content">
                        @can('fi_recibopagos')
                            <a href="{{route('financiera.recibopagos')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('financiera.recibopagos') ? 'bg-gray-100' : ''}}">
                                <i class="fa-solid fa-ranking-star text-gray-500"></i>
                                <span class="ml-3">Recibos Pago</span>
                            </a>
                        @endcan
                        @can('fi_cierrecaja')
                            <a href="{{route('financiera.cierrecaja')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('financiera.cierrecaja') ? 'bg-gray-100' : ''}}">
                                <i class="fa-solid fa-ranking-star text-gray-500"></i>
                                <span class="ml-3">Cierre Caja</span>
                            </a>
                        @endcan
                        @can('fi_conceptopagos')
                            <a href="{{route('financiera.conceptopagos')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('financiera.conceptopagos') ? 'bg-gray-100' : ''}}">
                                <i class="fa-solid fa-ranking-star text-gray-500"></i>
                                <span class="ml-3">Concepto Pago</span>
                            </a>
                        @endcan

                        @can('fi_configuracionpagos')
                            <a href="{{route('financiera.configpagos')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('financiera.configpagos') ? 'bg-gray-100' : ''}}">
                                <i class="fa-solid fa-ranking-star text-gray-500"></i>
                                <span class="ml-3">Configuración Pago</span>
                            </a>
                        @endcan
                    </x-slot>
                </x-dropdown>
            </li>
            <li>
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger" >
                        @can('Inventario')
                            <button type="button" class="iflex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('inventario.*') ? 'bg-gray-100' : ''}}">
                                <i class="fa-solid fa-cart-flatbed text-gray-500"></i>
                                <span class="ml-3">INVENTARIO</span>
                            </button>
                        @endcan
                    </x-slot>
                    <x-slot name="content">
                        @can('in_inventarios')
                            <a href="{{route('inventario.inventarios')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('inventario.inventarios') ? 'bg-gray-100' : ''}}">
                                <i class="fa-solid fa-warehouse text-gray-500"></i>
                                <span class="ml-3">Movimiento Inventario</span>
                            </a>
                        @endcan
                        @can('in_productos')
                            <a href="{{route('inventario.productos')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('inventario.productos') ? 'bg-gray-100' : ''}}">
                                <i class="fa-solid fa-warehouse text-gray-500"></i>
                                <span class="ml-3">Productos</span>
                            </a>
                        @endcan
                        @can('in_almacens')
                            <a href="{{route('inventario.almacens')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('inventario.almacens') ? 'bg-gray-100' : ''}}">
                                <i class="fa-solid fa-warehouse text-gray-500"></i>
                                <span class="ml-3">Almacenes</span>
                            </a>
                        @endcan
                    </x-slot>
                </x-dropdown>
            </li>
            <li>
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger" >
                        @can('Reportes')
                            <button type="button" class="iflex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('admin.countries.*') ? 'bg-gray-100' : ''}}">
                                <i class="fa-solid fa-headset text-gray-500"></i>
                                <span class="ml-3">REPORTES</span>
                            </button>
                        @endcan
                    </x-slot>
                    <x-slot name="content">
                        <a href="{{route('admin.countries.index')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('admin.countries.create') ? 'bg-gray-100' : ''}}">
                            <i class="fa-solid fa-book text-gray-500"></i>
                            <span class="ml-3">De Matricula</span>
                        </a>
                        <a href="{{route('admin.countries.index')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('admin.countries.create') ? 'bg-gray-100' : ''}}">
                            <i class="fa-solid fa-book text-gray-500"></i>
                            <span class="ml-3">De Ingresos</span>
                        </a>
                        <a href="{{route('admin.countries.index')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('admin.countries.create') ? 'bg-gray-100' : ''}}">
                            <i class="fa-solid fa-book text-gray-500"></i>
                            <span class="ml-3">De Cartera</span>
                        </a>
                    </x-slot>
                </x-dropdown>
            </li>
            <li>
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger" >
                        @can('Administracion')
                            <button type="button" class="iflex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('admin.*') ? 'bg-gray-100' : ''}}">
                                <i class="fa-solid fa-toolbox text-gray-500"></i>
                                <span class="ml-3">ADMINISTRACIÓN</span>
                            </button>
                        @endcan
                    </x-slot>
                    <x-slot name="content">
                        <a href="{{route('admin.saluds')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('admin.saluds') ? 'bg-gray-100' : ''}}">
                            <i class="fa-solid fa-screwdriver text-gray-500"></i>
                            <span class="ml-3">Profesores</span>
                        </a>
                        @can('ad_saluds')
                            <a href="{{route('admin.saluds')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('admin.saluds') ? 'bg-gray-100' : ''}}">
                                <i class="fa-solid fa-screwdriver text-gray-500"></i>
                                <span class="ml-3">Regímenes de Salud</span>
                            </a>
                        @endcan
                        @can('ad_multis')
                            <a href="{{route('admin.multis')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('admin.multis') ? 'bg-gray-100' : ''}}">
                                <i class="fa-solid fa-screwdriver text-gray-500"></i>
                                <span class="ml-3">Personas Multiculturales</span>
                            </a>
                        @endcan
                        <a href="{{route('admin.multis')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('admin.multis') ? 'bg-gray-100' : ''}}">
                            <i class="fa-solid fa-screwdriver text-gray-500"></i>
                            <span class="ml-3">Tipo de Contrato</span>
                        </a>
                    </x-slot>
                </x-dropdown>
            </li>
            <li>
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger" >
                        @can('Archivo')
                            <button type="button" class="iflex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('admin.countries.*') ? 'bg-gray-100' : ''}}">
                                <i class="fa-solid fa-folder-tree text-gray-500"></i>
                                <span class="ml-3">ARCHIVO</span>
                            </button>
                        @endcan
                    </x-slot>
                    <x-slot name="content">
                        <a href="{{route('admin.countries.index')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('admin.countries.create') ? 'bg-gray-100' : ''}}">
                            <i class="fa-solid fa-floppy-disk text-gray-500"></i>
                            <span class="ml-3">Listado Archivo</span>
                        </a>
                    </x-slot>
                </x-dropdown>
            </li>
            <li>
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger" >
                        @can('Configuracion')
                            <button type="button" class="iflex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('configuracion.*') ? 'bg-gray-100' : ''}}">
                                <i class="fa-solid fa-screwdriver-wrench text-gray-500"></i>
                                <span class="ml-3">CONFIGURACIÓN</span>
                            </button>
                        @endcan
                    </x-slot>
                    <x-slot name="content">
                        @can('co_estados')
                            <a href="{{route('configuracion.estados')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('configuracion.estados') ? 'bg-gray-100' : ''}}">
                                <i class="fa-solid fa-wrench text-gray-500"></i>
                                <span class="ml-3">Estados Estudiantes</span>
                            </a>
                        @endcan
                        @can('co_sedes')
                            <a href="{{route('configuracion.sedes')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('configuracion.sed*') ? 'bg-gray-100' : ''}}">
                                <i class="fa-solid fa-wrench text-gray-500"></i>
                                <span class="ml-3">Sedes</span>
                            </a>
                        @endcan
                        @can('co_countrys')
                            <a href="{{route('configuracion.ubicacionCountry')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('configuracion.ubica*') ? 'bg-gray-100' : ''}}">
                                <i class="fa-solid fa-wrench text-gray-500"></i>
                                <span class="ml-3">Ubicación</span>
                            </a>
                        @endcan
                        @can('co_users')
                            <a href="{{route('configuracion.users')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('configuracion.users') ? 'bg-gray-100' : ''}}">
                                <i class="fa-solid fa-wrench text-gray-500"></i>
                                <span class="ml-3">Usuarios</span>
                            </a>
                        @endcan
                        @can('co_rols')
                            <a href="{{route('configuracion.roles')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('configuracion.roles') ? 'bg-gray-100' : ''}}">
                                <i class="fa-solid fa-wrench text-gray-500"></i>
                                <span class="ml-3">Roles</span>
                            </a>
                        @endcan
                    </x-slot>
                </x-dropdown>
            </li>
        </ul>
    </div>
</aside>
{{-- @php
    $links = [
        [
            'name'      => 'ACADEMICO',
            'active'    => request()->routeIs('admin.*'),
            'icon'      =>'fa-solid fa-toolbox',
            'subs'      => [
                                'name'      => 'Profesores',
                                'url'       => route('admin.countries.index'),
                                'active'    => request()->routeIs('admin.countries.*'),
                                'icon'      =>'fa-solid fa-ruler',
                            ],
                            [
                                'name'      => 'Contrato',
                                'url'       => route('admin.countries.index'),
                                'active'    => request()->routeIs('admin.countries.*'),
                                'icon'      =>'fa-solid fa-ruler',
                            ],
                            [
                                'name'      => 'Multiculturales',
                                'url'       => route('admin.countries.index'),
                                'active'    => request()->routeIs('admin.countries.*'),
                                'icon'      =>'fa-solid fa-ruler',
                            ],
                            [
                                'name'      => 'Regímenes',
                                'url'       => route('admin.countries.index'),
                                'active'    => request()->routeIs('admin.countries.*'),
                                'icon'      =>'fa-solid fa-ruler',
                            ]
        ]
];
@endphp --}}
