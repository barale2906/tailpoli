<div>
    <div class="flex p-4 text-sm text-blue-800 rounded-lg bg-cyan-100 dark:bg-gray-800 dark:text-blue-400" role="alert">
        <svg class="flex-shrink-0 inline w-4 h-4 mr-3 mt-[2px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
        </svg>
        <span class="sr-only">Info</span>
        <div>
            <span class="font-bold  text-2xl ">Datos de la configuración de Notas para el grupo: <strong class="uppercase">{{$actual->grupo->name}}</strong>.</span>
            <div class="grid sm:grid-cols-1 md:grid-cols-3 gap-3 m-2">
                <div>
                    <ul class="mt-1.5 ml-4 list-disc list-inside mb-3 text-lg capitalize">
                        <li>Inicia: <strong>{{$actual->grupo->start_date}}</strong></li>
                        <li>Términa: <strong>{{$actual->grupo->finish_date}}</strong></li>
                        <li>Max Estudiantes: <strong>{{$actual->grupo->quantity_limit}}</strong></li>
                        <li>Estudiantes Inscritos: <strong>{{$actual->grupo->inscritos}}</strong></li>
                        <li>Profesor: <strong>{{$actual->profesor->name}}</strong></li>
                    </ul>
                </div>
                <div>
                    <ul class="mt-1.5 ml-4 list-disc list-inside mb-3 text-lg capitalize">
                        <li>Modulo: <strong>{{$actual->grupo->modulo->name}}</strong></li>
                        <li>Curso: <strong>{{$actual->grupo->modulo->curso->name}}</strong></li>
                    </ul>
                </div>
                <div>
                    <ul class="mt-1.5 ml-4 list-disc list-inside mb-3 text-lg capitalize">
                        <li>Sede: <strong>{{$actual->grupo->sede->name}}</strong></li>
                        <li>Ciudad: <strong>{{$actual->grupo->sede->sector->name}}</strong></li>
                    </ul>
                </div>
            </div>
            <div class="grid sm:grid-cols-1 md:grid-cols-6 gap-4 m-2">
                <div class="sm:cols-1 md:col-span-3">
                    <span class="font-bold uppercase text-sm ">Horarios:</span>
                    <ul class="mt-1.5 ml-4 list-disc list-inside mb-3 text-lg capitalize">
                            <li><strong>horarios</strong></li>
                    </ul>
                </div>
                <div class="sm:cols-1 md:col-span-3">
                    <p class="text text-justify text-lg">
                        <strong>Descripción:</strong>
                        {{$actual->descripcion}}
                    </p>
                </div>
                @if ($listado)
                    <div>
                        <a href="#" wire:click.prevent="$dispatch('Editando')" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                            <i class="fa-solid fa-backward-fast fa-beat"></i> Volver
                        </a>
                    </div>
                    <div>

                    </div>
                @endif

                @if ($cargar_nota)
                    <a href="" wire:click.prevent="abrenotas" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                        <i class="fa-solid fa-rectangle-xmark"></i> Cancelar
                    </a>
                @endif

                @if ($aprueba)
                    <div class="md:inline-flex rounded-md shadow-sm" role="group">
                        <button
                            type="button"
                            class="inline-flex items-center px-4 py-2 text-sm sm:text-xs font-medium text-gray-900 bg-transparent border border-gray-900 rounded-l-lg hover:bg-red-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700"
                            wire:click="abrenaprueba"
                            >
                            <i class="fa-solid fa-rectangle-xmark"></i>
                            CANCELAR
                        </button>

                        <button
                            type="button"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-green-900 bg-green-200 border border-green-900 hover:bg-green-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-green-500 focus:bg-green-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-green-700 dark:focus:bg-green-700"
                            wire:click="aprobo"
                            >
                            <i class="fa-regular fa-face-grin-squint-tears"></i>
                            APROBO
                        </button>

                        <button
                            type="button"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-orange-900 bg-orange-200 border border-orange-900 rounded-r-md hover:bg-orange-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-orange-500 focus:bg-orange-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-orange-700 dark:focus:bg-orange-700"
                            wire:click="reprobo"
                            >
                            <i class="fa-regular fa-face-sad-tear"></i>
                            REPROBO
                        </button>
                    </div>
                @endif

            </div>
        </div>
    </div>

    @if ($listado)
        <div class="relative overflow-x-auto mt-5">
            @if ($notas->count()>0)
                <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th colspan="3"></th>
                            @foreach ($mapaencabe as $item)
                                <th class="bg-slate-300 text-center text-xl m-3 p-3 rounded-2xl hover:bg-yellow-200" colspan="2" style="cursor: pointer;" wire:click="calificacion({{$item['id']}})">
                                    <i class="fa-solid fa-person-chalkboard"></i>
                                </th>
                            @endforeach
                            <th></th>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6 py-3" >
                                Alumno
                            </th>
                            <th scope="col" class="px-6 py-3" >
                                Acumulado
                            </th>
                            <th scope="col" class="px-6 py-3" >
                                Aprobo
                            </th>
                            @foreach ($encabezado as $item)
                                <th scope="col" class="px-6 py-3" >
                                    {{$actual->$item}}
                                </th>
                            @endforeach
                            <th scope="col" class="px-6 py-3" >
                                Observaciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($notas as $nota)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{$nota->alumno}}
                                </th>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{$nota->acumulado}}
                                </th>

                                @switch($nota->aprobo)
                                        @case(0)
                                            @if ($nota->acumulado)
                                                <th scope="row" class="px-6 py-4 rounded-s-sm font-medium hover:bg-orange-200 text-gray-900 whitespace-nowrap dark:text-white" style="cursor: pointer;" wire:click="finaprueba({{$nota->id}})">
                                                    Califica
                                                </th>
                                            @else
                                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    --
                                                </th>
                                            @endif

                                            @break
                                        @case(1)
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                APROBADO
                                            </th>
                                            @break
                                        @case(2)
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                REPROBADO
                                            </th>
                                            @break
                                    @endswitch

                                @foreach ($encabezado as $item)
                                    <th scope="col" class="px-6 py-3" >
                                        {{$nota->$item}}
                                    </th>
                                @endforeach
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{$nota->observaciones}}
                                </th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    @endif

    @if ($cargar_nota)
        <livewire:academico.nota.notas-alumno :notaenv="$notaenv" :porcenv="$porcenv" :actual="$actual"/>
    @endif

    @if ($aprueba)
        <livewire:academico.nota.notas-aprobar :idcierra="$idcierra" :actual="$actual"/>
    @endif
</div>
