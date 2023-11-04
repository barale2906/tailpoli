{{-- <div class="
bg-no-repeat bg-cover bg-center
bg-[url('../public/img/logo.png')]
md:bg-none
xl:bg-[url('../public/img/logo.png')]
"> --}}
<div style="background-image: url({{asset('img/logo.jpeg')}});">
    @push('title')
        Recibo N°: {{$recibo}}
    @endpush

    <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
    <span class="font-medium">Recibo de Caja N°: {{$recibo}}</span> {{$obtener->paga->name}}.
    </div>

</div>
