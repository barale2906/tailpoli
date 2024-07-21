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
            @foreach ($historialAlumno as $item)
                <p class="text-justify text-sm">
                    {{$item->fecha}}: {{$item->observaciones}}
                </p>
            @endforeach
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
    @if ($elegido->estudiante->caso_especial>0)
    <div class="rounded-lg bg-slate-200 p-2">
        <livewire:academico.estudiante.caso-especial :id="$elegido->estudiante->id" />
    </div>
    @endif
    <h1 class="text-center text-lg font-semibold rounded-lg bg-cyan-300 uppercase mt-4">estado de cartera</h1>
    <div class="relative overflow-x-auto m-1 text-center ring ring-black mt-6 mb-6">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase font-extrabold bg-slate-300 dark:bg-gray-700  dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3 text-center text-xs">
                        Matricula - Curso
                    </th>
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
                    @if (!$item->matricula->anula)
                        <tr class="bg-white dark:bg-gray-800">
                            <th scope="row" class="px-3 py-1 text-justify text-gray-900 text-xs  dark:text-white capitalize">
                                {{$item->matricula->id}} - {{$item->matricula->curso->name}}
                            </th>
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
                                @if ($item->status)
                                    @if ($item->fecha_pago < $fecha)
                                        @php
                                            $fecha1 = date_create($item->fecha_pago);
                                            $dias = date_diff($fecha1, $fecha)->format('%R%a');
                                        @endphp
                                        {{$dias}} días
                                    @endif
                                @else
                                    Fecha pago: {{$item->fecha_real}}
                                @endif
                            </th>
                            <th scope="row" class="px-3 py-1 text-right text-gray-900 text-xs  dark:text-white capitalize">
                                @if ($item->status)
                                    $ {{number_format($item->saldo, 0, '.', '.')}}
                                @else
                                    CANCELADO
                                @endif

                            </th>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

        <h1 class="text-lg text-justify">
            A la fecha del {{$fecha}}, su deuda es de: <strong>$ {{number_format($saldocartera   , 0, '.', '.')}}</strong>
        </h1>

    </div>
    @if ($transacciones)
        <div class="relative overflow-x-auto">
            <h1 class="text-center text-lg font-semibold rounded-lg bg-cyan-300 uppercase mt-4">Transacciones enviadas a validación</h1>
            <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3" ></th>
                        <th scope="col" class="px-6 py-3" >
                            Fecha de Creación
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            Sede
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            Alumno
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            Acádemico
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            Otros
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            Observaciones
                        </th>

                        <th scope="col" class="px-6 py-3" >
                            Fecha Transacción
                        </th>

                        <th scope="col" class="px-6 py-3" >
                            Banco
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            Creador
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transacciones as $transaccione)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200 text-sm">

                            <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                <a href="{{Storage::url($transaccione->ruta)}}" target="_blank">
                                    <button type="button" class="px-4 py-2 text-xs font-medium text-gray-900 bg-blue-150 border border-gray-200 rounded-lg hover:bg-green-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                                        <i class="fa-solid fa-magnifying-glass"></i> - {{$transaccione->id}}
                                    </button>
                                </a>
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                {{$transaccione->fecha}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                {{$transaccione->sede->name}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                {{$transaccione->user->name}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white text-right">
                                $ {{number_format($transaccione->academico, 0, '.', ' ')}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white text-right">
                                $ {{number_format($transaccione->inventario, 0, '.', ' ')}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white capitalize">
                                {{$transaccione->observaciones}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white capitalize">
                                {{$transaccione->fecha_transaccion}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white capitalize">
                                {{$transaccione->banco}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white capitalize">
                                {{$transaccione->creador->name}}
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
    <div class="relative overflow-x-auto">
        <h1 class="text-center text-lg font-semibold rounded-lg bg-cyan-300 uppercase mt-4">recibos pago</h1>
        <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('id')">
                        No
                    </th>
                    <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('fecha')">
                        Fecha Recibo
                    </th>
                    <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('fecha')">
                        Fecha Transacción
                    </th>
                    <th scope="col" class="px-6 py-3" >
                        Alumno
                    </th>
                    <th scope="col" class="px-6 py-3" >
                        Sede
                    </th>
                    <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('valor_total')">
                        Valor
                    </th>
                    <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('medio')">
                        Medio
                    </th>
                    <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('observaciones')">
                        Observaciones
                    </th>
                    <th scope="col" class="px-6 py-3" >
                        Creador
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($recibos as $recibo)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200 text-sm">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                                <a href="/impresiones/imprecibo?rut=0&r={{$recibo->id}}" target="_blank" class="inline-flex items-center font-medium text-blue-600 dark:texgreen-500 hover:underline">
                                    <i class="fa-solid fa-print"></i>
                                </a>
                            </span>
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                            {{$recibo->fecha}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                            {{$recibo->fecha_transaccion}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                            {{$recibo->paga->name}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                            {{$recibo->sede->name}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-right">
                            $ {{number_format($recibo->valor_total, 0, '.', ' ')}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white  text-right">
                            {{$recibo->medio}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white capitalize">
                            {{$recibo->observaciones}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                            {{$recibo->creador->name}}
                        </th>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <livewire:configuracion.user.perfil :elegido="$alumno" :perf="1" :impresion="0" :ruta="$ruta"/>
    </div>


</div>
