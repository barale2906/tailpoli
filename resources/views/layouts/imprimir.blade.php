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
        @livewireStyles

        @stack('css')
    </head>
    <body class="font-sans antialiased" {{-- onload="window.print()" --}}>

        {{ $slot }}


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
