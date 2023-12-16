<div>
    @push('title')
        Recibo N°: {{$obtener->numero_recibo}}
    @endpush

    @if ($obtener->origen)
        <div>
            <div class="relative overflow-x-auto bg-slate-200 shadow-sm shadow-teal-200 m-1">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">

                                <a href="{{$url}}" wire:navigate>
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
                                <dd class="text-gray-500 dark:text-gray-400">Recibo N°:</dd>
                                <dt class="mb-2 text-xl font-extrabold">{{number_format($obtener->numero_recibo, 0, '.', '.')}}</dt>
                            </th>
                        </tr>
                        <tr>
                            <th scope="col" colspan="2" class="px-6 py-3 ">
                                <h1 class="text-justify capitalize">dirección sede: {{$obtener->sede->address}}</h1>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <h1 class="text-center capitalize">{{$obtener->medio}}</h1>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <h1 class="text-center  uppercase">{{$obtener->fecha}}</h1>
                            </th>
                        </tr>
                        <tr>
                            <th scope="col" colspan="2" class="px-6 py-3 ">
                                <h1 class="text-justify  uppercase"> cliente: {{$obtener->paga->name}}</h1>
                            </th>
                            <th scope="col" colspan="2" class="px-6 py-3">
                                <h1 class="text-justify text-xs capitalize">documento: {{$obtener->paga->documento}}</h1>
                            </th>
                        </tr>
                        <tr>
                            <th scope="col" colspan="2" class="px-6 py-3 ">
                                <h1 class="text-justify  capitalize"> teléfono cliente: {{$obtener->creador->perfil->celular}}</h1>
                            </th>
                            <th scope="col" colspan="2" class="px-6 py-3 ">
                                <h1 class="text-justify  capitalize"> Asesor: {{$obtener->creador->name}}</h1>
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>

            <div class="relative overflow-x-auto m-1 shadow-sm shadow-teal-300">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-slate-300 dark:bg-gray-700  dark:text-gray-400">
                        <tr>
                            <th scope="col" colspan="5" class="px-6 py-3 text-center text-lg">
                                CONCEPTO
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-lg">
                                VALOR
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($detalles as $item)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" colspan="5" class="px-3 py-1 font-medium text-gray-900 dark:text-white capitalize">
                                    {{$item->name}}
                                </th>
                                <td class="px-3 py-1 text-right font-medium text-gray-900">
                                    $ {{number_format($item->valor, 0, '.', '.')}}
                                </td>
                            </tr>
                        @endforeach
                        <tr class="bg-white dark:bg-gray-800">
                            <th scope="row" colspan="5" class="px-3 py-1 text-right text-gray-900 whitespace-nowrap dark:text-white uppercase">
                                TOTAL:
                            </th>
                            <td class="px-3 py-1 text-right font-medium text-gray-900">
                                $ {{number_format($obtener->valor_total, 0, '.', '.')}}
                            </td>
                        </tr>
                        <tr class="bg-white dark:bg-gray-800 border">
                            <th scope="row" colspan="6" class="px-3 py-1 text-xs text-gray-900 whitespace-nowrap dark:text-white">
                                <small class="capitalize">
                                    ESTADO DE CUENTA: Curso(s):
                                    @foreach ($matriculas as $item)
                                        {{$item->curso->name}}
                                    @endforeach
                                    Matriculas: $ {{number_format($total, 0, '.', '.')}},
                                    Pagos: $ {{number_format($total-$saldo, 0, '.', '.')}},
                                    Pendiente: $ {{number_format($saldo, 0, '.', '.')}}
                                </small>
                            </th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="border border-spacing-40 h-1 border-black"></div>

        <div>
            <div class="relative overflow-x-auto bg-slate-200 shadow-sm shadow-teal-200 m-1">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">

                                <a href="/financiera/recibopagos" wire:navigate>
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
                                <dd class="text-gray-500 dark:text-gray-400">Recibo N°:</dd>
                                <dt class="mb-2 text-xl font-extrabold">{{number_format($obtener->numero_recibo, 0, '.', '.')}}</dt>
                            </th>
                        </tr>
                        <tr>
                            <th scope="col" colspan="2" class="px-6 py-3 ">
                                <h1 class="text-justify capitalize">dirección sede: {{$obtener->sede->address}}</h1>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <h1 class="text-center capitalize">{{$obtener->medio}}</h1>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <h1 class="text-center  uppercase">{{$obtener->fecha}}</h1>
                            </th>
                        </tr>
                        <tr>
                            <th scope="col" colspan="2" class="px-6 py-3 ">
                                <h1 class="text-justify  uppercase"> cliente: {{$obtener->paga->name}}</h1>
                            </th>
                            <th scope="col" colspan="2" class="px-6 py-3">
                                <h1 class="text-justify text-xs capitalize">documento: {{$obtener->paga->documento}}</h1>
                            </th>
                        </tr>
                        <tr>
                            <th scope="col" colspan="2" class="px-6 py-3 ">
                                <h1 class="text-justify  capitalize"> teléfono cliente: {{$obtener->creador->perfil->celular}}</h1>
                            </th>
                            <th scope="col" colspan="2" class="px-6 py-3 ">
                                <h1 class="text-justify  capitalize"> Asesor: {{$obtener->creador->name}}</h1>
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>

            <div class="relative overflow-x-auto m-1 shadow-sm shadow-teal-300">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-slate-300 dark:bg-gray-700  dark:text-gray-400">
                        <tr>
                            <th scope="col" colspan="5" class="px-6 py-3 text-center text-lg">
                                CONCEPTO
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-lg">
                                VALOR
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($detalles as $item)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" colspan="5" class="px-3 py-1 font-medium text-gray-900 dark:text-white capitalize">
                                    {{$item->name}}
                                </th>
                                <td class="px-3 py-1 text-right font-medium text-gray-900">
                                    $ {{number_format($item->valor, 0, '.', '.')}}
                                </td>
                            </tr>
                        @endforeach
                        <tr class="bg-white dark:bg-gray-800">
                            <th scope="row" colspan="5" class="px-3 py-1 text-right text-gray-900 whitespace-nowrap dark:text-white uppercase">
                                TOTAL:
                            </th>
                            <td class="px-3 py-1 text-right font-medium text-gray-900">
                                $ {{number_format($obtener->valor_total, 0, '.', '.')}}
                            </td>
                        </tr>
                        <tr class="bg-white dark:bg-gray-800 border">
                            <th scope="row" colspan="6" class="px-3 py-1 text-xs text-gray-900 whitespace-nowrap dark:text-white">
                                <small class="capitalize">
                                    ESTADO DE CUENTA: Curso(s):
                                    @foreach ($matriculas as $item)
                                        {{$item->curso->name}}
                                    @endforeach
                                    Matriculas: $ {{number_format($total, 0, '.', '.')}},
                                    Pagos: $ {{number_format($total-$saldo, 0, '.', '.')}},
                                    Pendiente: $ {{number_format($saldo, 0, '.', '.')}}
                                </small>
                            </th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @else

        <div>
            <div class="relative overflow-x-auto bg-slate-200 shadow-sm shadow-teal-200 m-1">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">

                                <a href="{{$url}}" wire:navigate>
                                    <img class="h-12 w-16 rounded-sm" src="{{asset('img/logopol.jpg')}}" alt="{{env('APP_NAME')}}">
                                </a>

                            </th>
                            <th scope="col" class="px-6 py-3">
                                <h1 class="text-center  font-extrabold uppercase">POLIDOTACIONES</h1>
                                <h2 class="text-center  font-extrabold uppercase">nit: 1018 422.760</h2>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <h1 class="text-center  uppercase">sede:</h1>
                                <h1 class="text-center  font-extrabold uppercase">{{$obtener->sede->name}}</h1>
                            </th>
                            <th scope="col" class="px-6 py-3 text-center">
                                <dd class="text-gray-500 dark:text-gray-400">Recibo N°:</dd>
                                <dt class="mb-2 text-xl font-extrabold">{{number_format($obtener->numero_recibo, 0, '.', '.')}}</dt>
                            </th>
                        </tr>
                        <tr>
                            <th scope="col" colspan="2" class="px-6 py-3 ">
                                <h1 class="text-justify capitalize">dirección sede: {{$obtener->sede->address}}</h1>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <h1 class="text-center capitalize">{{$obtener->medio}}</h1>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <h1 class="text-center  uppercase">{{$obtener->fecha}}</h1>
                            </th>
                        </tr>
                        <tr>
                            <th scope="col" colspan="2" class="px-6 py-3 ">
                                <h1 class="text-justify  uppercase"> cliente: {{$obtener->paga->name}}</h1>
                            </th>
                            <th scope="col" colspan="2" class="px-6 py-3">
                                <h1 class="text-justify text-xs capitalize">documento: {{$obtener->paga->documento}}</h1>
                            </th>
                        </tr>
                        <tr>
                            <th scope="col" colspan="2" class="px-6 py-3 ">
                                <h1 class="text-justify  capitalize"> teléfono cliente: {{$obtener->creador->perfil->celular}}</h1>
                            </th>
                            <th scope="col" colspan="2" class="px-6 py-3 ">
                                <h1 class="text-justify  capitalize"> Asesor: {{$obtener->creador->name}}</h1>
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>

            <div class="relative overflow-x-auto m-1 shadow-sm shadow-teal-300">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-slate-300 dark:bg-gray-700  dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-center text-lg">
                                PRODUCTO
                            </th>
                            <th scope="col"  class="px-6 py-3 text-center text-lg">
                                CANTIDAD
                            </th>
                            <th scope="col" class="px-6 py-3 text-center text-lg">
                                UNITARIO
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-lg">
                                SUBTOTAL
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($detalles as $item)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td scope="row"  class=" text-gray-900 dark:text-white capitalize text-justify px-3 py-1">
                                    {{$item->producto}}
                                </td>
                                <td scope="row"  class=" text-gray-900 dark:text-white text-center px-3 py-1">
                                    {{$item->cantidad}}
                                </td>
                                <td class="text-right  text-gray-900 px-3 py-1">
                                    $ {{number_format($item->unitario, 0, '.', '.')}}
                                </td>
                                <td class="text-gray-900 text-right px-3 py-1">
                                    $ {{number_format($item->subtotal, 0, '.', '.')}}
                                </td>
                            </tr>
                        @endforeach
                        <tr class="bg-white dark:bg-gray-800">
                            <th scope="row" colspan="3" class="px-3 py-1 text-right text-gray-900  dark:text-white uppercase">
                                TOTAL:
                            </th>
                            <td class="px-3 py-1 text-right font-medium text-gray-900">
                                $ {{number_format($obtener->valor_total, 0, '.', '.')}}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="border border-spacing-40 h-1 border-black"></div>

        <div>
            <div class="relative overflow-x-auto bg-slate-200 shadow-sm shadow-teal-200 m-1">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">

                                <a href="{{$url}}" wire:navigate>
                                    <img class="h-12 w-16 rounded-sm" src="{{asset('img/logopol.jpg')}}" alt="{{env('APP_NAME')}}">
                                </a>

                            </th>
                            <th scope="col" class="px-6 py-3">
                                <h1 class="text-center  font-extrabold uppercase">POLIDOTACIONES</h1>
                                <h2 class="text-center  font-extrabold uppercase">nit: 1018 422.760</h2>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <h1 class="text-center  uppercase">sede:</h1>
                                <h1 class="text-center  font-extrabold uppercase">{{$obtener->sede->name}}</h1>
                            </th>
                            <th scope="col" class="px-6 py-3 text-center">
                                <dd class="text-gray-500 dark:text-gray-400">Recibo N°:</dd>
                                <dt class="mb-2 text-xl font-extrabold">{{number_format($obtener->numero_recibo, 0, '.', '.')}}</dt>
                            </th>
                        </tr>
                        <tr>
                            <th scope="col" colspan="2" class="px-6 py-3 ">
                                <h1 class="text-justify capitalize">dirección sede: {{$obtener->sede->address}}</h1>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <h1 class="text-center capitalize">{{$obtener->medio}}</h1>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <h1 class="text-center  uppercase">{{$obtener->fecha}}</h1>
                            </th>
                        </tr>
                        <tr>
                            <th scope="col" colspan="2" class="px-6 py-3 ">
                                <h1 class="text-justify  uppercase"> cliente: {{$obtener->paga->name}}</h1>
                            </th>
                            <th scope="col" colspan="2" class="px-6 py-3">
                                <h1 class="text-justify text-xs capitalize">documento: {{$obtener->paga->documento}}</h1>
                            </th>
                        </tr>
                        <tr>
                            <th scope="col" colspan="2" class="px-6 py-3 ">
                                <h1 class="text-justify  capitalize"> teléfono cliente: {{$obtener->creador->perfil->celular}}</h1>
                            </th>
                            <th scope="col" colspan="2" class="px-6 py-3 ">
                                <h1 class="text-justify  capitalize"> Asesor: {{$obtener->creador->name}}</h1>
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>

            <div class="relative overflow-x-auto m-1 shadow-sm shadow-teal-300">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-slate-300 dark:bg-gray-700  dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-center text-lg">
                                PRODUCTO
                            </th>
                            <th scope="col"  class="px-6 py-3 text-center text-lg">
                                CANTIDAD
                            </th>
                            <th scope="col" class="px-6 py-3 text-center text-lg">
                                UNITARIO
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-lg">
                                SUBTOTAL
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($detalles as $item)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td scope="row"  class=" text-gray-900 dark:text-white capitalize text-justify px-3 py-1">
                                    {{$item->producto}}
                                </td>
                                <td scope="row"  class=" text-gray-900 dark:text-white text-center px-3 py-1">
                                    {{$item->cantidad}}
                                </td>
                                <td class="text-right  text-gray-900 px-3 py-1">
                                    $ {{number_format($item->unitario, 0, '.', '.')}}
                                </td>
                                <td class="text-gray-900 text-right px-3 py-1">
                                    $ {{number_format($item->subtotal, 0, '.', '.')}}
                                </td>
                            </tr>
                        @endforeach
                        <tr class="bg-white dark:bg-gray-800">
                            <th scope="row" colspan="3" class="px-3 py-1 text-right text-gray-900  dark:text-white uppercase">
                                TOTAL:
                            </th>
                            <td class="px-3 py-1 text-right font-medium text-gray-900">
                                $ {{number_format($obtener->valor_total, 0, '.', '.')}}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    @endif


</div>
