<div>
    <form wire:submit.prevent="new">
        <div class="grid sm:grid-cols-1 md:grid-cols-3 gap-4 m-2">
            <div class="mb-6">
                <label for="inicia" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Inicia Vigencia</label>
                <input type="date" id="inicia" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500" placeholder="Primer pago" wire:model.blur="inicia" >
                @error('inicia')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
            <div class="mb-6">
                <label for="finaliza" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Finaliza Vigencia</label>
                <input type="date" id="finaliza" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500" placeholder="Primer pago" wire:model.blur="finaliza" >
                @error('finaliza')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
            <div class="mb-6">
                <label for="sector" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Ciudad donde Aplica</label>
                <select wire:model.live="sector_id" id="sector" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500 capitalize">
                    <option >Elija ciudad...</option>
                    @foreach ($ciudades as $item)
                        <option value={{$item->id}}>{{$item->name}}- Departamento: {{$item->state->name}}</option>
                    @endforeach
                </select>
                @error('sector_id')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
        </div>
        <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-4 m-2">
            <div>
                <div class="mb-6">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Seleccionar producto </label>
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
                                    {{$item->name}} <a href="" wire:click.prevent="selProduc({{$item}})" class="text-black bg-gradient-to-r from-green-300 via-green-400 to-green-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-700 font-medium rounded-lg text-sm px-5 text-center capitalize">
                                        <i class="fa-solid fa-check fa-beat"></i> elegir
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                @if ($producto_id>0)
                    <div>
                        <label for="precio" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white uppercase">Precio de venta para: <strong>{{$productoName}}</strong></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <i class="fa-solid fa-cash-register"></i>
                            </div>
                            <input
                                type="input"
                                class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-cyan-500 focus:border-cyan-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-cyan-500 dark:focus:border-cyan-500"
                                placeholder="Precio de venta"
                                wire:model="precio"
                                autocomplete="off"
                                >
                            <button type="button" class="text-black border border-solid absolute right-2.5 bottom-2.5 bg-cyan-400 hover:bg-cyan-500 focus:ring-4 focus:outline-none focus:ring-cyan-100 font-medium rounded-lg text-sm px-4 py-2 dark:bg-cyan-400 dark:hover:bg-cyan-500 dark:focus:ring-cyan-600" wire:click="carProduc()">
                                Cargar Producto
                            </button>
                        </div>
                    </div>

                @endif
            </div>
            <div>
                @if (count($elegidos)>0)
                    <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3" >
                                    Producto
                                </th>
                                <th scope="col" class="px-6 py-3" >
                                    Valor Unitario
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($elegidos as $otros)

                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200 text-sm">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                            {{$otros['name']}}
                                        </th>
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-right">
                                            $ {{number_format($otros['precio'], 0, ',', '.')}}
                                        </th>
                                        <th>
                                            <a href="#" wire:click.prevent="elimProduc({{$otros['id']}})"  class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm p-2 text-center mr-2 mb-2 capitalize">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </a>
                                        </th>
                                    </tr>

                            @endforeach
                        </tbody>
                    </table>
                @else

                @endif
            </div>
        </div>



        <div class="mb-6">
            <label for="descripcion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Descripción</label>
            <input type="text" id="descripcion" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500" placeholder="Descripción de la configuración" wire:model.blur="descripcion">
            @error('descripcion')
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                </div>
            @enderror
        </div>

        <div class="grid sm:grid-cols-1 md:grid-cols-5 gap-4 m">
            <button type="submit"
            class="text-white bg-green-500 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-green-400 dark:hover:bg-green-500 dark:focus:ring-green-400"
            >
                Nueva Configuración de Pago
            </button>
            <a href="#" wire:click.prevent="$dispatch('created')" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                <i class="fa-solid fa-rectangle-xmark"></i> cancelar
            </a>
        </div>
    </form>
</div>
