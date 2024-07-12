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
    <div class="grid sm:grid-cols-1 md:grid-cols-5 gap-3 bg-slate-300">
        <div class="mb-6">
            <div class="flex flex-col items-center justify-center">
                <dt class="mb-2 text-4xl font-extrabold">$ {{number_format($cierre->valor_total, 0, ',', '.')}}</dt>
                <dd class="text-gray-500 dark:text-gray-400 capitalize">Valor total</dd>
            </div>
        </div>
        <div class="mb-6">
            <div class="flex flex-col items-center justify-center">
                <dt class="mb-2 text-4xl font-extrabold">$ {{number_format($cierre->efectivo, 0, ',', '.')}}</dt>
                <dd class="text-gray-500 dark:text-gray-400 capitalize">Total Recaudo en: Efectivo</dd>
            </div>
        </div>
        <div class="mb-6">
            <div class="flex flex-col items-center justify-center">
                <dt class="mb-2 text-4xl font-extrabold">$ {{number_format($cierre->descuentotal, 0, ',', '.')}}</dt>
                <dd class="text-gray-500 dark:text-gray-400 capitalize">Valor Total descuentos</dd>
            </div>
        </div>

        <div class="mb-6">
            <div class="flex flex-col items-center justify-center">
                <dt class="mb-2 text-4xl font-extrabold">$ {{number_format($cierre->efectivo_descuento, 0, ',', '.')}}</dt>
                <dd class="text-gray-500 dark:text-gray-400 capitalize">Valor descuentos en efectivo</dd>
            </div>
        </div>

        <div class="mb-6">
            <div class="flex flex-col items-center justify-center">
                <dt class="mb-2 text-4xl font-extrabold">$ {{number_format($cierre->efectivo_disponible, 0, ',', '.')}}</dt>
                <dd class="text-gray-500 dark:text-gray-400 capitalize">TOTAL EFECTIVO A ENTREGAR</dd>
            </div>
        </div>

        <div class="mb-6">
            <div class="flex flex-col items-center justify-center">
                <dt class="mb-2 text-4xl font-extrabold">$ {{number_format($cierre->valor_reportado, 0, ',', '.')}}</dt>
                <dd class="text-gray-500 dark:text-gray-400 capitalize">Efectivo Reportado Cajero</dd>
            </div>
        </div>

        <div class="mb-6">
            <div class="flex flex-col items-center justify-center">
                <dt class="mb-2 text-4xl font-extrabold">$ {{number_format($diferencia, 0, ',', '.')}}</dt>
                <dd class="text-gray-500 dark:text-gray-400 capitalize">DIFERENCIA</dd>
            </div>
        </div>


        <div class="mb-6">
            <div class="flex flex-col items-center justify-center">
                <dt class="mb-2 text-4xl font-extrabold">$ {{number_format($cierre->cobro_tarjeta, 0, ',', '.')}}</dt>
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
                <dt class="mb-2 text-3xl font-extrabold">$ {{number_format($cierre->valor_pensiones, 0, ',', '.')}}</dt>
                <dd class="text-gray-500 dark:text-gray-400 capitalize">Valor pensiones</dd>
            </div>
        </div>
        <div class="mb-6">
            <div class="flex flex-col items-center justify-center">
                <dt class="mb-2 text-2xl font-extrabold">$ {{number_format($cierre->valor_efectivo, 0, ',', '.')}}</dt>
                <dd class="text-gray-500 dark:text-gray-400 capitalize">Efectivo Pensiones</dd>
            </div>
        </div>
        <div class="mb-6">
            <div class="flex flex-col items-center justify-center">
                <dt class="mb-2 text-2xl font-extrabold">$ {{number_format($cierre->valor_cheque, 0, ',', '.')}}</dt>
                <dd class="text-gray-500 dark:text-gray-400 capitalize">Cheques</dd>
            </div>
        </div>
        <div class="mb-6">
            <div class="flex flex-col items-center justify-center">
                <dt class="mb-2 text-2xl font-extrabold">$ {{number_format($cierre->valor_consignacion, 0, ',', '.')}}</dt>
                <dd class="text-gray-500 dark:text-gray-400 capitalize">Transferencia PSE </dd>
            </div>
        </div>
        <div class="mb-6">
            <div class="flex flex-col items-center justify-center">
                <dt class="mb-2 text-2xl font-extrabold">$ {{number_format($cierre->tarjeta, 0, ',', '.')}}</dt>
                <dd class="text-gray-500 dark:text-gray-400 capitalize">Pagos con Tarjeta </dd>
            </div>
        </div>
    </div>

    <div class="grid sm:grid-cols-1 md:grid-cols-5 gap-4 bg-slate-100 mb-3">
        <div class="mb-6">
            <div class="flex flex-col items-center justify-center">
                <dt class="mb-2 text-3xl font-extrabold">$ {{number_format($cierre->valor_otros, 0, ',', '.')}}</dt>
                <dd class="text-gray-500 dark:text-gray-400 capitalize">Valor Otros</dd>
            </div>
        </div>
        <div class="mb-6">
            <div class="flex flex-col items-center justify-center">
                <dt class="mb-2 text-2xl font-extrabold">$ {{number_format($cierre->valor_efectivo_o, 0, ',', '.')}}</dt>
                <dd class="text-gray-500 dark:text-gray-400 capitalize">Efectivo Otros</dd>
            </div>
        </div>
        <div class="mb-6">
            <div class="flex flex-col items-center justify-center">
                <dt class="mb-2 text-2xl font-extrabold">$ {{number_format($cierre->valor_cheque_o, 0, ',', '.')}}</dt>
                <dd class="text-gray-500 dark:text-gray-400 capitalize">Cheques</dd>
            </div>
        </div>
        <div class="mb-6">
            <div class="flex flex-col items-center justify-center">
                <dt class="mb-2 text-2xl font-extrabold">$ {{number_format($cierre->valor_consignacion_o, 0, ',', '.')}}</dt>
                <dd class="text-gray-500 dark:text-gray-400 capitalize">Transferencia PSE </dd>
            </div>
        </div>
        <div class="mb-6">
            <div class="flex flex-col items-center justify-center">
                <dt class="mb-2 text-2xl font-extrabold">$ {{number_format($cierre->valor_tarjetas_o, 0, ',', '.')}}</dt>
                <dd class="text-gray-500 dark:text-gray-400 capitalize">Pagos con Tarjeta </dd>
            </div>
        </div>
    </div>

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
    </div>

</div>
