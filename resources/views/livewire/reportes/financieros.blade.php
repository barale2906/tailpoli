<div>
    <h1 class="text-center text-xl font-bold">
        A continuación puede generar los reportes descritos
    </h1>
    <div class="grid sm:grid-cols-1 md:grid-cols-4 gap-4 m-3">

        <a href="" wire:click.prevent="show(1)" class="block max-w-sm p-6 bg-white border border-gray-200 ring rounded-2xl shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">

            <h5 class="mb-2 text-2xl font-bold  tracking-tight text-gray-900 dark:text-white">
                Reporte de Cartera
            </h5>
            <p class="font-normal text-justify text-gray-700 dark:text-gray-400">
                Verifique la cartera actual y obtenga cartera especifica por ciudades, sedes, períodos, estudiantes. Con la posibilidad de descarglo a excel
            </p>

        </a>

        <a href="" wire:click.prevent="show(2)" class="block max-w-sm p-6 bg-white border border-gray-200 ring rounded-2xl shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">

            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                Reporte de Pagos
            </h5>
            <p class="font-normal text-justify text-gray-700 dark:text-gray-400">
                Verifique la relación de pagos y obtenga pagos especificos por ciudades, sedes, períodos, estudiantes. Con la posibilidad de descarglo a excel
            </p>

        </a>

        <a href="" wire:click.prevent="show(3)" class="block max-w-sm p-6 bg-white border border-gray-200 ring rounded-2xl shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">

            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                Reporte Gestión Clientes
            </h5>
            <p class="font-normal text-justify text-gray-700 dark:text-gray-400">
                Desde acá podra encontrar información sobre la gestión de los clientes.
            </p>

        </a>

        <a href="" wire:click.prevent="show(4)" class="block max-w-sm p-6 bg-white border border-gray-200 ring rounded-2xl shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">

            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                Reporte Recibos Contables
            </h5>
            <p class="font-normal text-justify text-gray-700 dark:text-gray-400">
                Genera un informe de todos los recibos de pago generados que ya esten cerrados con el cierre de caja respectivo.
            </p>

        </a>

    </div>

    @if ($is_cartera)
        <livewire:cartera.cartera.carteras />
    @endif

    @if ($is_pagos)
        <livewire:financiera.recibo-pago.recibos-pago :reporte="2"/>
    @endif

    @if ($is_crm)
        <livewire:cliente.crm.crms :reporte="3"/>
    @endif

    @if ($is_cierre)
        <livewire:financiera.cierre-caja.cierre-cajas :reporte="1"/>
    @endif


</div>
