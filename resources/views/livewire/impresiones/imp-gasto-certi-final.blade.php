<div>
    @push('title')
        Gasto Certificación Final {{$docuMatricula->alumno->name}}
    @endpush

    <div class="relative overflow-x-auto bg-slate-200  m-1">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">

                        <a href="" wire:navigate>
                            <img class="h-12 w-16 rounded-sm" src="{{asset('img/logo.jpeg')}}" alt="{{env('APP_NAME')}}">
                        </a>

                    </th>
                    <th scope="col" class="px-2 py-1">
                        <h1 class="text-center  font-extrabold uppercase text-2xl">{{config('instituto.nombre_empresa')}}</h1>
                    </th>
                    <th scope="col" class="text-justify">
                        <h1 class="text-sm font-bold">Fecha:</h1>
                        <h1 class="text-sm font-bold">
                            @foreach ($docuTipo as $item)
                                {{$item->fecha}}
                            @endforeach
                        </h1>
                    </th>
                </tr>
            </thead>
        </table>
    </div>

    <h1 class=" text-center text-lg font-extrabold uppercase">
        Compromiso conocimiento de gastos de certificación y/o constancia final
    </h1>

    @foreach ($impresion as $item)
        @switch($item['tipo'])
            @case("firma")
                <div class="relative overflow-x-auto bg-slate-200">
                    <table class="w-full text-sm text-gray-500 text-justify dark:text-gray-400">
                        <thead class="text-center text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="mt-36 pt-20 font-extrabold">
                                    <h2 class="text-justify text-sm capitalize mt-5">
                                        Firma: ____________________________________________________
                                    </h2>
                                    <h2 class="text-justify text-sm capitalize">
                                        Nombre: {{$docuMatricula->alumno->name}}
                                    </h2>
                                    <h2 class="text-justify text-sm capitalize">
                                        Cédula: {{$docuMatricula->alumno->documento}}
                                    </h2>
                                    <h2 class="text-justify text-sm capitalize">
                                        Célular: {{$docuMatricula->alumno->perfil->celular}}
                                    </h2>
                                    <h2 class="text-justify text-sm capitalize">
                                        Correo Electrónico: {{$docuMatricula->alumno->email}}
                                    </h2>
                                </th>
                                <th scope="col" class="mt-2 pt-2 font-extrabold">

                                </th>
                            </tr>
                        </thead>
                    </table>
                </div>
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
                                    <th scope="col" class="px-6 py-3 text-center text-xs">
                                        Días de retraso
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs">
                                        Saldo
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
                            A la fecha del {{$fecha}}, su deuda es de: <strong>$ {{number_format($deuda   , 0, '.', '.')}}</strong>
                        </h1>
                    </div>
                @else
                    <div class="p-4 text-sm text-gray-800 rounded-lg bg-gray-50 dark:bg-gray-800 dark:text-gray-300" role="alert">
                        <span class="font-medium">¡Pago de Contado!</span> Según lo especificado al momento de la matricula.
                    </div>
                @endif
                @break
            @default
                <div class="relative overflow-x-auto bg-slate-200 mt-16">
                    <table class="w-full text-lg text-gray-500 text-justify dark:text-gray-400">
                        <thead class="text-lg text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
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
