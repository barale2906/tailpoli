<x-admin-layout>
    @push('title')
        Tablero de Control
    @endpush

    @hasrole('Estudiante')
        <livewire:dashboard.estudiante />
    @endhasrole

    @if (Auth::user()->rol_id<4)
        <livewire:cartera.cartera.consolidado />
    @endif

</x-admin-layout>
