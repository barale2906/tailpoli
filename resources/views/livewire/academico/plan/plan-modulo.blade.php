<div>
    <div class="w-full p-4 text-center border border-gray-200 bg-green-100 shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700 m-2 rounded-3xl">
        <h5 class="mb-2 text-3xl font-bold text-gray-900 dark:text-white uppercase">
            {{$actual->grupo->modulo->curso->name}}
        </h5>
        <p class="mb-5 text-base text-gray-500 sm:text-lg dark:text-gray-400 uppercase font-extrabold">
            PLAN PARA EL MODULO: {{$actual->grupo->modulo->name}}
        </p>
        <p class="mb-5 text-base text-gray-500 sm:text-lg dark:text-gray-400 capitalize">
            Profesor: {{$actual->grupo->profesor->name}}
        </p>
        <p class="mb-5 text-base text-gray-500 sm:text-lg dark:text-gray-400 capitalize">
            Programación: {{$actual->ciclo->name}}
        </p>
        <div class="items-center justify-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4 rtl:space-x-reverse">
            <a href="#" wire:click.prevent="$dispatch('planeando')" class="w-full sm:w-auto bg-red-800 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 text-white rounded-lg inline-flex items-center justify-center px-4 py-2.5 dark:bg-red-700 dark:hover:bg-red-600 dark:focus:ring-red-700">
                <i class="fa-solid fa-rectangle-xmark"></i>
                <div class="text-left rtl:text-right">
                    <div class="mb-1 text-xs">volver a los cronogramas</div>
                    <div class="-mt-1 font-sans text-sm font-semibold">Volver</div>
                </div>
            </a>
        </div>
    </div>

    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 border border-gray-300 dark:border-gray-700 border-collapse">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3 text-center border border-gray-300 dark:border-gray-700 uppercase">
                        unidad
                    </th>
                    <th scope="col" class="px-6 py-3 text-center border border-gray-300 dark:border-gray-700 uppercase">
                        tema
                    </th>
                    <th scope="col" class="px-6 py-3 text-center border border-gray-300 dark:border-gray-700 uppercase">
                        Horas Modulo
                    </th>
                    <th scope="col" class="px-6 py-3 text-center border border-gray-300 dark:border-gray-700 uppercase">
                        Horas Tema
                    </th>
                    <th scope="col" class="px-6 py-3 text-center border border-gray-300 dark:border-gray-700 uppercase">
                        fechas
                    </th>
                    <th scope="col" class="px-6 py-3 text-center border border-gray-300 dark:border-gray-700 uppercase">
                        Actividades
                    </th>
                    <th scope="col" class="px-6 py-3 text-center border border-gray-300 dark:border-gray-700 uppercase">
                        Evidencias
                    </th>
                    <th scope="col" class="px-6 py-3 text-center border border-gray-300 dark:border-gray-700 uppercase">
                        Resultados
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($detalles as $detalle)
                    <tr class="border bg-white dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200">
                        @foreach ($temas as $tema)
                            @if ($detalle->unidtema_id===$tema->temaid)
                                <th scope="row" class=" p-1 text-gray-900 dark:text-white text-sm uppercase border border-gray-300 dark:border-gray-700">
                                    {{ $tema->unidad }}
                                </th>
                                <th scope="row" class=" p-1 text-gray-900 dark:text-white text-sm text-justify font-extrabold border border-gray-300 dark:border-gray-700">
                                    {{ $tema->tema }}
                                </th>
                                <th scope="row" class=" p-1 text-gray-900 dark:text-white text-center font-extrabold border border-gray-300 dark:border-gray-700">
                                    {{ $tema->unidura }}
                                </th>
                                <th scope="row" class=" p-1 text-gray-900 dark:text-white text-center font-extrabold border border-gray-300 dark:border-gray-700">
                                    {{ $tema->temadura }}
                                </th>
                            @endif
                        @endforeach
                        <th scope="row" class="text-gray-900 p-4 dark:text-white whitespace-nowrap text-sm border border-gray-300 dark:border-gray-700">
                            @foreach ($cronodetalles as $item)
                                @if ($item->unidtema_id===$detalle->unidtema_id)
                                    <a href="" wire:click.prevent="$dispatch('especia')" class="w-auto m-14 text-black bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm p-2 text-center capitalize" >
                                        {{$item->fecha_programada}}
                                    </a><br><br><br>
                                @endif
                            @endforeach
                        </th>
                        <th scope="row" class=" p-1 text-gray-900 dark:text-white text-sm border border-gray-300 dark:border-gray-700">
                            {{ $detalle->actividades }}
                        </th>
                        <th scope="row" class=" p-1 text-gray-900 dark:text-white text-sm border border-gray-300 dark:border-gray-700">
                            {{ $detalle->evidencias }}
                        </th>
                        <th scope="row" class=" p-1 text-gray-900 dark:text-white text-sm border border-gray-300 dark:border-gray-700">
                            {{ $detalle->resultados }}
                        </th>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>
