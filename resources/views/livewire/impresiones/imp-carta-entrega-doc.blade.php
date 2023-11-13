<div>
    @push('title')
        Carta Entrega Documentos {{$docuMatricula->alumno->name}}
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
                        <h1 class="text-center  font-extrabold uppercase text-2xl">carta de compromiso entrega de documentos</h1>
                    </th>
                    <th scope="col" class="text-justify">
                        <h1 class="text-sm font-bold">Fecha:</h1>
                        <h1 class="text-sm font-bold">{{$docuTipo->fecha}}</h1>
                    </th>
                </tr>
            </thead>
        </table>
    </div>

    @foreach ($impresion as $item)
        @switch($item['tipo'])
            @case("firma")


                <h1 class="text-lg text-justify mb-3">
                    Se firma el: {{$fechaMes}}
                </h1>

                <div class="relative overflow-x-auto bg-slate-200">
                    <table class="w-full text-sm text-gray-500 text-justify dark:text-gray-400">
                        <thead class="text-center text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="font-extrabold">
                                    <h1 class="text-lg text-justify mb-12 capitalize">
                                        ACEPTADO:
                                    </h1>
                                    <h1 class="text-lg text-justify mt-24 capitalize">
                                        ____________________________________
                                    </h1>
                                    <h1 class="text-lg text-justify capitalize">
                                        nombre: <strong class="uppercase">{{$docuMatricula->alumno->name}}</strong>
                                    </h1>
                                    <h1 class="text-lg text-justify capitalize">
                                        {{$docuMatricula->alumno->perfil->tipo_documento}}: <strong class="uppercase">{{$docuMatricula->alumno->perfil->documento}}</strong>
                                    </h1>
                                    <h1 class="text-lg text-justify capitalize">
                                        Número Celular<strong>{{$docuMatricula->alumno->perfil->celular}}</strong>
                                    </h1>
                                    <h1 class="text-lg text-justify capitalize">
                                        Correo:<strong>{{$docuMatricula->alumno->email}}</strong>
                                    </h1>
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
