<div>
    <div class="py-1 px-4 mx-auto max-w-screen-xl lg:py-16">
        <div class="bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg md:p-12 mb-8">
            <h1 class="text-gray-900 dark:text-white text-xl md:text-2xl font-extrabold mb-2">
                A continuación se presenta el estado de cartera de: <span class=" uppercase font-extrabold">{{$actual->name}}</span>, con el documento <span class=" uppercase font-extrabold">{{$actual->documento}}</span>.
            </h1>
            <p class="text-lg font-normal text-gray-500 dark:text-gray-400 mb-6">
                Celular: {{$actual->perfil->celular}} Correo Elecrónico: {{$actual->email}}
            </p>
            <p class="text-lg font-normal text-gray-500 dark:text-gray-400 mb-6">
                Total Cartera: $
                @if ($total)
                    {{number_format($total->saldo, 0, ',', '.')}}, un valor pagado a la fecha de: $ {{number_format($carteras->sum('valor')-$total->saldo, 0, ',', '.')}}, de una cartera inicial de $ {{number_format($carteras->sum('valor'), 0, ',', '.')}}
                @else
                    un valor pagado a la fecha de: $ {{number_format($carteras->sum('valor'), 0, ',', '.')}}, de una cartera inicial de $ {{number_format($carteras->sum('valor'), 0, ',', '.')}}
                @endif

                <a href="" wire:click.prevent="$dispatch('cancelando')" class="text-black bg-gradient-to-r from-blue-300 via-blue-400 to-blue-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-200 dark:focus:ring-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                    <i class="fa-solid fa-backward"></i> Volver
                </a>
            </p>
            <h1 class=" text-center uppercase">
                matriculas de este estudiante
            </h1>
            <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3"  >
                            N°
                        </th>
                        <th scope="col" class="px-6 py-3"  >
                            Fecha Creación
                        </th>
                        <th scope="col" class="px-6 py-3"  >
                            Fecha Inicia
                        </th>
                        <th scope="col" class="px-6 py-3"  >
                            Sede
                        </th>
                        <th scope="col" class="px-6 py-3"  >
                            Curso
                        </th>
                        <th scope="col" class="px-6 py-3"  >
                            Estudiante
                        </th>
                        <th scope="col" class="px-6 py-3"  >
                            Valor
                        </th>
                        <th scope="col" class="px-6 py-3"  >
                            Método de Pago
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            Matriculo
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($matricu as $matricula)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-400">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{$matricula->id}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                {{$matricula->created_at}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{$matricula->fecha_inicia}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                {{$matricula->sede->name}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                {{$matricula->curso->name}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                {{$matricula->alumno->name}} -- {{number_format($matricula->alumno->documento, 0, ',', '.')}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                $ {{number_format($matricula->valor, 0, ',', '.')}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                {{$matricula->metodo}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                {{$matricula->creador->name}}
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <nav class="dark:bg-gray-700 rounded-lg">
        <div class="max-w-screen-xl mx-auto">
            <div class="flex items-center">
                <ul class="flex flex-row font-medium mt-0 space-x-8 text-sm capitalize">
                    <li class="{{$carterastate ? 'bg-green-100': ''}} p-4">
                        <a href="#" wire:click.prevent="cambiaVista()" class="text-gray-900 dark:text-white hover:underline" aria-current="page">
                            Cartera
                        </a>
                    </li>
                    <li class="{{$recibostate ? 'bg-orange-100': ''}} p-4">
                        <a href="#" wire:click.prevent="cambiaVista()" class="text-gray-900 dark:text-white hover:underline">
                            Recibos de Pago
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    @if ($carterastate)
        <div class="{{$carterastate ? 'bg-green-100': ''}} p-2">
            <h5 class="text-xl uppercase text-center ">Registros de Cartera</h5>
            <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3" >
                            Fecha Programada
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            Fecha Registro Pago
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            Valor
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            Saldo
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            Días de Retraso
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            Concepto
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            Observaciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($carteras as $cartera)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{$cartera->fecha_pago}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                {{$cartera->fecha_real}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                $ {{number_format($cartera->valor, 0, ',', '.')}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                $ {{number_format($cartera->saldo, 0, ',', '.')}}
                            </th>
                            <th scope="row" class="px-3 py-1 text-right text-red-700 text-xs  dark:text-white uppercase">
                                @if ($cartera->status<5)
                                    @if ($cartera->fecha_pago < $fecha)
                                        @php
                                            $fecha1 = date_create($cartera->fecha_pago);
                                            $dias = date_diff($fecha1, $fecha)->format('%R%a');
                                        @endphp
                                        {{$dias}} días
                                    @endif
                                @else
                                    Fecha pago: {{$cartera->fecha_real}}
                                @endif
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                {{$cartera->concepto}} - {{$cartera->matricula->curso->name}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                                {{$cartera->observaciones}}
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    @if ($recibostate)
        <div class="{{$recibostate ? 'bg-orange-100': ''}} p-2">
            <h5 class="text-xl uppercase text-center ">Recibos de pago</h5>
            <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3" >
                            No
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            Fecha
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            Alumno
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            Sede
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            Valor
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            Medio
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            Observaciones
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            Creador
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recibos as $recibo)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-orange-200 text-sm">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">

                                <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                                    <a href="/impresiones/imprecibo?rut=0&r={{$recibo->id}}" class="inline-flex items-center font-medium text-blue-600 dark:texgreen-500 hover:underline">
                                        <i class="fa-solid fa-print"></i>
                                    </a>
                                </span>

                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                {{$recibo->fecha}}
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
        </div>
    @endif

</div>
