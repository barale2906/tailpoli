<div>
    <div class="mb-6">
        <div class="w-full">
            <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Buscar Usuario</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input
                    type="search"
                    id="buscar"
                    class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="digite nombre o documento del usuario"
                    wire:model="buscar"
                    wire:keydown="buscAlumno()"
                    autocomplete="off"
                    >
                <button type="button" class="text-white absolute right-2.5 bottom-2.5 bg-blue-400 hover:bg-blue-500 focus:ring-4 focus:outline-none focus:ring-blue-100 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-400 dark:hover:bg-blue-500 dark:focus:ring-blue-600" wire:click="limpiar()">
                    Limpiar Filtro
                </button>
            </div>
        </div>
        @if ($buscar)
            <ul class="max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400">
                @foreach ($usuarios as $item)
                    <li class="w-full mt-2 mb-2 capitalize">
                        {{$item->name}} - {{$item->documento}}
                        <a href="#" wire:click.prevent="selAlumno({{$item}})" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 text-center capitalize">
                            <i class="fa-solid fa-check fa-beat"></i> elegir
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
    @if ($user)
        <h1 class="text-lg font-medium text-center mb-5">
            A continuación se presentan los permisos con que cuenta <span class="font-extrabold uppercase text-center text-lg">{{$user->name}}</span>
        </h1>
        <div class="grid sm:grid-cols-1 md:grid-cols-6 gap-4">
            @foreach ($listaPermisos as $item)
                <div class="flex items-center mb-4 capitalize">
                    <input id="default-checkbox" wire:model="permis" type="checkbox" value="{{$item->id}}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 " >
                    <label for="default-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                        {{$item->descripcion}}
                    </label>
                </div>
            @endforeach
        </div>
        <a href="#" wire:click.prevent="actualizar" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
            <i class="fa-solid fa-arrows-rotate"></i> actualizar
        </a>
    @endif

</div>
