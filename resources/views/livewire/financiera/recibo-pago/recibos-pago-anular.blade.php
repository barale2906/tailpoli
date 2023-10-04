<div>
    <form wire:submit.prevent="edit">

        <section class="bg-cyan-50 dark:bg-gray-900">
            <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 grid lg:grid-cols-2 gap-2 lg:gap-2">
                <div class="flex flex-col justify-center">
                    <h1 class="mb-4 text-xl font-extrabold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-6xl dark:text-white">
                        Datos del recibo N°: {{$id}}
                    </h1>
                    <h2 class="md:text-2xl font-bold text-gray-900 dark:text-white">
                        A nombre de: {{$reciboActual->paga->name}}
                    </h2>
                    <p class="mb-6 md:text-lg font-normal text-gray-500 lg:text-xl dark:text-gray-400">
                        Observaciones: {{$reciboActual->observaciones}}
                    </p>
                    @if ($accion===2)
                        <a href="#" wire:click.prevent="$dispatch('Editando')" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                            <i class="fa-solid fa-backward-fast fa-beat"></i> Volver
                        </a>
                    @endif
                </div>
                <div>
                    <div class="w-full lg:max-w-xl p-6 space-y-8 sm:p-8 bg-white rounded-lg shadow-xl dark:bg-gray-800">

                        <div class="sm:grid-cols-1 md:grid-cols-2 gap-2">
                            <div>
                                <label for="fecha" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha:</label>
                                <h2 class="md:text-xl font-bold text-gray-900 dark:text-white">
                                    {{$reciboActual->fecha}}
                                </h2>
                            </div>
                            <div>
                                <label for="valor" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Valor:</label>
                                <h2 class="md:text-xl font-bold text-gray-900 dark:text-white">
                                    $ {{number_format($reciboActual->valor_total, 0, ',', '.')}}
                                </h2>
                            </div>
                            <div>
                                <label for="sede" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">generado en:</label>
                                <h2 class="md:text-xl font-bold text-gray-900 dark:text-white">
                                    {{$reciboActual->sede->name}}
                                </h2>
                            </div>
                            <div>
                                <label for="autor" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">generado por:</label>
                                <h2 class="md:text-xl font-bold text-gray-900 dark:text-white">
                                    {{$reciboActual->creador->name}}
                                </h2>
                            </div>
                        </div>

                        <label for="valor" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Detalle:</label>
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
        </section>

        @if ($accion!==2)
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
                Anular Recibo de Pago
            </button>

            <a href="#" wire:click.prevent="$dispatch('Editando')" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                <i class="fa-solid fa-rectangle-xmark"></i> cancelar
            </a>
        @endif
    </form>
</div>
