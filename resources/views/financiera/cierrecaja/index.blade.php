<x-admin-layout>
    @push('title')
        Cierre de Caja
    @endpush

    @can('fi_cierrecaja')
        <livewire:financiera.cierre-caja.cierre-cajas />
    @endcan

    @can('fi_cierrecajaCajero')
        <livewire:financiera.cierre-caja.cierre-cajero />
    @endcan

</x-admin-layout>
