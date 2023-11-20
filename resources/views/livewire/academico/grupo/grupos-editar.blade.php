<div>
    <form wire:submit.prevent="edit">
        <div class="mb-6">
            <label for="modulo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Modulo</label>
            <select wire:model.blur="modulo_id" id="modulo" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                @foreach ($modulos as $item)
                    <option value={{$item->id}}>modulo: {{$item->name}} - CURSO: {{$item->curso->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-6">
            <label for="sede" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sede</label>
            <select wire:model.blur="sede_id" id="sede" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                @foreach ($sedes as $item)
                    <option value={{$item->id}}>Sede: {{$item->name}} - Ciudad: {{$item->sector->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-6">
            <label for="profesor" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Profesor</label>
            <select wire:model.blur="profesor_id" id="profesor" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                @foreach ($profesores as $item)
                    <option value={{$item->id}}>{{$item->name}} </option>
                @endforeach
            </select>
        </div>

        <div class="mb-6">
            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre del Grupo</label>
            <input type="text" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nombre" wire:model.blur="name">
        </div>
        @error('name')
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
            </div>
        @enderror

        <div class="grid grid-cols-3 gap-4">
            {{-- <div>
                <div class="mb-6">
                    <label for="start_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha de Inicio</label>
                    <input type="date" id="start_date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"  wire:model.blur="start_date">
                </div>
                @error('start_date')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
            <div>
                <div class="mb-6">
                    <label for="finish_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha de Finalización</label>
                    <input type="date" id="finish_date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"  wire:model.blur="finish_date">
                </div>
                @error('finish_date')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div> --}}
            <div>
                <div class="mb-6">
                    <label for="quantity_limit" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Límite de Estudiantes</label>
                    <input type="text" id="quantity_limit" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="cantidad" wire:model.blur="quantity_limit">
                </div>
                @error('quantity_limit')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
        </div>


        <button type="submit"
        class="text-white bg-blue-500 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-400 dark:hover:bg-blue-500 dark:focus:ring-blue-400"
        >
            Editar Producto
        </button>

        <a href="#" wire:click.prevent="$dispatch('Editando')" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
            <i class="fa-solid fa-rectangle-xmark"></i> cancelar
        </a>
    </form>
</div>
