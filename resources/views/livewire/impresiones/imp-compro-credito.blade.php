<div>
    @push('title')
        Compromiso de Crédito
    @endpush

    <h1 class="text-center  font-extrabold uppercase text-2xl">compromiso de crédito estudiantil</h1>

    <h1 class="text-center font-bold uppercase text-xl">
        {{$docuMatricula->curso->name}}
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
                                    Dirección: {{$docuMatricula->alumno->perfil->direccion}}
                                </h2>
                            </th>
                            <th scope="col" class="mt-2 pt-2 font-extrabold">

                                <a href="#" class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                                    <p class="font-normal text-gray-700 dark:text-gray-400 ">
                                        <br><br><br><br><br>
                                        Huella

                                    </p>
                                </a>

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
