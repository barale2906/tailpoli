<div>
    @if ($actual)
        <div class="flex p-4 text-sm text-green-800 rounded-lg bg-green-100 dark:bg-gray-800 dark:text-green-400" role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 mr-3 mt-[2px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <span class="sr-only">Info</span>
            <div>
                <span class="font-bold  text-2xl ">Asistencia para el grupo: <strong class="uppercase">{{$actual->grupo->name}}</strong>.</span>
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
                    @if ($actual)
                        <div>
                            <a href="#" wire:click.prevent="$dispatch('Asistiendo')" class="text-black bg-gradient-to-r from-green-300 via-green-400 to-green-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                                <i class="fa-solid fa-backward-fast fa-beat"></i> Volver
                            </a>
                        </div>
                        @can('ac_export_profe')
                            <a href="#" wire:click.prevent="exportar" class="w-auto text-teal-800 bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300 dark:focus:ring-teal-800 font-medium rounded-lg text-2xl px-5 py-2.5 text-center mr-2 mb-2 capitalize" >
                                <i class="fa-solid fa-file-excel fa-beat"></i>
                            </a>
                        @endcan
                        <div>

                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="relative overflow-x-auto mt-5">
            <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3" >
                            Alumno
                        </th>
                        @can('ac_asistenciaCrear')
                            <th scope="col" class="px-6 py-3" >
                                @if (!$dia)
                                    <label for="fechap" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Carga Asistencia</label>
                                    <input type="date" id="fechap" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Descripción de la configuración" wire:model.live="fechap">
                                @endif

                            </th>
                        @endcan
                        @foreach ($encabezado as $item)
                            <th scope="col" class="px-6 py-3" >
                                {{$actual->$item}}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($asistencias as $item)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{$item->alumno}}
                            </th>
                            @can('ac_asistenciaCrear')
                                <th scope="col" class="px-6 py-3" >
                                    @if ($dia)
                                        <a href="" wire:click.prevent="AsistenciaCorriente({{$item->id}})" class="text-black bg-gradient-to-r from-green-300 via-green-400 to-green-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                                            <i class="fa-solid fa-plane-arrival"></i>
                                        </a>
                                    @endif
                                </th>
                            @endcan
                            @foreach ($encabezado as $dato)
                                <th scope="col" class="px-6 py-3 text-center uppercase">
                                    <strong>{{$item->$dato}}</strong>
                                </th>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="grid sm:grid-cols-1 md:grid-cols-4 gap-4 m-2">
            <div class="mb-6">
                <label for="fecha" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Fecha de asistencia</label>
                <input type="date" id="fecha" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Descripción de la configuración" wire:model.live="fecha">
            </div>
            <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3" >
                            Alumno
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($alumnosPrime as $item)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200">
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{$item->name}}
                            </td>
                            <td>
                                <a href="" wire:click.prevent="primerAlumno({{$item}})" class="text-black bg-gradient-to-r from-green-300 via-green-400 to-green-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                                    <i class="fa-solid fa-plane-arrival"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if (!$actual && $fecha && count($llegaron)>0)
                <button
                    wire:click="primero"
                    class="text-black bg-gradient-to-r from-blue-300 via-blue-400 to-blue-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-200 dark:focus:ring-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize"
                    >
                        <i class="fa-solid fa-upload"></i> Crear Registros
                </button>
            @endif
        </div>
    @endif

</div>
