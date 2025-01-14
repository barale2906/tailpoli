<div>
    @if ($is_detalle)
        <div class="w-full p-4 text-center border border-gray-200 bg-green-100 shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700 m-2 rounded-3xl">
            <h5 class="mb-2 text-3xl font-bold text-gray-900 dark:text-white uppercase">
                {{$actual->grupo->modulo->curso->name}}
            </h5>
            <p class="mb-5 text-base text-gray-500 sm:text-lg dark:text-gray-400 uppercase font-extrabold">
                CRONOGRAMA PARA EL MODULO: {{$actual->grupo->modulo->name}}
            </p>
            <p class="mb-5 text-base text-gray-500 sm:text-lg dark:text-gray-400 capitalize">
                Profesor: {{$actual->grupo->profesor->name}}
            </p>
            <p class="mb-5 text-base text-gray-500 sm:text-lg dark:text-gray-400 capitalize">
                Programación: {{$actual->ciclo->name}}
            </p>
            <div class="items-center justify-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4 rtl:space-x-reverse">
                <a href="#" wire:click.prevent="$dispatch('planeando')" class="w-full sm:w-auto bg-cyan-800 hover:bg-cyan-700 focus:ring-4 focus:outline-none focus:ring-cyan-300 text-white rounded-lg inline-flex items-center justify-center px-4 py-2.5 dark:bg-cyan-700 dark:hover:bg-cyan-600 dark:focus:ring-cyan-700">
                    <i class="fa-solid fa-stairs"></i>
                    <div class="text-left rtl:text-right">
                        <div class="mb-1 text-xs">Ver el plan de este modulo</div>
                        <div class="-mt-1 font-sans text-sm font-semibold">PLAN</div>
                    </div>
                </a>
                <a href="#" wire:click.prevent="$dispatch('cancelando')" class="w-full sm:w-auto bg-red-800 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 text-white rounded-lg inline-flex items-center justify-center px-4 py-2.5 dark:bg-red-700 dark:hover:bg-red-600 dark:focus:ring-red-700">
                    <i class="fa-solid fa-rectangle-xmark"></i>
                    <div class="text-left rtl:text-right">
                        <div class="mb-1 text-xs">volver a los cronogramas</div>
                        <div class="-mt-1 font-sans text-sm font-semibold">Cancelar</div>
                    </div>
                </a>
            </div>
        </div>

        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 border border-gray-300 dark:border-gray-700 border-collapse">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-center border border-gray-300 dark:border-gray-700 uppercase">
                            temas
                        </th>
                        <th scope="col" class="px-6 py-3 text-center border border-gray-300 dark:border-gray-700 uppercase">
                            intensidad
                        </th>
                        @foreach ($detalles as $item)
                            <th scope="col" class="px-6 py-3 text-center border border-gray-300 dark:border-gray-700 uppercase">
                                {{ $item->fecha_programada }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($unidades as $unidade)
                        <tr class="border bg-slate-600 dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200">
                            <th scope="row" class="px-6 py-4 text-gray-900 dark:text-white font-extrabold text-xl uppercase border border-gray-300 dark:border-gray-700">
                                {{ $unidade->name }}
                            </th>
                            <th scope="row" class="px-6 py-4 text-gray-900 dark:text-white text-xl font-extrabold border border-gray-300 dark:border-gray-700">
                                {{ $unidade->duracion }}
                            </th>
                            @foreach ($detalles as $seg)
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white border border-gray-300 dark:border-gray-700">

                                </th>
                            @endforeach
                        </tr>
                        @foreach ($unidade->temas as $item)
                            <tr class="bg-white border dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 capitalize dark:text-white border border-gray-300 dark:border-gray-700">
                                    {{ $item->name }}
                                </th>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white border border-gray-300 dark:border-gray-700">
                                    {{ $item->duracion }}
                                </th>
                                @foreach ($detalles as $value)
                                    <th scope="row" class="px-6 py-4 whitespace-nowrap font-medium text-gray-900 dark:text-white border border-gray-300 dark:border-gray-700">
                                        @if ($item->id === $value->unidtema_id)
                                            <span class="font-extrabold text-xs">{{ \Carbon\Carbon::parse($value->fecha_programada)->translatedFormat('F d') }}:</span>
                                            <br>{{ $value->duracion }} (h).
                                        @endif
                                    </th>
                                @endforeach
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>

        </div>
    @endif

    @if ($is_plan)
        <livewire:academico.plan.plan-modulo :grupo="$grupo" :idciclo="$idciclo" />
    @endif

</div>
