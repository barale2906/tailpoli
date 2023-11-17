<div>
    <form wire:submit.prevent="new">
        <div class="flex">
            <div class="grid sm:grid-cols-1 md:grid-cols-3 gap-4">
                <div class="mb-6">
                    <label for="curso_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Curso</label>
                    <select wire:model.live="curso_id" id="curso_id" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                        <option >Elegir curso...</option>
                        @foreach ($cursos as $item)
                            <option value={{$item->id}}>{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>

                @if ($curso_id>0)
                    <div class="mb-6">
                        <label for="modulo_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Modulo</label>
                        <select wire:model.live="modulo_id" id="modulo_id" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                            <option >Elegir modulo...</option>
                            @foreach ($modulos as $item)
                                <option value={{$item->id}}>{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                @endif

                @if ($modulo_id>0)
                    <div class="mb-6">
                        <label for="sede_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sede</label>
                        <select wire:model.live="sede_id" id="sede_id" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                            <option >Elegir sede...</option>
                            @foreach ($sedes as $item)
                                <option value={{$item->id}}>Sede: {{$item->name}} - Ciudad: {{$item->sector->name}}</option>
                            @endforeach
                        </select>
                    </div>
                @endif

                @if ($sede_id>0)
                    <div class="mb-6">
                        <label for="profesor_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Profesor</label>
                        <select wire:model.live="profesor_id" id="profesor_id" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                            <option >Elegir profesor...</option>
                            @foreach ($profesores as $item)
                                <option value={{$item->id}}>{{$item->name}} </option>
                            @endforeach
                        </select>
                    </div>
                @endif


                @if ($profesor_id>0)
                    <div class="mb-6">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre del Grupo</label>
                        <input type="text" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nombre" wire:model.live="name">
                        @error('name')
                            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                            </div>
                        @enderror
                    </div>

                    {{-- <div class="mb-6">
                        <label for="start_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha de Inicio</label>
                        <input type="date" id="start_date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"  wire:model.live="start_date">
                        @error('start_date')
                            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                            </div>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="finish_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha de Finalización</label>
                        <input type="date" id="finish_date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"  wire:model.blur="finish_date">
                        @error('finish_date')
                            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                            </div>
                        @enderror
                    </div> --}}

                    <div class="mb-6">
                        <label for="quantity_limit" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Límite de Estudiantes</label>
                        <input type="text" id="quantity_limit" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="cantidad" wire:model.blur="quantity_limit">
                        @error('quantity_limit')
                            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                            </div>
                        @enderror
                    </div>


                @endif
            </div>
            <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-4">

                @if ($profesor_id>0 && count($seleccionados)>0)
                    <div>
                        <button type="submit"
                        class="text-white bg-blue-500 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-400 dark:hover:bg-blue-500 dark:focus:ring-blue-400"
                        >
                            Nuevo Grupo
                        </button>
                    </div>
                @endif

                <div>
                    <a href="#" wire:click.prevent="$dispatch('created')" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                        <i class="fa-solid fa-rectangle-xmark"></i> cancelar
                    </a>
                </div>
            </div>
        </div>
    </form>
    @if ($sede_id && $profesor_id)

            <h1 class="text-lg font-extrabold capitalize text-center">horario de funcionamiento de la sede {{$sede->name}}</h1>

            <div class="grid mb-8 border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 md:mb-12 sm:grid-cols-1 md:grid-cols-7 bg-white dark:bg-gray-800">
                @for ($i = 1; $i <= 7; $i++)
                    <figure class="flex flex-col items-center p-4 text-center bg-white border-b border-gray-200 rounded-t-lg md:rounded-t-none md:rounded-ss-lg md:border-e dark:bg-gray-800 dark:border-gray-700">
                        <blockquote class="max-w-2xl mx-auto mb-2 text-gray-500 lg:mb-8 dark:text-gray-400">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white uppercase">
                                @switch($i)
                                    @case(1)
                                        lunes
                                        @break
                                    @case(2)
                                        martes
                                        @break
                                    @case(3)
                                        miércoles
                                        @break
                                    @case(4)
                                        jueves
                                        @break
                                    @case(5)
                                        viernes
                                        @break
                                    @case(6)
                                        sábado
                                        @break
                                    @case(7)
                                        domingo
                                        @break
                                @endswitch
                            </h3>
                        </blockquote>
                        <figcaption class="flex items-center justify-center ">
                            <div class="space-y-0.5 font-medium dark:text-white text-left rtl:text-right ms-3">
                                @foreach ($funcionamiento as $item)
                                        @switch($i)
                                            @case(1)
                                                @if ($item->periodo && $item->dia==="lunes")
                                                    <div>
                                                        Abre: <strong>{{$item->hora}}</strong>
                                                    </div>
                                                @endif
                                                @if (!$item->periodo && $item->dia==="lunes")
                                                    <div>
                                                        Cierra: <strong>{{$item->hora}}</strong>
                                                    </div>
                                                @endif
                                                @break
                                            @case(2)
                                                @if ($item->periodo && $item->dia==="martes")
                                                    <div>
                                                        Abre: <strong>{{$item->hora}}</strong>
                                                    </div>
                                                @endif
                                                @if (!$item->periodo && $item->dia==="martes")
                                                    <div>
                                                        Cierra: <strong>{{$item->hora}}</strong>
                                                    </div>
                                                @endif
                                                @break
                                            @case(3)
                                                @if ($item->periodo && $item->dia==="miercoles")
                                                    <div>
                                                        Abre: <strong>{{$item->hora}}</strong>
                                                    </div>
                                                @endif
                                                @if (!$item->periodo && $item->dia==="miercoles")
                                                    <div>
                                                        Cierra: <strong>{{$item->hora}}</strong>
                                                    </div>
                                                @endif
                                                @break
                                            @case(4)
                                                @if ($item->periodo && $item->dia==="jueves")
                                                    <div>
                                                        Abre: <strong>{{$item->hora}}</strong>
                                                    </div>
                                                @endif
                                                @if (!$item->periodo && $item->dia==="jueves")
                                                    <div>
                                                        Cierra: <strong>{{$item->hora}}</strong>
                                                    </div>
                                                @endif
                                                @break
                                            @case(5)
                                                @if ($item->periodo && $item->dia==="viernes")
                                                    <div>
                                                        Abre: <strong>{{$item->hora}}</strong>
                                                    </div>
                                                @endif
                                                @if (!$item->periodo && $item->dia==="viernes")
                                                    <div>
                                                        Cierra: <strong>{{$item->hora}}</strong>
                                                    </div>
                                                @endif
                                                @break
                                            @case(6)
                                                @if ($item->periodo && $item->dia==="sabado")
                                                    <div>
                                                        Abre: <strong>{{$item->hora}}</strong>
                                                    </div>
                                                @endif
                                                @if (!$item->periodo && $item->dia==="sabado")
                                                    <div>
                                                        Cierra: <strong>{{$item->hora}}</strong>
                                                    </div>
                                                @endif
                                                @break
                                            @case(7)
                                                @if ($item->periodo && $item->dia==="domingo")
                                                    <div>
                                                        Abre: <strong>{{$item->hora}}</strong>
                                                    </div>
                                                @endif
                                                @if (!$item->periodo && $item->dia==="domingo")
                                                    <div>
                                                        Cierra: <strong>{{$item->hora}}</strong>
                                                    </div>
                                                @endif
                                                @break
                                        @endswitch


                                @endforeach
                            </div>
                        </figcaption>
                    </figure>
                @endfor
            </div>

            <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-4">
                <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="dia" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Seleccione día</label>
                        <select wire:model.live="dia" id="dia" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                            <option >Elegir día...</option>
                            @foreach ($funcionamiento as $item)
                                @if ($item->periodo)
                                    <option value={{$item->dia}}>{{$item->dia}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div>
                        @if ($dia)
                            <label for="area_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Seleccione área</label>
                            <select wire:model.live="area_id" id="area_id" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                                <option >Elegir área...</option>
                                @foreach ($sede->areas as $item)
                                    <option value={{$item->id}}>{{$item->name}} </option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                    @if ($area_id)
                        <div>
                            <label for="hora" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Hora de inicio entre las: {{$abre}} y las {{$cierra}}
                            </label>
                            <input type="time" id="hora" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.live="hora">
                        </div>
                        <div>
                            <label for="intensidad" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Número de horas</label>
                            <input type="number" id="intensidad" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.live="intensidad">
                        </div>
                        <div>
                            @if ($intensidad && $hora)
                                <a href="" wire:click.prevent="cargar()" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                                    <i class="fa-solid fa-clock"></i> Cargar
                                </a>
                            @endif
                        </div>
                    @endif
                </div>

                @if ($dia && $area_id)
                    <div class=" bg-green-50 ring-2 ring-green-300">
                        <figure class="flex flex-col items-center p-4 text-center bg-white border-b border-gray-200 rounded-t-lg md:rounded-t-none md:rounded-ss-lg md:border-e dark:bg-gray-800 dark:border-gray-700">
                            <blockquote class="max-w-2xl mx-auto mb-2 text-gray-500 lg:mb-8 dark:text-gray-400">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    Grupos registrados: <span class="uppercase">{{$dia}} - {{$sede->name}}</span>
                                </h3>
                            </blockquote>
                            <figcaption class="flex items-center justify-center ">
                                <div class="space-y-0.5 font-medium dark:text-white text-left rtl:text-right ms-3 capitalize">
                                    @foreach ($ocupacion as $item)
                                        @if ($item->dia===$dia)
                                            <div>
                                                <strong>{{$item->hora}} - {{$item->area->name}}: {{$item->grupo}}</strong>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </figcaption>
                        </figure>
                    </div>
                @endif

            </div>

            @if (count($seleccionados)>0)
                <h1 class="text-lg font-extrabold capitalize text-center mt-4">
                    a continuación se muestran los horarios seleccionados, completando <span class="font-extrabold uppercase">{{$horas_semanales}} horas a la semana.</span>
                </h1>
                <div class="grid mb-8 border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 md:mb-12 sm:grid-cols-1 md:grid-cols-7 bg-white dark:bg-gray-800">
                    @for ($i = 1; $i <= 7; $i++)
                        <figure class="flex flex-col items-center p-4 text-center bg-white border-b border-gray-200 rounded-t-lg md:rounded-t-none md:rounded-ss-lg md:border-e dark:bg-gray-800 dark:border-gray-700">
                            <blockquote class="max-w-2xl mx-auto mb-2 text-gray-500 lg:mb-8 dark:text-gray-400">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white uppercase">
                                    @switch($i)
                                        @case(1)
                                            lunes
                                            @break
                                        @case(2)
                                            martes
                                            @break
                                        @case(3)
                                            miércoles
                                            @break
                                        @case(4)
                                            jueves
                                            @break
                                        @case(5)
                                            viernes
                                            @break
                                        @case(6)
                                            sábado
                                            @break
                                        @case(7)
                                            domingo
                                            @break
                                    @endswitch
                                </h3>
                            </blockquote>
                            <figcaption class="flex items-center justify-center ">
                                <div class="space-y-0.5 font-medium dark:text-white text-left rtl:text-right ms-3">
                                    @foreach ($seleccionados as $item)
                                            @switch($i)
                                                @case(1)
                                                    @if ($item['dia']==="lunes")
                                                        <div class="flex">
                                                            <strong>{{$item['area']}} - {{$item['hora']}}</strong>
                                                            <a href="" wire:click.prevent="elimHora({{$item['id']}})" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-1 py-1 text-center capitalize">
                                                                <i class="fa-solid fa-trash-can fa-bounce"></i>
                                                            </a>
                                                        </div>
                                                    @endif
                                                    @break
                                                @case(2)
                                                    @if ($item['dia']==="martes")
                                                        <div>
                                                            <strong>{{$item['area']}} - {{$item['hora']}}</strong>
                                                            <a href="" wire:click.prevent="elimHora({{$item['id']}})" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-1 py-1 text-center capitalize">
                                                                <i class="fa-solid fa-trash-can fa-bounce"></i>
                                                            </a>
                                                        </div>
                                                    @endif
                                                    @break
                                                @case(3)
                                                    @if ($item['dia']==="miercoles")
                                                        <div>
                                                            <strong>{{$item['area']}} - {{$item['hora']}}</strong>
                                                            <a href="" wire:click.prevent="elimHora({{$item['id']}})" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-1 py-1 text-center capitalize">
                                                                <i class="fa-solid fa-trash-can fa-bounce"></i>
                                                            </a>
                                                        </div>
                                                    @endif
                                                    @break
                                                @case(4)
                                                    @if ($item['dia']==="jueves")
                                                        <div>
                                                            <strong>{{$item['area']}} - {{$item['hora']}}</strong>
                                                            <a href="" wire:click.prevent="elimHora({{$item['id']}})" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-1 py-1 text-center capitalize">
                                                                <i class="fa-solid fa-trash-can fa-bounce"></i>
                                                            </a>
                                                        </div>
                                                    @endif
                                                    @break
                                                @case(5)
                                                    @if ($item['dia']==="viernes")
                                                        <div>
                                                            <strong>{{$item['area']}} - {{$item['hora']}}</strong>
                                                            <a href="" wire:click.prevent="elimHora({{$item['id']}})" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-1 py-1 text-center capitalize">
                                                                <i class="fa-solid fa-trash-can fa-bounce"></i>
                                                            </a>
                                                        </div>
                                                    @endif
                                                    @break
                                                @case(6)
                                                    @if ($item['dia']==="sabado")
                                                        <div>
                                                            <strong>{{$item['area']}} - {{$item['hora']}}</strong>
                                                            <a href="" wire:click.prevent="elimHora({{$item['id']}})" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-1 py-1 text-center capitalize">
                                                                <i class="fa-solid fa-trash-can fa-bounce"></i>
                                                            </a>
                                                        </div>
                                                    @endif
                                                    @break
                                                @case(7)
                                                    @if ($item['dia']==="domingo")
                                                        <div>
                                                            <strong>{{$item['area']}} - {{$item['hora']}}</strong>
                                                            <a href="" wire:click.prevent="elimHora({{$item['id']}})" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-1 py-1 text-center capitalize">
                                                                <i class="fa-solid fa-trash-can fa-bounce"></i>
                                                            </a>
                                                        </div>
                                                    @endif
                                                    @break
                                            @endswitch


                                    @endforeach
                                </div>
                            </figcaption>
                        </figure>
                    @endfor
                </div>
            @else
                <h1 class="text-lg font-extrabold capitalize text-center">
                    No se han cargado horarios para el grupo: <strong> {{$name}} </strong>
                </h1>
            @endif

        @endif
</div>
