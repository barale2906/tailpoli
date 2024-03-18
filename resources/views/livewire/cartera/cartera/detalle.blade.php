<div>

    <section class="bg-white dark:bg-gray-900">
        <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16">
            <div class="bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-8 md:p-12 mb-8">
                <h1 class="text-gray-900 dark:text-white text-3xl md:text-5xl font-extrabold mb-2">
                    A continuación se presenta el estado de cartera de: {{$actual->name}}.
                </h1>
                <p class="text-lg font-normal text-gray-500 dark:text-gray-400 mb-6">
                    Celular: {{$actual->perfil->}} Correo Elecrónico: {{$actual->email}}
                </p>
            </div>
            <div class="grid md:grid-cols-2 gap-8">
                <div class="bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-8 md:p-12">
                    <h2 class="text-gray-900 dark:text-white text-3xl font-extrabold mb-2">Cartera</h2>
                    <div class="relative overflow-x-auto">
                        <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3" >
                                        Fecha Programada
                                    </th>
                                    <th scope="col" class="px-6 py-3" >
                                        Fecha registro
                                    </th>
                                    <th scope="col" class="px-6 py-3" >
                                        Valor
                                    </th>
                                    <th scope="col" class="px-6 py-3" >
                                        Saldo
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
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                            {{$cartera->fecha_real}}
                                        </th>
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                            $ {{number_format($cartera->valor, 0, ',', '.')}}
                                        </th>
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                            $ {{number_format($cartera->saldo, 0, ',', '.')}}
                                        </th>
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                            {{$cartera->concepto}}
                                        </th>
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                            {{$cartera->observaciones}}
                                        </th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-8 md:p-12">
                    <h2 class="text-gray-900 dark:text-white text-3xl font-extrabold mb-2">
                        Recibos de pago
                    </h2>

        <div class="relative overflow-x-auto">
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
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200 text-sm">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                @if ($recibo->status===0)
                                    @can('fi_recibopagoAnular')
                                        <span class="bg-orange-100 text-orange-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-orange-900 dark:text-orange-300">
                                            <a href="#" wire:click.prevent="show({{$recibo}},{{0}})" class="inline-flex items-center font-medium text-orange-600 dark:text-orange-500 hover:underline">
                                                <i class="fa-solid fa-marker"></i> - {{$recibo->numero_recibo}}
                                            </a>
                                        </span>
                                    @endcan
                                @else
                                    {{$recibo->numero_recibo}}
                                @endif
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                                    <a href="/impresiones/imprecibo?rut=0&r={{$recibo->id}}" class="inline-flex items-center font-medium text-blue-600 dark:texgreen-500 hover:underline">
                                        <i class="fa-solid fa-print"></i>
                                    </a>
                                </span>
                                <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                                    <a href="#" wire:click.prevent="show({{$recibo}},{{2}})" class="inline-flex items-center font-medium text-green-600 dark:texgreen-500 hover:underline">
                                        <i class="fa-solid fa-binoculars"></i>
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
                </div>
            </div>
        </div>
    </section>

</div>
