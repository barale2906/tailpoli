<div>
    @push('title')
        Contrato N°: {{$id}}
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
                        <h1 class="text-center  font-extrabold uppercase text-xl">contrato de prestación de servicios educativos n°: {{$docuMatricula->id}}</h1>
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
    <div class="relative overflow-x-auto bg-slate-200 mt-2 mb-4 ring ring-black">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col">
                        <p class="text-justify text-sm uppercase">
                            NOMBRE DEL CURSO: <strong>{{$docuMatricula->curso->name}}</strong>
                        </p>
                        <p class="text-justify text-sm">
                            Duración del curso: <strong>{{-- {{$docuMatricula->curso->duracion_horas}} horas /  --}}{{$docuMatricula->curso->duracion_meses}} meses</strong>
                        </p>
                        <p class="text-justify text-sm">
                            Lugar:
                            <strong class="capitalize">
                                {{$docuMatricula->sede->name}} - {{$docuMatricula->sede->sector->name}}
                                - {{$docuMatricula->sede->sector->state->name}}
                            </strong>
                        </p>
                        <p class="text-justify text-sm">
                            Valor:
                            <strong>
                                $ {{number_format($docuMatricula->valor, 0, '.', '.')}}
                            </strong>
                        </p>

                        <p class="text-justify text-sm">
                            Pagaré Autorizado N°: {{$docuMatricula->id}}
                        </p>
                    </th>
                </tr>
            </thead>
        </table>
    </div>
    @foreach ($impresion as $item)
        @switch($item['tipo'])
            @case("firma")
                <div class="relative overflow-x-auto bg-slate-200 m-1">
                    <table class="w-full text-sm text-gray-500 text-justify dark:text-gray-400">
                        <thead class="text-center text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="mt-36 pt-20 font-extrabold">
                                    _______________________________________________________
                                </th>
                                <th scope="col" class="mt-36 pt-20 font-extrabold">
                                    _______________________________________________________
                                </th>
                            </tr>
                            <tr>
                                <th scope="col">
                                    <h1 class="uppercase text-sm font-bold">
                                        {{$docuMatricula->alumno->name}}
                                    </h1>
                                    <h2 class="capitalize text-sm">
                                        {{$docuMatricula->alumno->perfil->tipo_documento}}: {{$docuMatricula->alumno->documento}}
                                    </h2>
                                </th>
                                <th scope="col">
                                    <h1 class="uppercase text-sm font-bold">
                                        {{config('instituto.nombre_empresa')}}
                                    </h1>
                                    <h2 class="capitalize text-sm">
                                        NIT: {{config('instituto.nit')}}
                                    </h2>
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
