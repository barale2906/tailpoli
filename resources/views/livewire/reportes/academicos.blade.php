<div>
    <h1 class="text-center text-xl font-bold">
        A continuación puede generar los reportes descritos
    </h1>
    <div class="grid sm:grid-cols-1 md:grid-cols-4 gap-4 m-3">

        <a href="" wire:click.prevent="show(1)" class="block max-w-sm p-6 bg-white border border-gray-200 ring rounded-2xl shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">

            <h5 class="mb-2 text-sm md:text-2xl font-bold  tracking-tight text-gray-900 dark:text-white">
                Reporte Matriculas
            </h5>
            <p class="font-normal text-xs md:text-xl text-justify text-gray-700 dark:text-gray-400">
                Obtendrá las matriculas en un rango de fechas especificando, estudiante, curso, fecha inicio, curso, programación, pago matricula.
            </p>

        </a>

        <a href="" wire:click.prevent="show(2)" class="block max-w-sm p-6 bg-white border border-gray-200 ring rounded-2xl shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">

            <h5 class="mb-2 text-sm md:text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                Reporte de Programaciones
            </h5>
            <p class="font-normal text-xs md:text-xl text-justify text-gray-700 dark:text-gray-400">
                Muestra las programaciones y sus datos básicos
            </p>

        </a>

        <a href="" wire:click.prevent="show(3)" class="block max-w-sm p-6 bg-white border border-gray-200 ring rounded-2xl shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">

            <h5 class="mb-2 text-sm md:text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                Reporte de Asistencia
            </h5>
            <p class="font-normal text-xs md:text-xl text-justify text-gray-700 dark:text-gray-400">
                Se obtendrá por sede, curso, programación
            </p>

        </a>

        <a href="" wire:click.prevent="show(4)" class="block max-w-sm p-6 bg-white border border-gray-200 ring rounded-2xl shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">

            <h5 class="mb-2 text-sm md:text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                Reporte Activos
            </h5>
            <p class="font-normal text-xs md:text-xl text-justify text-gray-700 dark:text-gray-400">
                Muestra listado de estudiantes activos por sede, curso, programación.
            </p>

        </a>

    </div>

    @if ($is_reporte)
        @switch($clase)
            @case(1)
                <livewire:academico.matricula.matriculas :crt="1" />
                @break
            @case(2)
                <livewire:academico.ciclo.ciclos />
                @break
            @case(3)
                <livewire:academico.nota.notas />
                @break
            @case(4)
                <livewire:reportes.activos />
                @break

        @endswitch
    @endif

</div>
