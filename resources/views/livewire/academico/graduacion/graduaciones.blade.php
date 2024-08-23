<div>
    <div class="bg-blue-200 rounded-lg align-middle p-2 mb-2 text-center">
        <h1 class="text-xl uppercase">Gestión de Graduaciones</h1>
    </div>
    @if ($is_modify)
        <div class="flex flex-wrap justify-end mb-4 ">
            @include('includes.filtro')
        </div>
        <div class="relative md:overflow-x-auto">
            <table class=" text-xs md:text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('id')">
                            ID
                            @if ($ordena != 'id')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('inicia')">
                            Fecha Inicio
                            @if ($ordena != 'inicia')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" >
                            Estudiante -- Matricula -- Fecha matricula
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" >
                            Programación
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" >
                            Grupo(s)
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('ultimo_pago')">
                            Último Pago
                            @if ($ordena != 'ultimo_pago')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('ultima_asistencia')">
                            Última Asistencia
                            @if ($ordena != 'ultima_asistencia')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('mora')">
                            Mora
                            @if ($ordena != 'mora')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('overol')">
                            Kit
                            @if ($ordena != 'overol')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('diploma')">
                            Diploma
                            @if ($ordena != 'diploma')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('ceremonia')">
                            Ceremonia
                            @if ($ordena != 'ceremonia')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('status_est')">
                            Estatus Estudiante
                            @if ($ordena != 'status_est')
                                <i class="fas fa-sort"></i>
                            @else
                                @if ($ordenado=='ASC')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($singrados as $item)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">

                                <div class="inline-flex rounded-md shadow-sm" role="group">
                                    <button type="button" class="inline-flex items-center p-2 text-sm font-medium text-gray-900 bg-blue-100 border border-gray-200 rounded-s-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                                        <a href="" wire:click.prevent="show({{$item->matricula_id}},{{5}})" class="inline-flex items-center font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                            <i class="fa-solid fa-book"></i>
                                        </a>
                                    </button>
                                    <button type="button" class="inline-flex rounded-e-lg items-center p-2 text-sm font-medium text-gray-900 bg-orange-100 border-t border-b border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                                        @can('ac_gestionCrear')
                                            <a href="" wire:click.prevent="show({{$item->id}},{{0}})" class="inline-flex items-center font-medium text-orange-600 dark:text-orange-500 hover:underline">
                                                <i class="fa-solid fa-marker"></i>
                                            </a>
                                        @endcan
                                    </button>
                                </div>

                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{$item->inicia}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white text-justify capitalize">
                                {{$item->estudiante->name}} -- {{$item->estudiante->documento}} -- Matricula: {{$item->matricula_id}} -- <br>{{$item->matricula->created_at}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                {{$item->ciclo->name}}
                            </th>
                            <th scope="row" class="font-medium text-gray-900 dark:text-white capitalize pt-3 pb-3">


                                @if ($is_vergrupo && $crtid===$item->id)
                                    <span class="bg-cyan-100 text-cyan-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-cyan-900 dark:text-cyan-300">
                                        <a href="#" wire:click.prevent="muestragrupo({{$item->id}},{{2}})" class="inline-flex items-center font-medium text-cyan-600 dark:text-cyan-500 hover:underline">
                                            <i class="fa-solid fa-eye-slash"></i>
                                        </a>
                                    </span>
                                    @foreach ($item->ciclo->ciclogrupos as $item)
                                        <div class="block max-w-sm p-2 mb-2 bg-white border border-gray-200 rounded-lg shadow hover:bg-cyan-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                                            <h5 class="mb-2 text-sm font-bold tracking-tight text-gray-900 dark:text-white capitalize">
                                                {{$item->grupo->name}}
                                            </h5>
                                            <p class="font-normal text-xs text-gray-700 dark:text-gray-400 capitalize">
                                                Modulo: {{$item->grupo->modulo->name}}
                                            </p>
                                            <p class="font-normal text-xs text-gray-700 dark:text-gray-400 capitalize mb-2">
                                                Profesor: {{$item->grupo->profesor->name}}
                                            </p>
                                            @if ($item->status_est!==2 || $item->status_est!==4 || $item->status_est!==11)
                                                <a href="" wire:click.prevent="notas({{$item->grupo->id}}, {{$item->estudiante_id}})" class="text-black bg-gradient-to-r from-green-300 via-green-400 to-green-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-700 font-medium rounded-lg text-sm px-1 py-1 text-center mr-2 mb-9 capitalize">
                                                    <i class="fa-solid fa-magnifying-glass"></i> Notas
                                                </a>

                                                <a href="" wire:click.prevent="asistencia({{$item->ciclo_id}}, {{$item->grupo->id}}, {{$item->estudiante_id}})" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-1 py-1 text-center mr-2 mb-5 capitalize">
                                                    <i class="fa-regular fa-calendar-days"></i> Asistencia
                                                </a>
                                            @endif
                                        </div>
                                    @endforeach
                                @else
                                    <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                                        <a href="#" wire:click.prevent="muestragrupo({{$item->id}},{{1}})" class="inline-flex items-center font-medium text-green-600 dark:text-green-500 hover:underline">
                                            <i class="fa-solid fa-binoculars"></i>
                                        </a>
                                    </span>
                                @endif

                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                {{$item->ultimo_pago}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                {{$item->ultima_asistencia}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                $ {{number_format($item->mora, 0, ',', '.')}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                {{$item->overol}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                @if ($item->diploma)
                                    {{number_format($item->diploma, 0, ',', '.')}}
                                @else
                                    Aún no.
                                @endif
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                @if ($item->ceremonia)
                                    {{number_format($item->ceremonia, 0, ',', '.')}}
                                @else
                                    Aún no.
                                @endif
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                @foreach ($estados as $value)
                                    @if ($value->id===$item->status_est)
                                        {{$value->name}}
                                    @endif
                                @endforeach
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-2 p-1 w-auto rounded-lg grid grid-cols-2 gap-4 bg-blue-100">
                <div>
                    <label class="relative inline-flex items-center mb-4 cursor-pointer">
                        <span class="ml-3 mr-3 text-sm font-medium text-gray-900 dark:text-gray-300">Registros:</span>
                        <select wire:click="paginas($event.target.value)" id="countries" class="w-20 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value=15>15</option>
                            <option value=20>20</option>
                            <option value=50>50</option>
                            <option value=100>100</option>
                        </select>
                    </label>
                </div>
                <div>
                    {{ $singrados->links() }}
                </div>
            </div>
        </div>
    @endif
</div>
