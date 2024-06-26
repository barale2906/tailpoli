<div>
    <h1 class="t text-center text-lg font-bold mb-2">
        Esta seguro(a) de reutilizar la programación: <strong>{{$actual->name}}</strong>
    </h1>
    <div class="grid sm:grid-cols-1 md:grid-cols-6 gap-4">

        <div class="mb-6">
            <label for="inicio" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha de Inicio:</label>
            <input type="date" id="inicio" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"  wire:model.live="inicio">
            @error('inicio')
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                </div>
            @enderror
        </div>
        @if ($modulos)
            <div class="mb-6 col-span-3">
                <label for="inicio" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Grupos Asignados:</label>
                <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3" >
                                Orden secuencial <span class=" text-xs">(Conserva la secuencia actual)</span>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Orden Actual
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Grupo
                            </th>
                            <th scope="col" class="px-6 py-3" >
                                Orden discrecional <span class=" text-xs">(Asigna nuevo orden)</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($modulos as $item)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    <div class="flex">
                                        <input id="orden" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"  wire:model.live="orden">
                                        <a href="" wire:click.prevent="ordenar({{$item->id}},{{$item->valor}})" class=" bg-gradient-to-r from-green-300 via-green-400 to-green-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-700 font-medium rounded-lg text-sm p-1 text-center mr-2 mb-2 capitalize">
                                            <i class="fa-solid fa-sort"></i>
                                        </a>
                                    </div>

                                </th>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white text-center">
                                    {{$item->valor}}
                                </th>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                    {{$item->producto}}
                                </th>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    <div class="flex">
                                        @if ($item->id_almacen)
                                            <span class="mr-2">
                                                {{$item->id_almacen}}
                                            </span>
                                        @endif
                                        <input id="orden" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"  wire:model.live="orden">
                                        <a href="" wire:click.prevent="ordendiscre({{$item->id}})" class=" bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm p-1 text-center mr-2 mb-2 capitalize">
                                            <i class="fa-solid fa-triangle-exclamation"></i>
                                        </a>
                                    </div>

                                </th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        @if ($inicio && $is_discre)

            <div class="mb-6">
                <a href="" wire:click.prevent="reutilizar()" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                    <i class="fa-solid fa-rectangle-xmark"></i> Reutilizar
                </a>
            </div>
        @endif

        <div class="mb-6">
            <a href="" wire:click.prevent="$dispatch('cancelando')" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                <i class="fa-solid fa-rectangle-xmark"></i> cancelar
            </a>
        </div>

    </div>
</div>
