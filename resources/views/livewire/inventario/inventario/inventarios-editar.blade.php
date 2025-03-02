<div>
    <form wire:submit.prevent="edit">
        <div id="toast-interactive" class="w-full p-4 text-gray-500 bg-gray-100 rounded-lg shadow dark:bg-gray-800 dark:text-gray-400" role="alert">
            <div class="flex">
                <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:text-green-300 dark:bg-green-900">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 1v5h-5M2 19v-5h5m10-4a8 8 0 0 1-14.947 3.97M1 10a8 8 0 0 1 14.947-3.97"/>
                    </svg>
                    <span class="sr-only">Refresh icon</span>
                </div>
                <div class="ml-3 text-sm font-normal">
                    <div class="mb-2 text-2xl font-normal uppercase text-red-600">Datos del registro a anular.</div>
                    <span class="mb-1 text-xl font-semibold text-gray-900 dark:text-white capitalize">
                        Datos de:  <strong class="uppercase">{{$productoName}}</strong> en el almacén <strong class="uppercase">{{$almaceName}}</strong> de la sede <strong class="uppercase">{{$sedeName}}</strong>
                    </span>
                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <ul role="list" class="space-y-5 my-7">
                                <li class="flex space-x-3 items-center">
                                    <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400">Fecha Movimiento: </span>
                                    <span class="bg-green-200 text-black text-lg font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">{{$fecha_movimiento}}</span>
                                </li>
                                <li class="flex space-x-3 items-center">
                                    <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400">Tipo Movimiento: </span>
                                    <span class="bg-green-200 text-black text-lg font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-600">{{$statusInventipo[$tipo]}}</span>
                                </li>
                            </ul>
                        </div>
                        <div>
                            <ul role="list" class="space-y-5 my-7">
                                <li class="flex space-x-3 items-center">
                                    <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400">Cantidad: </span>
                                    <span class="bg-green-200 text-black text-lg font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">{{$cantidad}}</span>
                                </li>
                                <li class="flex space-x-3 items-center">
                                    <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400">Saldo: </span>
                                    <span class="bg-green-200 text-black text-lg font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-600">{{$saldo }}</span>
                                </li>
                                <li class="flex space-x-3 items-center">
                                    <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400">Precio: </span>
                                    <span class="bg-green-200 text-black text-lg font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-600">$ {{ $precio ? number_format($precio, 0, '.', ' '): ""}}</span>
                                </li>
                            </ul>
                        </div>
                        <div>
                            <ul role="list" class="space-y-5 my-7">
                                <li class="flex space-x-3 items-center">
                                    <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400">Descripción: </span>
                                    <span class="bg-cyan-200 text-black text-lg font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">{{$descripcion}}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-6">
            <label for="motivo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Motivo de la anulación: </label>
            <input type="text" id="motivo" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500" placeholder="motivo" wire:model.blur="motivo">
        </div>
        @error('motivo')
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
            </div>
        @enderror

        <button type="submit"
        class="text-white bg-orange-500 hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-orange-400 dark:hover:bg-orange-500 dark:focus:ring-orange-400"
        >
            Anular Movimiento
        </button>
        <a href="#" wire:click.prevent="$dispatch('cancelando')" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
            <i class="fa-solid fa-rectangle-xmark"></i> cancelar
        </a>
    </form>
</div>
