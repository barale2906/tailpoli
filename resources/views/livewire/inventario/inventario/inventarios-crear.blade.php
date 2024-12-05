<div>
    <form wire:submit.prevent="new">
        <div class="mb-6">
            <div class="w-full">
                <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Buscar Almacén</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>
                    <input
                        type="search"
                        id="buscar"
                        class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500" placeholder="Buscar almacén o Sede"
                        wire:model="buscar"
                        wire:keydown="buscAlmacen()"
                        autocomplete="off"
                        >
                    <button type="button" class="text-white absolute right-2.5 bottom-2.5 bg-green-400 hover:bg-green-500 focus:ring-4 focus:outline-none focus:ring-green-100 font-medium rounded-lg text-sm px-4 py-2 dark:bg-green-400 dark:hover:bg-green-500 dark:focus:ring-green-600" wire:click="limpiar()">
                        Limpiar Filtro
                    </button>
                </div>
            </div>
            @if ($buscar || $almacen_id>0)
                <ul class="max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400">
                    @foreach ($almacens as $item)
                        <li class="w-full mt-2 mb-2 capitalize">
                            {{$item->name}} - {{$item->sede->name}} <a href="#" wire:click.prevent="selAlmacen({{$item}})" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 text-center capitalize">
                                <i class="fa-solid fa-check fa-beat"></i> elegir
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
        @if ($almacen_id>0)
            <div class="mb-6">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Seleccionar producto para el almacén: <strong class="uppercase">{{$almaceName}}</strong> de la sede: <strong class="uppercase">{{$sedeName}}</strong> </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>
                    <input
                        type="search"
                        id="buscarProducto"
                        class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500" placeholder="Buscar producto"
                        wire:model="buscapro"
                        wire:keydown="buscaProducto()"
                        autocomplete="off"
                        >
                    <button type="button" class="text-white absolute right-2.5 bottom-2.5 bg-green-400 hover:bg-green-500 focus:ring-4 focus:outline-none focus:ring-green-100 font-medium rounded-lg text-sm px-4 py-2 dark:bg-green-400 dark:hover:bg-green-500 dark:focus:ring-green-600" wire:click="limpiarpro()">
                        Limpiar Filtro
                    </button>
                </div>
                @if ($buscapro || $producto_id>0)
                    <ul class="max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400">
                        @foreach ($productos as $item)
                            <li class="w-full mt-2 mb-2 capitalize">
                                {{$item->name}} <a href="#" wire:click.prevent="selProduc({{$item}})" class="text-black bg-gradient-to-r from-green-300 via-green-400 to-green-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-700 font-medium rounded-lg text-sm px-5 text-center capitalize">
                                    <i class="fa-solid fa-check fa-beat"></i> elegir
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        @endif
        @if ($producto_id>0)

            <div id="toast-interactive" class="w-full p-4 text-gray-500 bg-gray-100 rounded-lg shadow dark:bg-gray-800 dark:text-gray-400" role="alert">
                <div class="flex">
                    <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:text-green-300 dark:bg-green-900">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 1v5h-5M2 19v-5h5m10-4a8 8 0 0 1-14.947 3.97M1 10a8 8 0 0 1 14.947-3.97"/>
                        </svg>
                        <span class="sr-only">Refresh icon</span>
                    </div>
                    <div class="ml-3 text-sm font-normal">
                        @if ($ultimoregistro)
                            <span class="mb-1 text-xl font-semibold text-gray-900 dark:text-white capitalize">
                                último movimiento para <strong class="uppercase">{{$productoName}}</strong> en el almacén <strong class="uppercase">{{$almaceName}}</strong> de la sede <strong class="uppercase">{{$sedeName}}</strong>
                            </span>
                            <div class="mb-2 text-sm font-normal">Datos del último registro.</div>
                            <div class="grid grid-cols-3 gap-3">
                                <div>
                                    <ul role="list" class="space-y-5 my-7">
                                        <li class="flex space-x-3 items-center">
                                            <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400">Fecha Movimiento: </span>
                                            <span class="bg-green-200 text-black text-lg font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">{{$ultimoregistro->fecha_movimiento}}</span>
                                        </li>
                                        <li class="flex space-x-3 items-center">
                                            <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400">Tipo Movimiento: </span>
                                            <span class="bg-green-200 text-black text-lg font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-600">{{$statusInventipo[$ultimoregistro->tipo]}}</span>
                                        </li>
                                    </ul>
                                </div>
                                <div>
                                    <ul role="list" class="space-y-5 my-7">
                                        <li class="flex space-x-3 items-center">
                                            <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400">Cantidad: </span>
                                            <span class="bg-green-200 text-black text-lg font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">{{$ultimoregistro->cantidad}}</span>
                                        </li>
                                        <li class="flex space-x-3 items-center">
                                            <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400">Saldo: </span>
                                            <span class="bg-green-200 text-black text-lg font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-600">{{$ultimoregistro->saldo }}</span>
                                        </li>
                                        <li class="flex space-x-3 items-center">
                                            <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400">Precio: </span>
                                            <span class="bg-green-200 text-black text-lg font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-600">$ {{ number_format($ultimoregistro->precio, 0, '.', ' ')}}</span>
                                        </li>
                                    </ul>
                                </div>
                                <div>
                                    <ul role="list" class="space-y-5 my-7">
                                        <li class="flex space-x-3 items-center">
                                            <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400">Descripción: </span>
                                            <span class="bg-cyan-200 text-black text-lg font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">{{$ultimoregistro->descripcion}}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        @else
                            <span class="mb-1 text-sm font-semibold text-gray-900 dark:text-white capitalize">
                                ¡NO TIENE MOVIMIENTOS! El producto: <strong class="uppercase">{{$productoName}}</strong> en el almacén: <strong class="uppercase">{{$almaceName}}</strong> de la sede: <strong class="uppercase">{{$sedeName}}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>


            <div class="grid grid-cols-3 gap-3 bg-slate-300 m-3 p-3">
                @if ($tipo!==0)
                    <div>
                        <div class="mb-6">
                            <label for="fecha_movimiento" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha de movimiento:</strong></label>
                            <input type="date" id="fecha_movimiento" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500" placeholder="Nombre" wire:model.blur="fecha_movimiento">
                        </div>
                        @error('fecha_movimiento')
                            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                            </div>
                        @enderror
                    </div>
                @endif
                <div>
                    <div class="mb-6">
                        <label for="cantidad" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cantidad de productos</label>
                        <input type="text" id="cantidad" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500" placeholder="Cantidad" wire:model.blur="cantidad">
                    </div>
                    @error('cantidad')
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                            <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                        </div>
                    @enderror
                </div>
                <div>
                    <div class="mb-6">
                        <label for="precio" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Precio</label>
                        <input type="text" id="precio" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500" placeholder="Precio de la transacción" wire:model.blur="precio">
                    </div>
                    @error('precio')
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                            <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                        </div>
                    @enderror
                </div>
                <div>
                    @if ($cantidad>0)
                    <label for="precio" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cargar</label>
                        <a href="#" wire:click.prevent="temporal()"  class="text-black bg-gradient-to-r from-green-300 via-green-400 to-green-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-700 font-medium rounded-lg text-sm p-2 text-center mr-2 mb-2 capitalize">
                            <i class="fa-solid fa-check"></i>
                        </a>
                    @endif
                </div>

            </div>

            <div class="mb-6">
                <label for="descripcion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripción</label>
                <input type="text" id="descripcion" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500" placeholder="Datos relevantes" wire:model.blur="descripcion">
            </div>
            @error('descripcion')
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                </div>
            @enderror


        @endif

        @if ($tipo!==0)
            <button type="submit"
            class="text-white bg-green-500 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-green-400 dark:hover:bg-green-500 dark:focus:ring-green-400"
            >
                Nuevo Registro
            </button>
            <a href="#" wire:click.prevent="$dispatch('cancelando')" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                <i class="fa-solid fa-rectangle-xmark"></i> cancelar
            </a>
        @endif
    </form>
</div>
