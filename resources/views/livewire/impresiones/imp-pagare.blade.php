<div>
    @push('title')
        Pagare N°: {{$id}}
    @endpush
    <h1 class="text-center text-3xl uppercase font-extrabold">Pagare N°: {{$id}}</h1>
    <h2 class="text-justify text-sm uppercase">
        LUGAR Y FECHA: ___________________________________
    </h2>
    <h2 class="text-justify text-sm uppercase">
        VALOR: $ _________________________________________
    </h2>
    <h2 class="text-justify text-sm uppercase">
        INTERESES DE MORA: __ %
    </h2>
    <h2 class="text-rigth text-sm uppercase">
        PERSONA A QUIEN DEBE HACERSE EL PAGO: {{config('instituto.nombre_empresa')}}
    </h2>
    <h2 class="text-rigth text-sm uppercase">
        LUGAR DONDE SE EFECTUARÁ EL PAGO: {{config('instituto.direccion')}}
    </h2>
    <h2 class="text-left text-sm uppercase">
        FECHA DE VENCIMIENTO DE LA OBLIGACIÓN: __________________________________
    </h2>
    <h2 class="text-justify text-sm capitalize m-5">
        DEUDORES:
    </h2>
    <h2 class="text-justify text-sm capitalize">
        Nombre: _________________________________________________________________________________________________________________
    </h2>
    <h2 class="text-justify text-sm capitalize">
        Identificación: _________________________________________________________________________________________________________
    </h2>
    <h2 class="text-justify text-sm capitalize">
        Nombre: _________________________________________________________________________________________________________________
    </h2>
    <h2 class="text-justify text-sm capitalize">
        Identificación: _________________________________________________________________________________________________________
    </h2>
    <h2 class="text-justify text-sm capitalize m-3">
        DECLARAMOS:
    </h2>

    @foreach ($impresion as $item)
        @switch($item['tipo'])
            @case("firma")
                <h1 class="text-xs text-justify">
                    En constancia de lo anterior, se suscribe este documento el día: <strong>{{$fecha->day}}</strong>, del mes: <strong>{{$fecha->month}}</strong> del año: <strong>{{$fecha->year}}</strong>
                </h1>
                <h2 class="text-justify text-sm capitalize mt-5">
                    Firma: _________________________________________________________________________________________________________________
                </h2>
                <h2 class="text-justify text-sm capitalize mt-5">
                    Nombre: _________________________________________________________________________________________________________
                </h2>
                <h2 class="text-justify text-sm capitalize mt-5">
                    Cédula: _______________________________________________________________________________________________________
                </h2>
                <h2 class="text-justify text-sm capitalize mt-5">
                    Dirección: _________________________________________________________________________________________________________
                </h2>
                @break

            @case("formaPago")
                @if ($docuFormaP->cuotas>0)
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
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($docuCartera as $item)
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
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-4 text-sm text-gray-800 rounded-lg bg-gray-50 dark:bg-gray-800 dark:text-gray-300" role="alert">
                        <span class="font-medium">¡Pago de Contado!</span> Según lo especificado al momento de la matricula.
                    </div>
                @endif
                @break
            @default
                <div class="relative overflow-x-auto bg-slate-200 m-1">
                    <table class="w-full text-sm text-gray-500 text-justify dark:text-gray-400">
                        <thead class="text-xs text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col">
                                    {{$item['contenido']}}
                                </th>
                            </tr>
                        </thead>
                    </table>
                </div>
        @endswitch
    @endforeach

</div>
