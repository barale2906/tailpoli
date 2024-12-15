<div class="w-full p-4 text-center bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
    <h5 class="mb-2 text-3xl font-bold text-gray-900 dark:text-white">
        CONSOLIDADO DE MATRICULAS
    </h5>
    <p class="mb-5 text-base text-gray-500 sm:text-lg dark:text-gray-400">
        Cantidad de matriculas en el período: {{number_format($consolidado->sum('total_registros'), 0, ',', '.')}}
    </p>
    <div class="items-center justify-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4 rtl:space-x-reverse">

        <a href="#" class="w-full sm:w-auto bg-blue-500 hover:bg-blue-400 focus:ring-4 focus:outline-none focus:ring-blue-100 text-white rounded-lg inline-flex items-center justify-center px-4 py-2.5 dark:bg-blue-400 dark:hover:bg-blue-300 dark:focus:ring-blue-00">
            <div class="text-left rtl:text-right">
                <div class="-mt-1 font-sans text-xl uppercase font-semibold">
                    Totales por comercial
                </div>
                <div class="flow-root">
                    <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">

                        @foreach ($consocomer as $item)
                            <li class="py-3 sm:py-4">
                                <div class="flex items-center">
                                    <div class="flex-1 min-w-0 ms-4">
                                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white capitalize">
                                            {{$item->comercial->name}}
                                        </p>
                                    </div>
                                    <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                        {{$item->total_registros}}
                                    </div>
                                </div>
                            </li>
                        @endforeach

                    </ul>
                </div>
            </div>

        </a>
        <a href="#" class="w-full sm:w-auto bg-green-500 hover:bg-green-400 focus:ring-4 focus:outline-none focus:ring-green-100 text-white rounded-lg inline-flex items-center justify-center px-4 py-2.5 dark:bg-green-400 dark:hover:bg-green-300 dark:focus:ring-green-400">
            <div class="text-left rtl:text-right">
                <div class="-mt-1 font-sans text-xl uppercase font-semibold">
                    Totales por Medio
                </div>
                <div class="flow-root">
                    <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">

                        @foreach ($consolidado as $item)
                            <li class="py-3 sm:py-4">
                                <div class="flex items-center">
                                    <div class="flex-1 min-w-0 ms-4">
                                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                            {{$item->medio}}
                                        </p>
                                    </div>
                                    <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                        {{$item->total_registros}}
                                    </div>
                                </div>
                            </li>
                        @endforeach

                    </ul>
                </div>
            </div>
        </a>
        <a href="#" class="w-full sm:w-auto bg-orange-500 hover:bg-orange-400 focus:ring-4 focus:outline-none focus:ring-orange-100 text-white rounded-lg inline-flex items-center justify-center px-4 py-2.5 dark:bg-orange-400 dark:hover:bg-orange-600 dark:focus:ring-orange-400">
            <div class="text-left rtl:text-right">
                <div class="-mt-1 font-sans text-xl uppercase font-semibold">
                    Totales por Curso
                </div>
                <div class="flow-root">
                    <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">

                        @foreach ($consocurso as $item)
                            <li class="py-3 sm:py-4">
                                <div class="flex items-center">
                                    <div class="flex-1 min-w-0 ms-4">
                                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white capitalize">
                                            {{$item->curso->name}}
                                        </p>
                                    </div>
                                    <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                        {{$item->total_registros}}
                                    </div>
                                </div>
                            </li>
                        @endforeach

                    </ul>
                </div>
            </div>
        </a>
    </div>
</div>
