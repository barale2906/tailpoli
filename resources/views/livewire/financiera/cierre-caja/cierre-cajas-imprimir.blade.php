<div>
    <section class="bg-cyan-50 dark:bg-gray-900">
        <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 grid lg:grid-cols-2 gap-2 lg:gap-2">
            <div class="flex flex-col justify-center">
                <h1 class="mb-4 text-xl font-extrabold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-6xl dark:text-white">
                    Cierre de Caja N°: {{$cierre->id}}
                </h1>
                <h2 class="md:text-2xl font-bold text-gray-900 dark:text-white">
                    Generado por: {{$cierre->cajero->name}}
                </h2>
                @if ($cierre->status)
                    <h2 class="md:text-2xl font-bold text-gray-900 dark:text-white">
                        Aprobado por: {{$cierre->coorcaja->name}}
                    </h2>
                @endif
                @if ($accion===0)
                    <div class="mb-6">
                        <label for="observaciones" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Observaciones de aprobación:</label>
                        <input type="text" id="observaciones" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Anotaciones importantes" wire:model.blur="observaciones">

                        @error('observaciones')
                            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 m-2" role="alert">
                                <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                            </div>
                        @enderror
                    </div>
                @endif
                <p class="mb-6 md:text-lg font-normal text-gray-500 lg:text-xl dark:text-gray-400">
                    Observaciones: {{$cierre->observaciones}}
                </p>
                <div class="grid sm:grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        @switch($accion)
                            @case(0)
                                <a href="#" wire:click.prevent="$dispatch('Inactivando')" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                                    <i class="fa-solid fa-backward-fast fa-beat"></i> Volver
                                </a>
                                @break
                            @case(1)
                                <a href="#" wire:click.prevent="$dispatch('watched')" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                                    <i class="fa-solid fa-backward-fast fa-beat"></i> Volver
                                </a>
                                @break

                            @case(2)
                                <a href="#" wire:click.prevent="$dispatch('volver')" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                                    <i class="fa-solid fa-backward-fast fa-beat"></i> Volver
                                </a>
                                @break
                        @endswitch
                    </div>
                    <div>
                        @if ($accion===0)
                            <a href="#" wire:click.prevent="aprobar()" class="text-black bg-gradient-to-r from-yellow-300 via-yellow-400 to-yellow-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-yellow-200 dark:focus:ring-yellow-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                                <i class="fa-solid fa-check-double"></i> Aprobar Cierre.
                            </a>
                        @endif
                    </div>
                    <div>

                    </div>
                </div>
            </div>
            <div>
                <div class="w-full lg:max-w-xl p-6 space-y-8 sm:p-8 bg-white rounded-lg shadow-xl dark:bg-gray-800">

                    <div class="sm:grid-cols-1 md:grid-cols-2 gap-2">
                        <div>
                            <label for="fecha" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha:</label>
                            <h2 class="md:text-xl font-bold text-gray-900 dark:text-white">
                                {{$cierre->fecha_cierre}}
                            </h2>
                        </div>
                        @if ($accion===0)
                            <div>
                                <label for="valor" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Valor Efectivo:</label>
                                    <h2 class="md:text-xl font-bold text-gray-900 dark:text-white">
                                        $ {{number_format($cierre->valor_total, 0, ',', '.')}}
                                    </h2>
                            </div>
                            <div>
                                <label for="valor" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Valor reportado en Efectivo:</label>
                                <h2 class="md:text-xl font-bold text-gray-900 dark:text-white">
                                    $ {{number_format($cierre->valor_reportado, 0, ',', '.')}}
                                </h2>
                            </div>
                        @else

                            <div>
                                @if ($cierre->status)
                                    <label for="valor" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Valor Efectivo:</label>
                                    <h2 class="md:text-xl font-bold text-gray-900 dark:text-white">
                                        $ {{number_format($cierre->valor_total, 0, ',', '.')}}
                                    </h2>
                                @else
                                    <label for="valor" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Valor reportado en Efectivo:</label>
                                    <h2 class="md:text-xl font-bold text-gray-900 dark:text-white">
                                        $ {{number_format($cierre->valor_reportado, 0, ',', '.')}}
                                    </h2>
                                @endif
                            </div>

                        @endif
                        <div>
                            <label for="sede" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">generado en:</label>
                            <h2 class="md:text-xl font-bold text-gray-900 dark:text-white">
                                {{$cierre->sede->name}}
                            </h2>
                        </div>
                    </div>

                    <h5 class="text-semibold md:text-lg sm:text-sm capitalize m-3">Recibos de caja encontrados</h5>
                        <table class=" text-sm text-left text-gray-500 dark:text-gray-400 m-2">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3" >
                                        ID
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Fecha
                                    </th>
                                    <th scope="col" class="px-6 py-3" >
                                        Alumno
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Observaciones
                                    </th>
                                    @if ($cierre->status || $accion===0)
                                        <th scope="col" class="px-6 py-3" >
                                            Medio
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Valor
                                        </th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recibos as $recibo)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200 text-sm">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{$recibo->id}}
                                        </th>
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                            {{$recibo->fecha}}
                                        </th>
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                            {{$recibo->paga->name}}
                                        </th>
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                            {{$recibo->observaciones}}
                                        </th>
                                        @if ($cierre->status || $accion===0)
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                                {{$recibo->medio}}
                                            </th>
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                                $ {{number_format($recibo->valor_total, 0, ',', '.')}}
                                            </th>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </section>
</div>
