<div>
    <livewire:academico.matricula.matriculas-grupo :elegido="$grupo" />
    <div class="grid sm:grid-cols-1 md:grid-cols-6 gap-4 m-2">

            @if ($cargar_nota)
                <a href="" wire:click.prevent="abrenotas" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                    <i class="fa-solid fa-rectangle-xmark"></i> Cancelar
                </a>
            @endif

            @if ($aprueba)
                <div class="md:inline-flex rounded-md shadow-sm" role="group">
                    <button
                        type="button"
                        class="inline-flex items-center px-4 py-2 text-sm sm:text-xs font-medium text-gray-900 bg-transparent border border-gray-900 rounded-l-lg hover:bg-red-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700 mr-10"
                        wire:click="abrenaprueba"
                        >
                        <i class="fa-solid fa-rectangle-xmark"></i>
                        CANCELAR
                    </button>

                    <button
                        type="button"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-green-900 bg-green-200 border border-green-900 hover:bg-green-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-green-500 focus:bg-green-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-green-700 dark:focus:bg-green-700 mr-10"
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

            @can('ac_export_profe')
                <a href="#" wire:click.prevent="exportar" class="w-auto text-teal-800 bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300 dark:focus:ring-teal-800 font-medium rounded-lg text-2xl px-5 py-2.5 text-center mr-2 mb-2 capitalize" >
                    <i class="fa-solid fa-file-excel fa-beat"></i>
                </a>
            @endcan
    </div>

    @if ($listado)
        <div class="relative overflow-x-auto mt-5">
            @if ($notas->count()>0)
                <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        @can('ac_notaEditar')
                            @hasrole('Profesor')
                                @if ($actual->profesor_id===Auth::user()->id)
                                    <tr>
                                        <th colspan="3"></th>
                                        @foreach ($mapaencabe as $item)
                                            <th class="bg-slate-300 text-center text-xl m-3 p-3 rounded-2xl hover:bg-yellow-200" colspan="2" style="cursor: pointer;" wire:click="calificacion({{$item['id']}})">
                                                <i class="fa-solid fa-person-chalkboard"></i>
                                            </th>
                                        @endforeach
                                        <th></th>
                                    </tr>
                                @endif
                            @else
                                <tr>
                                    <th colspan="3"></th>
                                    @foreach ($mapaencabe as $item)
                                        <th class="bg-slate-300 text-center text-xl m-3 p-3 rounded-2xl hover:bg-yellow-200" colspan="2" style="cursor: pointer;" wire:click="calificacion({{$item['id']}})">
                                            <i class="fa-solid fa-person-chalkboard"></i>
                                        </th>
                                    @endforeach
                                    <th></th>
                                </tr>
                            @endhasrole
                        @endcan
                        <tr>
                            <th scope="col" class="px-6 py-3" >
                                Alumno
                            </th>
                            <th scope="col" class="px-6 py-3" >
                                Acumulado
                            </th>
                            @can('ac_notaEditar')
                                <th scope="col" class="px-6 py-3" >
                                    Aprobo
                                </th>
                            @endcan
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
                                @can('ac_notaEditar')
                                    @switch($nota->aprobo)
                                        @case(0)
                                            @if ($nota->acumulado)

                                                    @hasrole('Profesor')
                                                        @if ($actual->profesor_id===Auth::user()->id)
                                                            <th scope="row" class="px-6 py-4 rounded-s-sm font-medium hover:bg-orange-200 text-gray-900 whitespace-nowrap dark:text-white" style="cursor: pointer;"
                                                            wire:click="finaprueba({{$nota->id}})"
                                                                >
                                                                Califica
                                                            </th>
                                                        @else
                                                            <th scope="row" class="px-6 py-4 rounded-s-sm font-medium hover:bg-orange-200 text-gray-900 whitespace-nowrap dark:text-white">
                                                                Califica
                                                            </th>
                                                        @endif
                                                    @else
                                                        <th scope="row" class="px-6 py-4 rounded-s-sm font-medium hover:bg-orange-200 text-gray-900 whitespace-nowrap dark:text-white" style="cursor: pointer;" wire:click="finaprueba({{$nota->id}})">
                                                            Califica
                                                        </th>
                                                    @endhasrole

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
                                @endcan
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
            @else
                <h2 class="text-center text-xl uppercase">No hay alumnos inscritos a este grupo</h2>
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
