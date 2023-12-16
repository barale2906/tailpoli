<x-admin-layout>
    @push('title')
        CRM
    @endpush
    @can('cl_crm')
        <livewire:cliente.crm.crms />
    @endcan
    @can('cl_crmunit')
        <livewire:cliente.crm.crmsuni />
    @endcan


</x-admin-layout>
