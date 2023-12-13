<div>
    <div class="grid sm:grid-cols-1 md:grid-cols-3 gap-4 m-2">
        <div class="mb-6">
            <label for="profesor_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Profesor:</label>
            <select wire:model.live="profesor_id" id="profesor_id" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                <option >Elija Profesor...</option>
                @foreach ($profesores as $item)
                    <option value={{$item->id}}>{{$item->name}}</option>
                @endforeach
            </select>
        </div>
        @if ($profesor_id>0)
            <div class="mb-6">
                <label for="grupo_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Grupo:</label>
                <select wire:model.live="grupo_id" id="grupo_id" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                    <option >Elija Grupo...</option>
                    @foreach ($grupos as $item)
                        <option value={{$item->id}}>{{$item->name}}</option>
                    @endforeach
                </select>
            </div>
        @endif
        @if ($grupo_id>0)
            @if ($esquemas->count()>0)

                <div class="mb-6">
                    <label for="notas" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Elija esquema de notas:</label>
                    <select wire:model.live="notas" id="notas" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                        <option >Elija esquema...</option>
                        @foreach ($esquemas as $item)
                            <option value={{$item->id}}>{{$item->descripcion}}</option>
                        @endforeach
                    </select>
                </div>
            @else
                <div class="sm:col-span-1 md:col-span-3 text-center">
                    <h1 class="font-semibold mb-2">
                        No existe esquema de calificaciones para este grupo por parte del profesor elegido, debe generarlo primero.
                    </h1>
                    <a href="{{route('academico.notas')}}"  class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mt-2 capitalize">
                        <i class="fa-solid fa-upload"></i> Generar Esquema
                    </a>
                </div>
            @endif

        @endif



    </div>
    @if ($notas)
        <livewire:academico.nota.notas-editar :elegido="$notas" :cargar="1"/>
    @endif
    <div class="grid sm:grid-cols-1 md:grid-cols-3 gap-4 m-2">
        @if ($notas)
            <div class="mb-6">
                <label for="calificaciones" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cargar calificaciones</label>
                <input type="file" id="calificaciones" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.live="calificaciones">
            </div>
        @endif
        @if ($calificaciones)
            <a href="#" wire:click.prevent="guardar" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                <i class="fa-solid fa-upload"></i> Cargar Encabezado
            </a>
        @endif
    </div>

</div>
