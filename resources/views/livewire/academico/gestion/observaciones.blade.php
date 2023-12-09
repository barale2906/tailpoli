<div>
    <h1 class="font-extrabold text-xl text-center capitalize">registrar cambios para: <strong class="uppercase">{{$elegido->estudiante->name}}</strong></h1>
    <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-4 md:h-52">
        <div class="mb-6">
            <label for="comentarios" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Registre Observaciones</label>
            <textarea id="comentarios" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Comentarios de la conversación" wire:model.live="comentarios">

            </textarea>
            @error('comentarios')
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                </div>
            @enderror
        </div>
        <div class="mb-6 overflow-y-auto">
            @for ($i = 0; $i < count($observaciones); $i++)
                <p class="text-justify text-sm">
                    {{$observaciones[$i]}}
                </p>
            @endfor

        </div>
        <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-4">

            @if ($comentarios)
                <div>
                    <a href="#" wire:click.prevent="guardar" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                        <i class="fa-solid fa-upload"></i> Guardar Comentario
                    </a>
                </div>
            @endif

            <div>
                <a href="" wire:click.prevent="$dispatch('cancelando')" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                    <i class="fa-solid fa-rectangle-xmark"></i> cancelar
                </a>
            </div>
        </div>
    </div>
    <h1 class="text-center text-lg font-semibold rounded-lg bg-cyan-300 uppercase mt-4">estado de cartera</h1>
    <div class="relative overflow-x-auto m-1 text-center ring ring-black mt-6 mb-6">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase font-extrabold bg-slate-300 dark:bg-gray-700  dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3 text-center text-xs">
                        concepto
                    </th>
                    <th scope="col" class="px-6 py-3 text-center text-xs">
                        fecha de pago
                    </th>
                    <th scope="col" class="px-6 py-3 text-center text-xs">
                        valor
                    </th>
                    <th scope="col" class="px-6 py-3 text-center text-xs">
                        Días de retraso
                    </th>
                    <th scope="col" class="px-6 py-3 text-center text-xs">
                        Saldo
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cartera as $item)
                    <tr class="bg-white dark:bg-gray-800">
                        <th scope="row" class="px-3 py-1 text-justify text-gray-900 text-xs  dark:text-white capitalize">
                            {{$item->concepto}}
                        </th>
                        <th scope="row" class="px-3 py-1 text-center text-gray-900 text-xs  dark:text-white capitalize">
                            {{$item->fecha_pago}}
                        </th>
                        <th scope="row" class="px-3 py-1 text-right text-gray-900 text-xs  dark:text-white capitalize">
                            $ {{number_format($item->valor, 0, '.', '.')}}
                        </th>
                        <th scope="row" class="px-3 py-1 text-right text-red-700 text-xs  dark:text-white uppercase">
                            @if ($item->fecha_pago < $fecha)
                                @php
                                    $fecha1 = date_create($item->fecha_pago);
                                    $dias = date_diff($fecha1, $fecha)->format('%R%a');
                                @endphp
                                {{$dias}} días
                            @endif
                        </th>
                        <th scope="row" class="px-3 py-1 text-right text-gray-900 text-xs  dark:text-white capitalize">
                            $ {{number_format($item->saldo, 0, '.', '.')}}
                        </th>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h1 class="text-lg text-justify">
            A la fecha del {{$fecha}}, su deuda es de: <strong>$ {{number_format($cartera->sum('saldo')   , 0, '.', '.')}}</strong>
        </h1>
        <livewire:configuracion.user.perfil :elegido="$alumno" :perf="1" :impresion="0" :ruta="$ruta"/>
    </div>
</div>
