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
                <div>
                    <a href="#" wire:click.prevent="$dispatch('Editando')" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                        <i class="fa-solid fa-backward-fast fa-beat"></i> Volver
                    </a>
                </div>
                <div class="sm:cols-1 md:col-span-2">
                    @hasrole('Superusuario')
                        @can('ac_notaEditar')
                            <a href="#" wire:click.prevent="estudiante" class="text-black bg-gradient-to-r from-blue-300 via-blue-400 to-blue-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-200 dark:focus:ring-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                                <i class="fa-solid fa-suitcase-rolling"></i> Nuevo(a) Estudiante
                            </a>
                        @endcan
                    @endrole
                        @if ($actual->profesor_id===Auth::user()->id)
                            @can('ac_notaEditar')
                                <a href="#" wire:click.prevent="estudiante" class="text-black bg-gradient-to-r from-blue-300 via-blue-400 to-blue-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-200 dark:focus:ring-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                                    <i class="fa-solid fa-suitcase-rolling"></i> Nuevo(a) Estudiante
                                </a>
                            @endcan
                        @endif

                </div>
                <div>

                    @hasrole('Profesor')
                        @if ($actual->profesor_id===Auth::user()->id)
                            <a href="#" wire:click.prevent="abremodificar" class="text-black bg-gradient-to-r from-orange-300 via-orange-400 to-orange-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-orange-200 dark:focus:ring-orange-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                                <i class="fa-solid fa-pen-nib"></i> Modificar
                            </a>
                        @endif

                    @else
                        @can('ac_notaEditar')
                            <a href="#" wire:click.prevent="abremodificar" class="text-black bg-gradient-to-r from-orange-300 via-orange-400 to-orange-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-orange-200 dark:focus:ring-orange-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                                <i class="fa-solid fa-pen-nib"></i> Modificar
                            </a>
                        @endcan
                    @endrole

                </div>
            </div>
        </div>
    </div>

    @if ($listado)
        <div class="relative overflow-x-auto mt-5">
            @if ($notas->count()>0)
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
                        @foreach ($notas as $nota)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{$nota->alumno}}
                                </th>
                                @foreach ($encabezado as $item)
                                    <th scope="col" class="px-6 py-3" >
                                        {{$nota->$item}}
                                    </th>
                                @endforeach
                                </th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <h3 class="text-center text-blue-800 font-semibold capitalize text-lg">
                    No se han registrado calificaciones
                </h3>
            @endif
        </div>
    @endif



    @if ($cargar_estudiante)
        <livewire:academico.nota.notas-crear :actual="$actual"/>
    @endif

    @if ($cargar_nota)
        <livewire:academico.nota.notas-editar :actual="$actual"/>
    @endif

    @if ($modificar)
        <livewire:academico.nota.notas-editar :actual="$actual"/>
    @endif

</div>
