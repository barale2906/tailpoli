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
                        <button type="button" class="iflex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('academico.*') ? 'bg-gray-100' : ''}} ">
                            <i class="fa-solid fa-graduation-cap  text-gray-500"></i>
                            <span class="ml-3">ACÁDEMICO</span>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <a href="{{route('academico.cursos')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('academico.cursos') ? 'bg-gray-100' : ''}}">
                            <i class="fa-solid fa-book text-gray-500"></i>
                            <span class="ml-3">Estudiantes</span>
                        </a>
                        <a href="{{route('academico.cursos')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('academico.cursos') ? 'bg-gray-100' : ''}}">
                            <i class="fa-solid fa-book text-gray-500"></i>
                            <span class="ml-3">Matriculas</span>
                        </a>
                        <a href="{{route('academico.cursos')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('academico.curs*') ? 'bg-gray-100' : ''}}">
                            <i class="fa-solid fa-book text-gray-500"></i>
                            <span class="ml-3">Cursos</span>
                        </a>

                        <a href="{{route('academico.cursos')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('academico.cursos') ? 'bg-gray-100' : ''}}">
                            <i class="fa-solid fa-book text-gray-500"></i>
                            <span class="ml-3">Módulos</span>
                        </a>
                        <a href="{{route('academico.cursos')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('academico.cursos') ? 'bg-gray-100' : ''}}">
                            <i class="fa-solid fa-book text-gray-500"></i>
                            <span class="ml-3">Grupos</span>
                        </a>
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
                        <button type="button" class="iflex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('admin.countries.*') ? 'bg-gray-100' : ''}}">
                            <i class="fa-solid fa-cash-register text-gray-500"></i>
                            <span class="ml-3">CARTERA</span>
                        </button>
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
                        <button type="button" class="iflex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('financiera.*') ? 'bg-gray-100' : ''}}">
                            <i class="fa-solid fa-chart-line text-gray-500"></i>
                            <span class="ml-3">FINANCIERA</span>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <a href="{{route('financiera.conceptopagos')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('financiera.conceptopagos') ? 'bg-gray-100' : ''}}">
                            <i class="fa-solid fa-ranking-star text-gray-500"></i>
                            <span class="ml-3">Recibos Pago</span>
                        </a>
                        <a href="{{route('financiera.conceptopagos')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('financiera.conceptopagos') ? 'bg-gray-100' : ''}}">
                            <i class="fa-solid fa-ranking-star text-gray-500"></i>
                            <span class="ml-3">Cierre Caja</span>
                        </a>
                        <a href="{{route('financiera.conceptopagos')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('financiera.conceptopagos') ? 'bg-gray-100' : ''}}">
                            <i class="fa-solid fa-ranking-star text-gray-500"></i>
                            <span class="ml-3">Concepto Pago</span>
                        </a>
                        <a href="{{route('financiera.conceptopagos')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('financiera.conceptopagos') ? 'bg-gray-100' : ''}}">
                            <i class="fa-solid fa-ranking-star text-gray-500"></i>
                            <span class="ml-3">Configuración Pago</span>
                        </a>
                    </x-slot>
                </x-dropdown>
            </li>
            <li>
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger" >
                        <button type="button" class="iflex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('inventario.*') ? 'bg-gray-100' : ''}}">
                            <i class="fa-solid fa-cart-flatbed text-gray-500"></i>
                            <span class="ml-3">INVENTARIO</span>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <a href="{{route('inventario.productos')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('inventario.produc') ? 'bg-gray-100' : ''}}">
                            <i class="fa-solid fa-warehouse text-gray-500"></i>
                            <span class="ml-3">Movimiento Inventario</span>
                        </a>
                        <a href="{{route('inventario.productos')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('inventario.productos') ? 'bg-gray-100' : ''}}">
                            <i class="fa-solid fa-warehouse text-gray-500"></i>
                            <span class="ml-3">Productos</span>
                        </a>
                        <a href="{{route('inventario.almacens')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('inventario.almacens') ? 'bg-gray-100' : ''}}">
                            <i class="fa-solid fa-warehouse text-gray-500"></i>
                            <span class="ml-3">Almacenes</span>
                        </a>
                    </x-slot>
                </x-dropdown>
            </li>
            <li>
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger" >
                        <button type="button" class="iflex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('admin.countries.*') ? 'bg-gray-100' : ''}}">
                            <i class="fa-solid fa-headset text-gray-500"></i>
                            <span class="ml-3">REPORTES</span>
                        </button>
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
                        <button type="button" class="iflex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('admin.*') ? 'bg-gray-100' : ''}}">
                            <i class="fa-solid fa-toolbox text-gray-500"></i>
                            <span class="ml-3">ADMINISTRACIÓN</span>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <a href="{{route('admin.saluds')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('admin.saluds') ? 'bg-gray-100' : ''}}">
                            <i class="fa-solid fa-screwdriver text-gray-500"></i>
                            <span class="ml-3">Profesores</span>
                        </a>
                        <a href="{{route('admin.saluds')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('admin.saluds') ? 'bg-gray-100' : ''}}">
                            <i class="fa-solid fa-screwdriver text-gray-500"></i>
                            <span class="ml-3">Regímenes de Salud</span>
                        </a>
                        <a href="{{route('admin.multis')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('admin.multis') ? 'bg-gray-100' : ''}}">
                            <i class="fa-solid fa-screwdriver text-gray-500"></i>
                            <span class="ml-3">Personas Multiculturales</span>
                        </a>
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
                        <button type="button" class="iflex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('admin.countries.*') ? 'bg-gray-100' : ''}}">
                            <i class="fa-solid fa-folder-tree text-gray-500"></i>
                            <span class="ml-3">ARCHIVO</span>
                        </button>
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
                        <button type="button" class="iflex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('configuracion.*') ? 'bg-gray-100' : ''}}">
                            <i class="fa-solid fa-screwdriver-wrench text-gray-500"></i>
                            <span class="ml-3">CONFIGURACIÓN</span>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <a href="{{route('configuracion.estados')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('configuracion.estados') ? 'bg-gray-100' : ''}}">
                            <i class="fa-solid fa-wrench text-gray-500"></i>
                            <span class="ml-3">Usuarios</span>
                        </a>
                        <a href="{{route('configuracion.estados')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('configuracion.estados') ? 'bg-gray-100' : ''}}">
                            <i class="fa-solid fa-wrench text-gray-500"></i>
                            <span class="ml-3">Estados Estudiantes</span>
                        </a>
                        <a href="{{route('configuracion.sedes')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('configuracion.sed*') ? 'bg-gray-100' : ''}}">
                            <i class="fa-solid fa-wrench text-gray-500"></i>
                            <span class="ml-3">Sedes</span>
                        </a>
                        <a href="{{route('configuracion.ubicacionCountry')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->routeIs('configuracion.ubica*') ? 'bg-gray-100' : ''}}">
                            <i class="fa-solid fa-wrench text-gray-500"></i>
                            <span class="ml-3">Ubicación</span>
                        </a>

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
