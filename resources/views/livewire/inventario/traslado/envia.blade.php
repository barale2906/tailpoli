<div>

    <div class="text-center">
        <div class="inline-flex rounded-md shadow-sm" role="group">
            <button type="button" wire:click="objetivo(1)" class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-cyan-200 rounded-s-lg hover:bg-cyan-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-cyan-700 dark:border-cyan-600 dark:text-white dark:hover:text-white dark:hover:bg-cyan-600 dark:focus:ring-blue-500 dark:focus:text-white uppercase">
                Enviar
            </button>
            <button type="button" wire:click="objetivo(2)" class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-green-200 rounded-e-lg hover:bg-green-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-green-700 dark:border-green-600 dark:text-white dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-500 dark:focus:text-white uppercase">
                Recibir
            </button>
        </div>
    </div>


    @switch($accion)
        @case(1)
            <div>
                <h1 class="text-center">
                    Va a realizar una traslado desde el almacén:
                    <span class="text-xl font-bold capitalize">{{$almacen->name}}</span> de la sede:
                    <span class="text-xl font-bold capitalize">{{$sede->name}}</span>
                </h1>

                <div class="grid sm:grid-cols-1 md:grid-cols-3 gap-4 m-2">
                    <div class="mb-6">
                        <label for="desede" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Escoja la sede de destino</label>
                        <select wire:model.live="desede" id="desede" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500 capitalize">
                            <option >Elija sede...</option>
                            @foreach ($sedes as $item)
                                    <option value={{$item->id}}>{{$item->name}}</option>
                            @endforeach
                        </select>
                        @error('desede')
                            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                            </div>
                        @enderror
                    </div>
                    @if ($almacenes)
                        <div class="mb-6">
                            <label for="dealma" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Escoja almacén de destino</label>
                            <select wire:model.live="dealma" id="dealma" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500 capitalize">
                                <option >Elija almacén...</option>
                                @foreach ($almacenes as $item)
                                    @if ($item->id!==$almacen->id)
                                        <option value={{$item->id}}>{{$item->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('dealma')
                                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                    <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                                </div>
                            @enderror
                        </div>
                    @endif
                    @if ($dealma)
                        <div class="mb-6 col-span-2">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Seleccionar producto para el almacén: <strong class="uppercase">{{$almacen->name}}</strong> de la sede: <strong class="uppercase">{{$almacen->sede->name}}</strong> </label>
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
                                            {{$item->name}} <a href="" wire:click.prevent="selProduc({{$item->id}})" class="text-black bg-gradient-to-r from-green-300 via-green-400 to-green-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-700 font-medium rounded-lg text-sm px-5 text-center capitalize">
                                                <i class="fa-solid fa-check fa-beat"></i> elegir
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    @endif
                </div>
                @if ($producto)
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
                                        último movimiento para <strong class="uppercase">{{$producto->name}}</strong> en el almacén <strong class="uppercase">{{$almacen->name}}</strong> de la sede <strong class="uppercase">{{$almacen->sede->name}}</strong>
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
                                                    <span class="bg-green-200 text-black text-lg font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-600">{{$ultimoregistro->tipo===1 ? "ENTRADA" : "SALIDA" }}</span>
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
                                        ¡NO TIENE MOVIMIENTOS! El producto: <strong class="uppercase">{{$producto->name}}</strong> en el almacén: <strong class="uppercase">{{$almacen->name}}</strong> de la sede: <strong class="uppercase">{{$almacen->sede->name}}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-2 gap-3 bg-slate-300 m-3 p-3">
                    @if ($saldo>0)
                        <div class="grid grid-cols-4 gap-3 m-1 p-1">

                            <div class="mb-6">
                                <label for="cantidad" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cantidad de productos</label>
                                <input type="text" id="cantidad" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500" placeholder="Cantidad" wire:model.live="cantidad">
                                @error('cantidad')
                                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                                    </div>
                                @enderror
                            </div>
                            <div>
                                @if ($cantidad>0 && $producto )
                                <label for="temporal" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cargar</label>
                                    <a href="#" wire:click.prevent="temporal()"  class="text-black bg-gradient-to-r from-green-300 via-green-400 to-green-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-700 font-medium rounded-lg text-sm p-2 text-center mr-2 mb-2 capitalize">
                                        <i class="fa-solid fa-check"></i>
                                    </a>
                                @endif
                            </div>

                        </div>
                    @endif
                    @if ($movimientos)
                        <div class="ring-2 bg-gray-50 p-2">
                            <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3" >
                                            Producto
                                        </th>
                                        <th scope="col" class="px-6 py-3" >
                                            Cantidad
                                        </th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($movimientos as $otros)

                                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200 text-sm">
                                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                                    {{$otros->producto}}
                                                </th>
                                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-center">
                                                    {{$otros->cantidad}}
                                                </th>
                                                <th>
                                                    <a href="#" wire:click.prevent="elimOtro({{$otros->id}})"  class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm p-2 text-center mr-2 mb-2 capitalize">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </a>
                                                </th>
                                            </tr>

                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

                <div class="mb-6">
                    <label for="observaciones" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripción</label>
                    <input type="text" id="observaciones" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500" placeholder="Datos relevantes" wire:model.live="observaciones">
                    @error('observaciones')
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                            <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                        </div>
                    @enderror
                </div>


                <div class="grid sm:grid-cols-1 md:grid-cols-4 gap-4 m-2">
                    @if ($movimientos && $observaciones)
                        <a href="" wire:click.prevent="traslado()" class="text-black bg-gradient-to-r from-green-300 via-green-400 to-green-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                            <i class="fa-solid fa-upload"></i> Generar traslado
                        </a>
                    @endif
                    <a href="" wire:click.prevent="$dispatch('cancelando')" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                        <i class="fa-solid fa-rectangle-xmark"></i> cancelar
                    </a>
                </div>
            </div>
            @break
        @case(2)
            <livewire:inventario.traslado.recep :almacen_id="$almacen_id"  />
            @break
    @endswitch
</div>
