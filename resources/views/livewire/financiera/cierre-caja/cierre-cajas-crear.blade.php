<div>
    <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-4 m-2">
        <div class="mb-6">
            <select wire:model.live="sede_id" id="sede_id" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                <option >Elija sede...</option>
                @foreach ($sedes as $item)
                    <option value={{$item->id}}>{{$item->name}} - {{$item->sector->name}}</option>
                @endforeach
            </select>
            @error('sede_id')
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                </div>
            @enderror
        </div>

        @if ($sede_id>0)
            <div class="mb-6">
                <select wire:model.live="cajero_id" id="cajero_id" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                    <option >Elija cajero...</option>
                    @foreach ($cajeros as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                </select>
                @error('cajero_id')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
        @endif
    </div>
    @if ($sede_id>0 && $cajero_id>0)

        <div class="grid sm:grid-cols-1 md:grid-cols-5 gap-3 bg-slate-300">
            <div class="mb-6">
                <div class="flex flex-col items-center justify-center">
                    <dt class="mb-2 text-4xl font-extrabold">$ {{number_format($valor_total, 0, ',', '.')}}</dt>
                    <dd class="text-gray-500 dark:text-gray-400 capitalize">Valor total</dd>
                </div>
            </div>
            @foreach ($totalmedios as $item)

                <div class="mb-6">
                    <div class="flex flex-col items-center justify-center">
                        <dt class="mb-2 text-4xl font-extrabold">$ {{number_format($item->total, 0, ',', '.')}}</dt>
                        <dd class="text-gray-500 dark:text-gray-400 capitalize">Total Recaudo en: {{$item->medio}}</dd>
                    </div>
                </div>

            @endforeach

            <div class="mb-6">
                <div class="flex flex-col items-center justify-center">
                    <dt class="mb-2 text-4xl font-extrabold">$ {{number_format($descuentosT, 0, ',', '.')}}</dt>
                    <dd class="text-gray-500 dark:text-gray-400 capitalize">Valor Total descuentos</dd>
                </div>
            </div>

            <div class="mb-6">
                <div class="flex flex-col items-center justify-center">
                    <dt class="mb-2 text-4xl font-extrabold">$ {{number_format($totaldesefectivo, 0, ',', '.')}}</dt>
                    <dd class="text-gray-500 dark:text-gray-400 capitalize">Valor descuentos en efectivo</dd>
                </div>
            </div>

            <div class="mb-6">
                <div class="flex flex-col items-center justify-center">
                    <dt class="mb-2 text-4xl font-extrabold">$ {{number_format($efectivoentrega, 0, ',', '.')}}</dt>
                    <dd class="text-gray-500 dark:text-gray-400 capitalize">TOTAL EFECTIVO A ENTREGAR</dd>
                </div>
            </div>

            <div class="mb-6">
                <div class="flex flex-col items-center justify-center">
                    <dt class="mb-2 text-4xl font-extrabold">$ {{number_format($totaltarjeta, 0, ',', '.')}}</dt>
                    <dd class="text-gray-500 dark:text-gray-400 capitalize">Cobro por uso de tarjetas</dd>
                </div>
            </div>
            <div class="mb-6">
                <div class="flex flex-col items-center justify-center">
                    <dt class="mb-2 text-4xl font-extrabold">$ {{number_format($valor_anulado, 0, ',', '.')}}</dt>
                    <dd class="text-gray-500 dark:text-gray-400 capitalize">Valor anulado</dd>
                </div>
            </div>
        </div>

        <div class="grid sm:grid-cols-1 md:grid-cols-5 gap-4 bg-slate-200">
            <div class="mb-6">
                <div class="flex flex-col items-center justify-center">
                    <dt class="mb-2 text-3xl font-extrabold">$ {{number_format($totalpensiones, 0, ',', '.')}}</dt>
                    <dd class="text-gray-500 dark:text-gray-400 capitalize">Valor pensiones</dd>
                </div>
            </div>
            <div class="mb-6">
                <div class="flex flex-col items-center justify-center">
                    <dt class="mb-2 text-2xl font-extrabold">$ {{number_format($totalefectivopensiones, 0, ',', '.')}}</dt>
                    <dd class="text-gray-500 dark:text-gray-400 capitalize">Efectivo Pensiones</dd>
                </div>
            </div>
            <div class="mb-6">
                <div class="flex flex-col items-center justify-center">
                    <dt class="mb-2 text-2xl font-extrabold">$ {{number_format($totalchequepensiones, 0, ',', '.')}}</dt>
                    <dd class="text-gray-500 dark:text-gray-400 capitalize">Cheques</dd>
                </div>
            </div>
            <div class="mb-6">
                <div class="flex flex-col items-center justify-center">
                    <dt class="mb-2 text-2xl font-extrabold">$ {{number_format($totaltransaccionpensiones, 0, ',', '.')}}</dt>
                    <dd class="text-gray-500 dark:text-gray-400 capitalize">Transferencia PSE </dd>
                </div>
            </div>
            <div class="mb-6">
                <div class="flex flex-col items-center justify-center">
                    <dt class="mb-2 text-2xl font-extrabold">$ {{number_format($totaltarjetapensiones, 0, ',', '.')}}</dt>
                    <dd class="text-gray-500 dark:text-gray-400 capitalize">Pagos con Tarjeta </dd>
                </div>
            </div>
        </div>

        <div class="grid sm:grid-cols-1 md:grid-cols-5 gap-4 bg-slate-100 mb-3">
            <div class="mb-6">
                <div class="flex flex-col items-center justify-center">
                    <dt class="mb-2 text-3xl font-extrabold">$ {{number_format($valor_otros, 0, ',', '.')}}</dt>
                    <dd class="text-gray-500 dark:text-gray-400 capitalize">Valor Otros</dd>
                </div>
            </div>
            <div class="mb-6">
                <div class="flex flex-col items-center justify-center">
                    <dt class="mb-2 text-2xl font-extrabold">$ {{number_format($valor_efectivo_o, 0, ',', '.')}}</dt>
                    <dd class="text-gray-500 dark:text-gray-400 capitalize">Efectivo Otros</dd>
                </div>
            </div>
            <div class="mb-6">
                <div class="flex flex-col items-center justify-center">
                    <dt class="mb-2 text-2xl font-extrabold">$ {{number_format($valor_cheque_o, 0, ',', '.')}}</dt>
                    <dd class="text-gray-500 dark:text-gray-400 capitalize">Cheques</dd>
                </div>
            </div>
            <div class="mb-6">
                <div class="flex flex-col items-center justify-center">
                    <dt class="mb-2 text-2xl font-extrabold">$ {{number_format($valor_consignacion_o, 0, ',', '.')}}</dt>
                    <dd class="text-gray-500 dark:text-gray-400 capitalize">Transferencia PSE </dd>
                </div>
            </div>
            <div class="mb-6">
                <div class="flex flex-col items-center justify-center">
                    <dt class="mb-2 text-2xl font-extrabold">$ {{number_format($valor_tarjetas_o, 0, ',', '.')}}</dt>
                    <dd class="text-gray-500 dark:text-gray-400 capitalize">Pagos con Tarjeta </dd>
                </div>
            </div>
        </div>

        <div class="mb-6">
            <label for="comentarios" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Observaciones</label>
            <input type="text" id="comentarios" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Observaciones de cierre" wire:model.blur="comentarios" autocomplete="off">

            @error('comentarios')
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                </div>
            @enderror
        </div>
        <div class="mb-6">
            <label for="dinero_entegado" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Efectivo entregado, descontando dinero de base</label>
            <input type="text" id="dinero_entegado" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="dinero entregado" wire:model.blur="dinero_entegado" autocomplete="off">

            @error('dinero_entegado')
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                </div>
            @enderror
        </div>
    @endif



    <div class="grid sm:grid-cols-1 md:grid-cols-3 gap-4 m-2">
        @if ($sede_id>0 && $cajero_id>0)
        <div>
            <a href="#" wire:click.prevent="generaCierre(1)" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mt-2 capitalize">
                <i class="fa-solid fa-rectangle-xmark"></i> GENERAR Y APROBAR CIERRE
            </a>
        </div>
        @endif
        <div>
            <a href="#" wire:click.prevent="$dispatch('created')" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mt-2 capitalize">
                <i class="fa-solid fa-rectangle-xmark"></i> cancelar
            </a>
        </div>
    </div>
    @if ($sede_id>0 && $cajero_id>0)
        <h5 class="text-semibold md:text-lg sm:text-sm capitalize m-3">Detalle Recibos de caja encontrados de un total de {{$reciboselegidos->count()}} recibos</h5>
        <table class=" text-sm text-left text-gray-500 dark:text-gray-400 m-2">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr class=" bg-gray-100">
                    <th scope="col" colspan="4" class="px-6 py-3" >
                        DATOS RECIBO CAJA
                    </th>
                    <th scope="col" colspan="7" class="px-6 py-3" >
                        DETALLES RECIBO CAJA
                    </th>
                </tr>
                <tr class=" bg-gray-200">
                    <th scope="col" class="px-6 py-3" >
                        N°:
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Fecha
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Valor total
                    </th>
                    <th scope="col" class="px-6 py-3" >
                        Descuento Total
                    </th>
                    <th scope="col" class="px-6 py-3" >
                        Concepto
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Tipo
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Medio
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Valor
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Producto
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Cantidad
                    </th>
                    <th scope="col" class="px-6 py-3" >
                        Unitario
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($resumen as $recibo)

                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200 text-sm">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{$recibo->numero_recibo}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                            {{$recibo->fecha}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-right">
                            $ {{number_format($recibo->valor_total, 0, '.', ' ')}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-right">
                            $ {{number_format($recibo->descuento, 0, '.', ' ')}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                            {{$recibo->name}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                            {{$recibo->tipo}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                            {{$recibo->medio}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white  text-right">
                            $ {{number_format($recibo->valor, 0, '.', ' ')}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                            {{$recibo->producto}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                            {{$recibo->cantidad}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white  text-right">
                            $ {{number_format($recibo->unitario, 0, '.', ' ')}}
                        </th>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
