<div>
    <livewire:academico.matricula.matriculas-grupo :elegido="$grupo_id" />
    <h1 class="text-center text-lg font-semibold rounded-lg bg-cyan-300 uppercase">cargar asistencia</h1>
    @if ($actual)
        <div class="grid sm:grid-cols-1 md:grid-cols-6 gap-4 m-2">

            @if ($actual)
                <div>
                    @if (!$fechap || $crt>0)
                        <a href="#" wire:click.prevent="$dispatch('Asistiendo')" class="text-black bg-gradient-to-r from-green-300 via-green-400 to-green-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                            <i class="fa-solid fa-backward-fast fa-beat"></i> Volver
                        </a>
                    @endif

                </div>
                @can('ac_export_profe')
                    @if (!$fechap)
                        <a href="#" wire:click.prevent="exportar" class="w-auto text-teal-800 bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300 dark:focus:ring-teal-800 font-medium rounded-lg text-2xl px-5 py-2.5 text-center mr-2 mb-2 capitalize" >
                            <i class="fa-solid fa-file-excel fa-beat"></i>
                        </a>
                    @endif
                @endcan
                <div>

                </div>
            @endif
        </div>
        <div class="relative overflow-x-auto mt-5">
            <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3" >
                            Alumno
                        </th>
                        @can('ac_asistenciaCrear')
                            <th scope="col" class="px-6 py-3 flex" >
                                @if (!$dia)
                                    <label for="fechap" class="block mb-2 mr-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Carga Asistencia</label>
                                    <input type="date" id="fechap" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mr-2" wire:model.live="fechap">
                                    @if ($fechap)
                                        <a href="" wire:click.prevent="upFechap" class="text-black bg-gradient-to-r from-green-300 via-green-400 to-green-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                                            <i class="fa-solid fa-thumbs-up"></i>
                                        </a>
                                    @endif
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
                <input type="date" id="fecha"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.live="fecha">
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
