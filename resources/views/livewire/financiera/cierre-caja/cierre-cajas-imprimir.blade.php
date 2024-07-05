<div>

    <div class="w-full p-4 text-center bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
        <h5 class="mb-2 text-2xl font-bold text-gray-900 dark:text-white">
            Cierre de Caja N°: {{$cierre->id}}, Generado por: <span class=" capitalize">{{$cierre->cajero->name}}</span>
        </h5>
        @if ($cierre->status)
            <h2 class="md:text-2xl font-bold text-gray-900 dark:text-white">
                Aprobado por: <span class=" capitalize">{{$cierre->coorcaja->name}}</span>
            </h2>
        @endif
        <p class="mb-5 text-base text-gray-500 sm:text-lg dark:text-gray-400">
            Observaciones: {{$cierre->observaciones}}
        </p>

        <dl class="grid max-w-screen-xl grid-cols-1 gap-8 p-4 mx-auto text-gray-900 sm:grid-cols-3 xl:grid-cols-5 dark:text-white sm:p-8">
            <div class="flex flex-col items-center justify-center">
                <dt class="mb-2 text-3xl font-extrabold">Fecha Cierre</dt>
                <dd class="text-gray-500 dark:text-gray-400">{{$cierre->fecha_cierre}}</dd>
            </div>
            @if ($accion===0)
                <div class="flex flex-col items-center justify-center">
                    <dt class="mb-2 text-3xl font-extrabold">Valor Efectivo:</dt>
                    <dd class="text-gray-500 dark:text-gray-400">$ {{number_format($cierre->valor_total, 0, ',', '.')}}</dd>
                </div>
                <div class="flex flex-col items-center justify-center">
                    <dt class="mb-2 text-3xl font-extrabold">Valor reportado en Efectivo:</dt>
                    <dd class="text-gray-500 dark:text-gray-400">$ {{number_format($cierre->valor_reportado, 0, ',', '.')}}</dd>
                </div>
            @else
                @if ($cierre->status)
                    <div class="flex flex-col items-center justify-center">
                        <dt class="mb-2 text-3xl font-extrabold">Valor Efectivo:</dt>
                        <dd class="text-gray-500 dark:text-gray-400">$ {{number_format($cierre->valor_total, 0, ',', '.')}}</dd>
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center">
                        <dt class="mb-2 text-3xl font-extrabold">Valor reportado en Efectivo:</dt>
                        <dd class="text-gray-500 dark:text-gray-400">$ {{number_format($cierre->valor_reportado, 0, ',', '.')}}</dd>
                    </div>
                @endif
            @endif

            <div class="flex flex-col items-center justify-center">
                <dt class="mb-2 text-3xl font-extrabold">generado en:</dt>
                <dd class="text-gray-500 dark:text-gray-400">{{$cierre->sede->name}}</dd>
            </div>
            <div class="flex flex-col items-center justify-center">
                <dt class="mb-2 text-3xl font-extrabold">Descuentos aplicados:</dt>
                <dd class="text-gray-500 dark:text-gray-400">$ {{number_format($descuentosT, 0, ',', '.')}}</dd>
            </div>
        </dl>
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

        <div class="items-center justify-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4 rtl:space-x-reverse">
            @if ($ruta===2)
                <a href="#" wire:click.prevent="$dispatch('cancelando')" class="w-full sm:w-auto bg-cyan-800 hover:bg-cyan-700 focus:ring-4 focus:outline-none focus:ring-cyan-300 text-white rounded-lg inline-flex items-center justify-center px-4 py-2.5 dark:bg-cyan-700 dark:hover:bg-cyan-600 dark:focus:ring-cyan-700">
                    <i class="fa-solid fa-backward-fast fa-beat"></i>
                    <div class="text-left rtl:text-right">

                        <div class="-mt-1 font-sans text-sm font-semibold">Volver</div>
                    </div>
                </a>
            @else
                @switch($accion)
                    @case(0)
                        <a href="#" wire:click.prevent="$dispatch('Inactivando')" class="w-full sm:w-auto bg-cyan-800 hover:bg-cyan-700 focus:ring-4 focus:outline-none focus:ring-cyan-300 text-white rounded-lg inline-flex items-center justify-center px-4 py-2.5 dark:bg-cyan-700 dark:hover:bg-cyan-600 dark:focus:ring-cyan-700">
                            <i class="fa-solid fa-backward-fast fa-beat"></i>
                            <div class="text-left rtl:text-right">

                                <div class="-mt-1 font-sans text-sm font-semibold">Volver</div>
                            </div>
                        </a>
                        @break
                    @case(1)
                        <a href="#" wire:click.prevent="$dispatch('watched')" class="w-full sm:w-auto bg-cyan-800 hover:bg-cyan-700 focus:ring-4 focus:outline-none focus:ring-cyan-300 text-white rounded-lg inline-flex items-center justify-center px-4 py-2.5 dark:bg-cyan-700 dark:hover:bg-cyan-600 dark:focus:ring-cyan-700">
                            <i class="fa-solid fa-backward-fast fa-beat"></i>
                            <div class="text-left rtl:text-right">

                                <div class="-mt-1 font-sans text-sm font-semibold">Volver</div>
                            </div>
                        </a>
                        @break

                    @case(2)
                        <a href="#" wire:click.prevent="$dispatch('volver')" class="w-full sm:w-auto bg-cyan-800 hover:bg-cyan-700 focus:ring-4 focus:outline-none focus:ring-cyan-300 text-white rounded-lg inline-flex items-center justify-center px-4 py-2.5 dark:bg-cyan-700 dark:hover:bg-cyan-600 dark:focus:ring-cyan-700">
                            <i class="fa-solid fa-backward-fast fa-beat"></i>
                            <div class="text-left rtl:text-right">

                                <div class="-mt-1 font-sans text-sm font-semibold">Volver</div>
                            </div>
                        </a>
                        @break
                @endswitch
            @endif
            @if ($accion===0)
                <a href="#" wire:click.prevent="aprobar()" class="text-black bg-gradient-to-r from-yellow-300 via-yellow-400 to-yellow-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-yellow-200 dark:focus:ring-yellow-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                    <i class="fa-solid fa-check-double"></i> Aprobar Cierre.
                </a>
            @endif


        </div>
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
                            Valor Total
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Valor Descuento
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Valor Neto
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
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                            {{$recibo->paga->name}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                            {{$recibo->observaciones}}
                        </th>
                        @if ($cierre->status || $accion===0)
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                {{$recibo->medio}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                $ {{number_format($recibo->valor_total, 0, ',', '.')}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                $ {{number_format($recibo->descuento, 0, ',', '.')}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                $ {{number_format($recibo->valor_total-$recibo->descuento, 0, ',', '.')}}
                            </th>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
