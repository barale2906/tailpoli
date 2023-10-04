<div>
    <form wire:submit.prevent="edit">
        <div id="toast-interactive" class="w-full p-4 text-gray-500 bg-gray-100 rounded-lg shadow dark:bg-gray-800 dark:text-gray-400" role="alert">
            <div class="flex">
                <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-blue-500 bg-blue-100 rounded-lg dark:text-blue-300 dark:bg-blue-900">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 1v5h-5M2 19v-5h5m10-4a8 8 0 0 1-14.947 3.97M1 10a8 8 0 0 1 14.947-3.97"/>
                    </svg>
                    <span class="sr-only">Refresh icon</span>
                </div>
                <div class="ml-3 text-sm font-normal">
                    <div class="mb-2 text-2xl font-normal uppercase text-red-600">Datos del recibo a anular.</div>
                    <span class="mb-1 text-xl font-semibold text-gray-900 dark:text-white capitalize">
                        Datos del recibo de pago N°:  <strong class="uppercase">{{$id}}</strong> por: <strong class="uppercase">$ {{number_format($reciboActual->valor_total, 0, ',', '.')}}<br>
                        </strong> a nombre de: <strong class="uppercase">{{$reciboActual->paga->name}}</strong> generado en la sede <strong class="uppercase">{{$reciboActual->sede->name}}</strong><br>
                        generado por: <strong class="uppercase">{{$reciboActual->creador->name}}</strong>
                    </span>
                    <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3" >
                                    CONCEPTO
                                </th>
                                <th scope="col" class="px-6 py-3" >
                                    TIPO
                                </th>
                                <th scope="col" class="px-6 py-3" >
                                    VALOR
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($detalles as $recibo)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200 text-sm">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                        {{$recibo->name}}
                                    </th>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                        {{$recibo->tipo}}
                                    </th>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-right">
                                        $ {{number_format($recibo->valor, 0, ',', '.')}}
                                    </th>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mb-6">
            <label for="motivo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Motivo de la anulación: </label>
            <input type="text" id="motivo" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="motivo" wire:model.blur="motivo">
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
        <a href="#" wire:click.prevent="$dispatch('Editando')" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
            <i class="fa-solid fa-rectangle-xmark"></i> cancelar
        </a>
    </form>
</div>
