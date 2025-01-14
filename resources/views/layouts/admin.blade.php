<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- <title>{{ config('app.name', 'Laravel') }}</title> --}}
        <title>@stack('title')</title>

        <link rel="shortcut icon" href="{{asset('img/icon.ico')}}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Font Awesome -->
        <script src="https://kit.fontawesome.com/c5e988e23f.js" crossorigin="anonymous"></script>

        <!-- Font Awesome -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- Sweetalert2 -->
        {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
        <link href="{{ asset('build/assets/app-bfb510f4.css') }}" rel="stylesheet">
        <script src="{{ asset('build/assets/app-7dc077a2.js') }}" defer></script>

        {{-- DB_CONNECTION=mysql
            DB_HOST=127.0.0.1
            DB_PORT=3306
            DB_DATABASE=poliandino
            DB_USERNAME=poliandino
            DB_PASSWORD=Poliandino_2023 --}}

        <!-- Styles -->
        @livewireStyles

        @stack('css')
    </head>
    <body class="font-sans antialiased"
    :class="{'overflow-hidden':  open}"
    x-data="{
        open: false,
    }"
    >

        {{-- @include('layouts.includes.admin.nav');
        @include('layouts.includes.admin.aside'); --}}

        @if (Auth::user()->status)
            <livewire:layouts.navbar />

            <div class="p-2 bg-white h-full" x-on:click="open: false">
                <div class="p-4 border-2 border-blue-500 border-dashed rounded-lg dark:border-gray-700 mt-14">
                    {{ $slot }}
                </div>
            </div>
        @else

            <div class="p-2 bg-white grid sm:grid-cols-1 md:grid-cols-3 gap-4 content-center" >
                <div></div>
                <div class="p-4 border-2 border-zinc-500 border-dashed rounded-lg dark:border-gray-700">
                    <div class="max-w-lg p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                        <i class="fa-solid fa-circle-radiation text-9xl text-amber-700 text-center m-6"></i>
                        <a href="#">
                            <h5 class="mb-2 text-5xl font-semibold tracking-tight text-gray-900 dark:text-white">¡Su registro se encuentra Inactivo!</h5>
                        </a>
                        <p class="mb-3 font-normal text-2xl text-gray-500 dark:text-gray-400">
                            Comuníquese con el administrador(a) del sistema.
                        </p>

                        <form method="POST" action="{{ route('logout') }}" x-data>
                            @csrf

                            <x-dropdown-link class="bg-orange-600 hover:bg-orange-300 text-2xl font-extrabold rounded-lg text-black text-center" href="{{ route('logout') }}"
                                    @click.prevent="$root.submit();">
                                VOLVER AL INICIO
                            </x-dropdown-link>
                        </form>
                    </div>
                </div>
                <div></div>
            </div>


        @endif



        @stack('modals')

        @livewireScripts

        @if (session('Swal'))
            <script>
                Swal.fire(@json(session('Swal')))
            </script>
        @endif
        @stack('js')
    </body>
</html>
