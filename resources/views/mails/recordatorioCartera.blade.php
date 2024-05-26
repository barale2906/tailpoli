<x-imprimir-layout>

    <div class="relative overflow-x-auto bg-slate-200 shadow-sm shadow-teal-200 m-1">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">

                        <a href="" wire:navigate>
                            <img class="h-12 w-16 rounded-sm" src="{{asset('img/logomin.jpeg')}}" alt="{{env('APP_NAME')}}">
                        </a>

                    </th>
                    <th scope="col" class="px-6 py-3">
                        <h1 class="text-center  font-extrabold uppercase">POLIANDINO</h1>
                        <h2 class="text-center  font-extrabold uppercase">nit: 900656857-5</h2>
                        <h2 class="text-center  font-extrabold uppercase">INSTITUTO DE CAPACITACIÓN POLIANDINO CENTRAL</h2>
                    </th>
                    <th scope="col" class="px-6 py-3 text-center">
                        <dd class="text-gray-500 dark:text-gray-400">Curso:</dd>
                        <dt class="mb-2 text-xl font-extrabold">{{$cartera->matricula->curso->name}}</dt>
                        {{$hoy}} - {{$cartera->fecha_pago}}
                    </th>
                </tr>
            </thead>
        </table>
        @if ($cartera->fecha_pago>$hoy)
            <p class="font-normal m-4 text-gray-700 dark:text-gray-400">
                Buenos días
                <span class=" uppercase font-extrabold">{{$cartera->responsable->name}}</span>
                pensando en tus finanzas el
                <span class=" font-extrabold">
                    INSTITUTO DE CAPACITACIÓN POLIANDINO CENTRAL
                </span>
                te recuerda que el {{$cartera->fecha_pago}} es el día de pago de tu curso por $ {{number_format($cartera->saldo, 0, '.', '.')}}, realiza tus presupuestos y no olvides realizar el pago.
            </p>
            <p class="font-normal m-4 text-gray-700 dark:text-gray-400">
                Mientras tanto te esperamos en clase. Muchas gracias.
            </p>
        @else

            <p class="font-normal m-4 text-gray-700 dark:text-gray-400">
                ¡ES HOY! ¡ES HOY! si <span class=" uppercase font-extrabold">{{$cartera->responsable->name}}</span> recuerda que hoy es el día de pago de tu curso, sigue disfrutando de tus clases y ten presente realizar el pago respectivo por <span>$ {{number_format($cartera->saldo, 0, '.', '.')}}</span>
            </p>
            <p class="font-normal m-4 text-gray-700 dark:text-gray-400">
                Si ya realizaste el pago, has caso omiso a este mensaje y nos vemos en clase. Muchas gracias.
            </p>
        @endif

    </div>
</x-imprimir-layout>
