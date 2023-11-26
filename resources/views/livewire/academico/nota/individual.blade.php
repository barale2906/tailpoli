<div>
    @if ($crt)
        <livewire:academico.matricula.matriculas-grupo :elegido="$grupo_id" />
    @else
        <a href="#" wire:click.prevent="$dispatch('cancelando')" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-6 capitalize">
            <i class="fa-solid fa-backward-fast fa-beat"></i> Volver
        </a>
    @endif

    <div class="relative overflow-x-auto mt-5">
        @if ($notas->count()>0)
            <h1 class="text-center text-lg mt-3">
                A continuación se presentan las notas para el grupo: <span class="uppercase font-extrabold">{{$actual->grupo->name}}</span>
            </h1>
            <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    @can('ac_notaEditar')
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
                                <th colspan="3"></th>
                                @foreach ($mapaencabe as $item)
                                    <th class="bg-slate-300 text-center text-xl m-3 p-3 rounded-2xl hover:bg-yellow-200" colspan="2" style="cursor: pointer;" wire:click="calificacion({{$item['id']}})">
                                        <i class="fa-solid fa-person-chalkboard"></i>
                                    </th>
                                @endforeach
                                <th></th>
                            </tr>
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
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                {{$nota->observaciones}}
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <h2 class="text-center text-xl uppercase">Aún no tiene notas registradas</h2>
        @endif
    </div>
</div>
