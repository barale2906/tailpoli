<div>
    <div class="bg-blue-200 rounded-lg align-middle p-5 mb-2 text-center">
        <h1 class="text-xl uppercase mb-3">Productos Pendientes por entregar</h1>
        @can('in_export')
            <a href="#" wire:click.prevent="exportar" class="w-auto text-teal-800 bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300 dark:focus:ring-teal-800 font-medium rounded-lg text-2xl px-5 py-2.5 text-center mr-2 mb-3 mt-2 capitalize" >
                <i class="fa-solid fa-file-excel fa-beat"></i>
            </a>
        @endcan
    </div>
    <div class="relative overflow-x-auto">

        <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('fecha_movimiento')">
                        Fecha
                        @if ($ordena != 'fecha_movimiento')
                            <i class="fas fa-sort"></i>
                        @else
                            @if ($ordenado=='ASC')
                                <i class="fas fa-sort-up"></i>
                            @else
                                <i class="fas fa-sort-down"></i>
                            @endif
                        @endif
                    </th>
                    <th scope="col" class="px-6 py-3" >
                        Ciudad
                    </th>
                    <th scope="col" class="px-6 py-3" >
                        Sede
                    </th>
                    <th scope="col" class="px-6 py-3" >
                        Almacen
                    </th>
                    <th scope="col" class="px-6 py-3" >
                        Producto
                    </th>
                    <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('cantidad')">
                        Cantidad
                        @if ($ordena != 'cantidad')
                            <i class="fas fa-sort"></i>
                        @else
                            @if ($ordenado=='ASC')
                                <i class="fas fa-sort-up"></i>
                            @else
                                <i class="fas fa-sort-down"></i>
                            @endif
                        @endif
                    </th>
                    <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('precio')">
                        Precio Venta
                        @if ($ordena != 'precio')
                            <i class="fas fa-sort"></i>
                        @else
                            @if ($ordenado=='ASC')
                                <i class="fas fa-sort-up"></i>
                            @else
                                <i class="fas fa-sort-down"></i>
                            @endif
                        @endif
                    </th>
                    <th scope="col" class="px-6 py-3" >
                        Alumno
                    </th>
                    <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('descripcion')">
                        Descripción
                        @if ($ordena != 'descripcion')
                            <i class="fas fa-sort"></i>
                        @else
                            @if ($ordenado=='ASC')
                                <i class="fas fa-sort-up"></i>
                            @else
                                <i class="fas fa-sort-down"></i>
                            @endif
                        @endif
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pendInventarios as $pendInventario)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200 text-sm">

                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                            {{$pendInventario->fecha_movimiento}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                            {{$pendInventario->almacen->sede->sector->name}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                            {{$pendInventario->almacen->sede->name}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                            {{$pendInventario->almacen->name}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                            {{$pendInventario->producto->name}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white  text-right">
                            {{$pendInventario->cantidad}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-right">
                            $ {{number_format($pendInventario->precio, 0, '.', ' ')}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                            {{$pendInventario->name}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                            {{$pendInventario->descripcion}}
                        </th>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-2 p-1 w-auto rounded-lg grid grid-cols-2 gap-4 bg-blue-100">
            <div>
                <label class="relative inline-flex items-center mb-4 cursor-pointer">
                    <span class="ml-3 mr-3 text-sm font-medium text-gray-900 dark:text-gray-300">Registros:</span>
                    <select wire:click="paginas($event.target.value)" id="countries" class="w-20 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value=15>15</option>
                        <option value=20>20</option>
                        <option value=50>50</option>
                        <option value=100>100</option>
                    </select>
                </label>
            </div>
            <div>
                {{ $pendInventarios->links() }}
            </div>
        </div>
    </div>
</div>
