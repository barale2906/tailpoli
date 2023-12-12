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
            <div class="mb-6">
                <label for="registros" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Numero de notas</label>
                <input type="number" id="registros" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nombre" wire:model.live="registros">
            </div>
        @endif
        @if ($registros)
            <div class="mb-6">
                <label for="encabezado" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cargar encabezado del listado</label>
                <input type="file" id="encabezado" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nombre" wire:model.live="encabezado">
            </div>
        @endif

        @if ($encabezado)
            <a href="#" wire:click.prevent="guardar" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                <i class="fa-solid fa-upload"></i> Cargar Encabezado
            </a>
        @endif
    </div>
</div>
