<div>
    @push('title')
        Cierre N°: {{$id}}
    @endpush

    <div class="relative overflow-x-auto bg-slate-200 shadow-sm shadow-teal-200 m-1">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">

                        <a href="{{$ruta}}" wire:navigate>
                            <img class="h-12 w-16 rounded-sm" src="{{asset('img/logo.jpeg')}}" alt="{{env('APP_NAME')}}">
                        </a>

                    </th>
                    <th scope="col" class="px-6 py-3">
                        <h1 class="text-center  font-extrabold uppercase">POLIANDINO</h1>
                        <h2 class="text-center  font-extrabold uppercase">nit: 900656857-5</h2>
                        <h2 class="text-center  font-extrabold uppercase">INSTITUTO DE CAPACITACIÓN POLIANDINO CENTRAL</h2>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <h1 class="text-center  uppercase">sede:</h1>
                        <h1 class="text-center  font-extrabold uppercase">{{$obtener->sede->name}}</h1>
                    </th>
                    <th scope="col" class="px-6 py-3 text-center">
                        <dd class="text-gray-500 dark:text-gray-400">Cierre N°:</dd>
                        <dt class="mb-2 text-xl font-extrabold">{{number_format($id, 0, '.', '.')}}</dt>
                    </th>
                </tr>
            </thead>
        </table>
    </div>

    <div class="relative overflow-x-auto m-1 shadow-sm shadow-teal-300">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-slate-300 dark:bg-gray-700  dark:text-gray-400">
                <tr>
                    <th scope="col" colspan="2" class="px-6 py-3 text-justify text-xl uppercase">
                        DETALLE DE CIERRE DE CAJA
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white dark:bg-gray-800">
                    <th scope="row" class="px-3 py-1 text-justify font-semibold text-lg text-gray-900 whitespace-nowrap dark:text-white">
                        Sede u Oficina:
                    </th>
                    <th scope="row" class="px-3 py-1 text-justify font-semibold  text-gray-900 whitespace-nowrap dark:text-white capitalize">
                        {{$obtener->sede->address}}
                    </th>
                </tr>
                <tr class="bg-white dark:bg-gray-800">
                    <th scope="row" class="px-3 py-1 text-justify font-semibold text-lg text-gray-900 whitespace-nowrap dark:text-white">
                        Usuario:
                    </th>
                    <th scope="row" class="px-3 py-1 text-justify font-semibold  text-gray-900 whitespace-nowrap dark:text-white capitalize">
                        {{$obtener->cajero->name}}
                    </th>
                </tr>
                <tr class="bg-white dark:bg-gray-800">
                    <th scope="row" class="px-3 py-1 text-justify font-semibold text-lg text-gray-900 whitespace-nowrap dark:text-white">
                        Fecha / Hora:
                    </th>
                    <th scope="row" class="px-3 py-1 text-justify font-semibold  text-gray-900 whitespace-nowrap dark:text-white capitalize">
                        {{$obtener->fecha_cierre}}
                    </th>
                </tr>
                <tr class="bg-white dark:bg-gray-800">
                    <th scope="row" class="px-3 py-1 text-justify font-semibold text-lg text-gray-900 whitespace-nowrap dark:text-white">
                        Efectivo Reportado:
                    </th>
                    <th scope="row" class="px-3 py-1 text-right font-semibold  text-gray-900 whitespace-nowrap dark:text-white capitalize">
                        $ {{number_format($obtener->valor_reportado, 0, '.', '.')}}
                    </th>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="relative overflow-x-auto m-1 shadow-sm shadow-teal-300">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-slate-300 dark:bg-gray-700  dark:text-gray-400">
                <tr>
                    <th scope="col" colspan="2" class="px-6 py-3 text-justify text-xl uppercase">
                        DESCUENTOS APLICADOS
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="dark:bg-gray-800 bg-gray-400">
                    <th scope="row" class="px-3 py-1 text-justify font-semibold text-lg text-gray-900 whitespace-nowrap dark:text-white">
                        TOTAL DESCUENTO:
                    </th>
                    <th scope="row" class="px-3 py-1 text-right font-semibold  text-gray-900 whitespace-nowrap dark:text-white capitalize">
                        $ {{number_format($obtener->descuentotal, 0, '.', '.')}}
                    </th>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="relative overflow-x-auto m-1 shadow-sm shadow-teal-300">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-slate-300 dark:bg-gray-700  dark:text-gray-400">
                <tr>
                    <th scope="col" colspan="2" class="px-6 py-3 text-justify text-xl uppercase">
                        INGRESOS POR PENSIONES
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white dark:bg-gray-800">
                    <th scope="row" class="px-3 py-1 text-justify font-semibold text-lg text-gray-900 whitespace-nowrap dark:text-white">
                        Total Efectivo:
                    </th>
                    <th scope="row" class="px-3 py-1 text-right font-semibold  text-gray-900 whitespace-nowrap dark:text-white capitalize">
                        $ {{number_format($obtener->valor_efectivo, 0, '.', '.')}}
                    </th>
                </tr>
                <tr class="bg-white dark:bg-gray-800">
                    <th scope="row" class="px-3 py-1 text-justify font-semibold text-lg text-gray-900 whitespace-nowrap dark:text-white">
                        Total Tarjeta Débito/Crédito:
                    </th>
                    <th scope="row" class="px-3 py-1 text-right font-semibold  text-gray-900 whitespace-nowrap dark:text-white capitalize">
                        $ {{number_format($obtener->valor_tarjeta, 0, '.', '.')}}
                    </th>
                </tr>
                <tr class="bg-white dark:bg-gray-800">
                    <th scope="row" class="px-3 py-1 text-justify font-semibold text-lg text-gray-900 whitespace-nowrap dark:text-white">
                        Cheque:
                    </th>
                    <th scope="row" class="px-3 py-1 text-right font-semibold  text-gray-900 whitespace-nowrap dark:text-white capitalize">
                        $ {{number_format($obtener->valor_cheque, 0, '.', '.')}}
                    </th>
                </tr>
                <tr class="bg-white dark:bg-gray-800">
                    <th scope="row" class="px-3 py-1 text-justify font-semibold text-lg text-gray-900 whitespace-nowrap dark:text-white">
                        Consignación:
                    </th>
                    <th scope="row" class="px-3 py-1 text-right font-semibold  text-gray-900 whitespace-nowrap dark:text-white capitalize">
                        $ {{number_format($obtener->valor_consignacion, 0, '.', '.')}}
                    </th>
                </tr>
                <tr class="dark:bg-gray-800 bg-gray-400">
                    <th scope="row" class="px-3 py-1 text-justify font-semibold text-lg text-gray-900 whitespace-nowrap dark:text-white">
                        TOTAL:
                    </th>
                    <th scope="row" class="px-3 py-1 text-right font-semibold  text-gray-900 whitespace-nowrap dark:text-white capitalize">
                        $ {{number_format($obtener->valor_pensiones, 0, '.', '.')}}
                    </th>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="relative overflow-x-auto m-1 shadow-sm shadow-teal-300">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-slate-300 dark:bg-gray-700  dark:text-gray-400">
                <tr>
                    <th scope="col" colspan="2" class="px-6 py-3 text-justify text-xl uppercase">
                        INGRESOS POR OTROS CONCEPTOS
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white dark:bg-gray-800">
                    <th scope="row" class="px-3 py-1 text-justify font-semibold text-lg text-gray-900 whitespace-nowrap dark:text-white">
                        Total Efectivo:
                    </th>
                    <th scope="row" class="px-3 py-1 text-right font-semibold  text-gray-900 whitespace-nowrap dark:text-white capitalize">
                        $ {{number_format($obtener->valor_efectivo_o, 0, '.', '.')}}
                    </th>
                </tr>
                <tr class="bg-white dark:bg-gray-800">
                    <th scope="row" class="px-3 py-1 text-justify font-semibold text-lg text-gray-900 whitespace-nowrap dark:text-white">
                        Total Tarjeta Débito/Crédito:
                    </th>
                    <th scope="row" class="px-3 py-1 text-right font-semibold  text-gray-900 whitespace-nowrap dark:text-white capitalize">
                        $ {{number_format($obtener->valor_tarjeta_o, 0, '.', '.')}}
                    </th>
                </tr>
                <tr class="bg-white dark:bg-gray-800">
                    <th scope="row" class="px-3 py-1 text-justify font-semibold text-lg text-gray-900 whitespace-nowrap dark:text-white">
                        Cheque:
                    </th>
                    <th scope="row" class="px-3 py-1 text-right font-semibold  text-gray-900 whitespace-nowrap dark:text-white capitalize">
                        $ {{number_format($obtener->valor_cheque_o, 0, '.', '.')}}
                    </th>
                </tr>
                <tr class="bg-white dark:bg-gray-800">
                    <th scope="row" class="px-3 py-1 text-justify font-semibold text-lg text-gray-900 whitespace-nowrap dark:text-white">
                        Consignación:
                    </th>
                    <th scope="row" class="px-3 py-1 text-right font-semibold  text-gray-900 whitespace-nowrap dark:text-white capitalize">
                        $ {{number_format($obtener->valor_consignacion_o, 0, '.', '.')}}
                    </th>
                </tr>
                <tr class="dark:bg-gray-800 bg-gray-400">
                    <th scope="row" class="px-3 py-1 text-justify font-semibold text-lg text-gray-900 whitespace-nowrap dark:text-white">
                        TOTAL:
                    </th>
                    <th scope="row" class="px-3 py-1 font-semibold text-right  text-gray-900 whitespace-nowrap dark:text-white capitalize">
                        $ {{number_format($obtener->valor_otros, 0, '.', '.')}}
                    </th>
                </tr>
                <tr class="bg-white dark:bg-gray-800 border">
                    <th scope="row" colspan="6" class="px-3 py-1 text-xl text-gray-900 whitespace-nowrap dark:text-white">
                        <small class="capitalize">
                            OBSERVACIONES:
                            {{$obtener->observaciones}}
                        </small>
                    </th>
                </tr>
            </tbody>
        </table>
    </div>



    <div class="relative overflow-x-auto m-1 shadow-sm shadow-teal-300">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-slate-300 dark:bg-gray-700  dark:text-gray-400">
                <tr>
                    <th scope="col" colspan="2" class="px-6 py-3 text-justify text-xl capitalize"></th>

                    <th scope="col" colspan="1" class="px-6 py-3 text-right text-xl capitalize">
                        <h1>$ {{number_format($obtener->valor_total, 0, '.', '.')}}  </h1>
                        <h1>$ {{number_format($obtener->descuentotal, 0, '.', '.')}}  </h1>
                        <h1>$ {{number_format($obtener->efectivo, 0, '.', '.')}}  </h1>
                        <h1>$ {{number_format($obtener->efectivo_descuento, 0, '.', '.')}}  </h1>
                        <h1>$ {{number_format($obtener->valor_reportado, 0, '.', '.')}}  </h1>
                        <h1>$ {{number_format($obtener->valor_tarjeta+$obtener->valor_tarjeta_o, 0, '.', '.')}}  </h1>
                        <h1>$ {{number_format($obtener->cobro_tarjeta, 0, '.', '.')}}  </h1>
                        <h1>$ {{number_format($obtener->valor_cheque+$obtener->valor_cheque_o, 0, '.', '.')}}  </h1>
                        <h1>$ {{number_format($obtener->valor_consignacion+$obtener->valor_consignacion_o, 0, '.', '.')}}  </h1>

                    </th>
                    <th scope="col" colspan="2" class="px-6 py-3 text-justify text-xl capitalize">
                        <h1>TOTAL</h1>
                        <h1>DESCUENTOS </h1>
                        <h1>EFECTIVO FACTURADO  </h1>
                        <h1>EFECTIVO DESCUENTO  </h1>
                        <h1>EFECTIVO REPORTADO </h1>
                        <h1>TARJETA </h1>
                        <h1>COBRO POR USO TARJETA </h1>
                        <h1>CHEQUE </h1>
                        <h1>TRANSFERENCIA - PSE </h1>
                    </th>
                    <th scope="col" colspan="2" class="px-6 py-3 text-right text-xl capitalize"></th>
                </tr>
                <tr>
                    <th scope="col" colspan="2" class="px-6 py-3 text-justify text-xl capitalize"></th>
                    <th scope="col" colspan="4" class="px-6 py-3 text-justify text-xl capitalize">
                        <h1 class="mt-3">Firma: ________________________________________</h1>
                    </th>
                </tr>
            </thead>

        </table>
    </div>

</div>
