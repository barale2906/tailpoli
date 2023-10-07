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
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        {{-- <link href="{{ asset('build/assets/app-5bfe3cd1.css') }}" rel="stylesheet">
        <script src="{{ asset('build/assets/app-d509820f.js') }}" defer></script> --}}

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

        <livewire:layouts.navbar />

        <div class="p-2 bg-white h-full" x-on:click="open: false">
            <div class="p-4 border-2 border-blue-500 border-dashed rounded-lg dark:border-gray-700 mt-14">
                {{ $slot }}
            </div>
        </div>

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
