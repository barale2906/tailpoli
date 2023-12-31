<div>
    @if ($crt)
        <livewire:academico.matricula.matriculas-grupo :elegido="$grupo_id" />
    @endif
    <a href="#" wire:click.prevent="$dispatch('cancelando')" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-6 capitalize">
        <i class="fa-solid fa-backward-fast fa-beat"></i> Volver
    </a>
    @can('ac_asistenciaCrear')

        <h1 class="text-center text-lg font-semibold rounded-lg bg-cyan-300 capitalize pt-2 mt-3">
            cargar asistencia para <span class="uppercase">{{$alumno->name}}</span>
            <button
                wire:click="registrAsitencia"
                class="text-black bg-gradient-to-r from-blue-300 via-blue-400 to-blue-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-200 dark:focus:ring-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize"
                >
                    <i class="fa-solid fa-upload"></i> Cargar Asistencia
            </button>
        </h1>

    @endcan


    @if ($actual)
        <h1 class="text-center text-lg mt-3">
            A continuación se presenta la asistencia para el grupo: <span class="uppercase font-extrabold">{{$actual->grupo->name}}</span>
        </h1>
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
                    @foreach ($asistencias as $item)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{$item->alumno}}
                            </th>
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
    @endif

</div>
