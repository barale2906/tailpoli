<div>
    <livewire:academico.matricula.matriculas-grupo :elegido="$grupo_id" />
    <h1 class="text-center uppercase p-3 rounded-lg bg-cyan-100 font-extrabold">
        Cargar asistencia
        @if ($estudiante)
            para: {{$estudiante->name}}
        @endif
        @can('ac_export_profe')
            <a href="" wire:click.prevent="exportar" class="w-auto text-teal-800 bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300 dark:focus:ring-teal-800 font-medium rounded-lg text-2xl px-5 py-2.5 text-center mr-2 mb-2 capitalize" >
                <i class="fa-solid fa-file-excel fa-beat"></i>
            </a>
        @endcan
    </h1>

    <div class="grid sm:grid-cols-1 md:grid-cols-4 gap-4 m-2 content-center text-center">
        <div></div>
        <div class="mb-6">
            <label for="fecha" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Fecha de asistencia</label>
            <input type="date" id="fecha"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.live="fecha">
        </div>
        @if ($fecha)
            <button
                wire:click="registro"
                class="text-black bg-gradient-to-r from-blue-300 via-blue-400 to-blue-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-200 dark:focus:ring-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize"
                >
                    <i class="fa-solid fa-upload"></i> Registrar Fecha
            </button>
        @endif
        <div></div>
    </div>
    @if ($actual )
        <div class="relative overflow-x-auto mt-5">
            <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3" >
                            Alumno
                        </th>
                        @foreach ($encabezado as $item)
                            <th scope="col" class="px-6 py-3" >
                                {{$actual->$item}}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @if ($estudiante)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{$asistencias->alumno}}
                            </th>
                            @foreach ($encabezado as $dato)
                                <th scope="col" class="px-6 py-3 text-center uppercase">
                                    @if ($asistencias->$dato)
                                        <strong>{{$asistencias->$dato}}</strong>
                                    @else
                                        @php
                                            $valor="'".$dato."'";
                                        @endphp
                                        <a href="" wire:click.prevent="cargaAsistencia({{$asistencias->id}},{{$valor}})" class="text-black bg-gradient-to-r from-green-300 via-green-400 to-green-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                                            <i class="fa-solid fa-plane-arrival"></i>
                                        </a>
                                    @endif
                                </th>
                            @endforeach
                        </tr>
                    @else
                        @foreach ($asistencias as $item)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{$item->alumno}}
                                </th>
                                @foreach ($encabezado as $dato)
                                    <th scope="col" class="px-6 py-3 text-center uppercase">
                                        @if ($item->$dato)
                                            <strong>{{$item->$dato}}</strong>
                                        @else
                                            @php
                                                $valor="'".$dato."'";
                                            @endphp
                                            <a href="" wire:click.prevent="cargaAsistencia({{$item->id}},{{$valor}})" class="text-black bg-gradient-to-r from-green-300 via-green-400 to-green-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                                                <i class="fa-solid fa-plane-arrival"></i>
                                            </a>
                                        @endif
                                    </th>
                                @endforeach
                            </tr>
                        @endforeach
                    @endif

                </tbody>
            </table>
        </div>
    @endif

</div>
