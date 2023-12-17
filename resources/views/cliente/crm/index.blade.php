<x-admin-layout>
    @push('title')
        CRM
    @endpush
    @can('cl_crm')
        <livewire:cliente.crm.crms />
    @endcan
    @can('cl_crmunit')
        <livewire:cliente.crm.crms :todo="1"/>
    @endcan


</x-admin-layout>
