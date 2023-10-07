<div>
    <nav class="fixed top-0 z-50 w-full bg-blue-300 border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start">
                    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar"
                    x-on:click="open=!open"
                    aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                        </svg>
                    </button>
                    <a href="/dashboard" class="flex ml-2 md:mr-24">
                        <img src="{{asset('img/logo.png')}}" class="object-cover h-8 mr-3 rounded-t-lg" alt="{{env('APP_NAME')}} Logo" />
                        <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white">{{env('APP_NAME')}}</span>
                    </a>
                </div>
                <div class="flex items-center">

                    <!-- Settings Dropdown -->
                    <div class="ml-3 relative">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                    <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                        <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                    </button>
                                @else
                                    <span class="inline-flex rounded-md">
                                        <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                            {{ Auth::user()->name }}

                                            <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                            </svg>
                                        </button>
                                    </span>
                                @endif
                            </x-slot>

                            <x-slot name="content">
                                {{-- <!-- Account Management -->
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ __('Manage Account') }} ABV {{ Auth::user()->profile_photo_url }}
                                </div> --}}

                                <x-dropdown-link href="{{ route('profile.show') }}">
                                    {{ __('Profile') }}
                                </x-dropdown-link>

                                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                    <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                        {{ __('API Tokens') }}
                                    </x-dropdown-link>
                                @endif

                                <div class="border-t border-gray-200"></div>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}" x-data>
                                    @csrf

                                    <x-dropdown-link href="{{ route('logout') }}"
                                                @click.prevent="$root.submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>

                </div>
            </div>
        </div>
    </nav>

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
</div>
