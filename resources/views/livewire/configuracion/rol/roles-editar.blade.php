<div>
    <form wire:submit.prevent="edit">
        <div class="mb-6">
            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre del Rol</label>
            <input type="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nombre" wire:model.blur="name">
        </div>
        @error('name')
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
            </div>
        @enderror

        <div class="p-4 mb-4 text-sm text-cyan-900 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-cyan-500" role="alert">
            <span class="font-medium">MODULO ACÁDEMICO</span>
            <div class="grid grid-cols-6 gap-2">
                @foreach ($permisosac as $item)
                    <div class="flex items-center mb-4 capitalize">
                        <input id="default-checkbox" wire:model="permis" type="checkbox" value="{{$item->id}}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 " >
                        <label for="default-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                            {{$item->descripcion}}
                        </label>
                    </div>
                @endforeach
                @error('permis')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
        </div>

        <div class="p-4 mb-4 text-sm text-cyan-900 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-cyan-500" role="alert">
            <span class="font-medium">MODULO CARTERA</span>
            <div class="grid grid-cols-6 gap-2">
                @foreach ($permisosca as $item)
                    <div class="flex items-center mb-4 capitalize">
                        <input id="default-checkbox" wire:model="permis" type="checkbox" value="{{$item->id}}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 " >
                        <label for="default-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                            {{$item->descripcion}}
                        </label>
                    </div>
                @endforeach
                @error('permis')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
        </div>

        <div class="p-4 mb-4 text-sm text-cyan-900 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-cyan-500" role="alert">
            <span class="font-medium">MODULO FINANCIERA</span>
            <div class="grid grid-cols-6 gap-2">
                @foreach ($permisosfi as $item)
                    <div class="flex items-center mb-4 capitalize">
                        <input id="default-checkbox" wire:model="permis" type="checkbox" value="{{$item->id}}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 " >
                        <label for="default-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                            {{$item->descripcion}}
                        </label>
                    </div>
                @endforeach
                @error('permis')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
        </div>

        <div class="p-4 mb-4 text-sm text-cyan-900 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-cyan-500" role="alert">
            <span class="font-medium">MODULO INVENTARIO</span>
            <div class="grid grid-cols-6 gap-2">
                @foreach ($permisosin as $item)
                    <div class="flex items-center mb-4 capitalize">
                        <input id="default-checkbox" wire:model="permis" type="checkbox" value="{{$item->id}}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 " >
                        <label for="default-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                            {{$item->descripcion}}
                        </label>
                    </div>
                @endforeach
                @error('permis')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
        </div>

        <div class="p-4 mb-4 text-sm text-cyan-900 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-cyan-500" role="alert">
            <span class="font-medium">MODULO REPORTES</span>
            <div class="grid grid-cols-6 gap-2">
                @foreach ($permisosre as $item)
                    <div class="flex items-center mb-4 capitalize">
                        <input id="default-checkbox" wire:model="permis" type="checkbox" value="{{$item->id}}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 " >
                        <label for="default-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                            {{$item->descripcion}}
                        </label>
                    </div>
                @endforeach
                @error('permis')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
        </div>

        <div class="p-4 mb-4 text-sm text-cyan-900 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-cyan-500" role="alert">
            <span class="font-medium">MODULO ADMINISTRACIÓN</span>
            <div class="grid grid-cols-6 gap-2">
                @foreach ($permisosad as $item)
                    <div class="flex items-center mb-4 capitalize">
                        <input id="default-checkbox" wire:model="permis" type="checkbox" value="{{$item->id}}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 " >
                        <label for="default-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                            {{$item->descripcion}}
                        </label>
                    </div>
                @endforeach
                @error('permis')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
        </div>

        <div class="p-4 mb-4 text-sm text-cyan-900 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-cyan-500" role="alert">
            <span class="font-medium">MODULO ARCHIVO</span>
            <div class="grid grid-cols-6 gap-2">
                @foreach ($permisosar as $item)
                    <div class="flex items-center mb-4 capitalize">
                        <input id="default-checkbox" wire:model="permis" type="checkbox" value="{{$item->id}}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 " >
                        <label for="default-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                            {{$item->descripcion}}
                        </label>
                    </div>
                @endforeach
                @error('permis')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
        </div>

        <div class="p-4 mb-4 text-sm text-cyan-900 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-cyan-500" role="alert">
            <span class="font-medium">MODULO CONFIGURACIÓN</span>
            <div class="grid grid-cols-6 gap-2">
                @foreach ($permisosco as $item)
                    <div class="flex items-center mb-4 capitalize">
                        <input id="default-checkbox" wire:model="permis" type="checkbox" value="{{$item->id}}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 " >
                        <label for="default-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                            {{$item->descripcion}}
                        </label>
                    </div>
                @endforeach
                @error('permis')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
        </div>

        <button type="submit"
        class="text-white bg-blue-500 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-400 dark:hover:bg-blue-500 dark:focus:ring-blue-400"
        >
            Editar Rol
        </button>
        <a href="#" wire:click.prevent="$dispatch('Editando')" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
            <i class="fa-solid fa-rectangle-xmark"></i> cancelar
        </a>
    </form>
</div>
