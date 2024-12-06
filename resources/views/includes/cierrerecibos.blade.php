<table class=" text-sm text-left text-gray-500 dark:text-gray-400 m-2">
    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th scope="col" class="px-6 py-3" >
                ID
            </th>
            <th scope="col" class="px-6 py-3">
                Fecha
            </th>
            <th scope="col" class="px-6 py-3" >
                Alumno
            </th>
            <th scope="col" class="px-6 py-3">
                Observaciones
            </th>
            <th scope="col" class="px-6 py-3" >
                Medio
            </th>
            <th scope="col" class="px-6 py-3">
                Valor Total
            </th>
            <th scope="col" class="px-6 py-3">
                Valor Descuento
            </th>
            <th scope="col" class="px-6 py-3">
                Valor Neto
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($recibos as $recibo)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200 text-sm">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{$recibo->numero_recibo}}
                </th>
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                    {{$recibo->fecha}}
                </th>
                <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                    {{$recibo->paga->name}}
                </th>
                <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                    {{$recibo->observaciones}}
                </th>
                <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                    {{$recibo->medio}}
                </th>
                <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                    $ {{number_format($recibo->valor_total, 0, ',', '.')}}
                </th>
                <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                    $ {{number_format($recibo->descuento, 0, ',', '.')}}
                </th>
                <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                    $ {{number_format($recibo->valor_total-$recibo->descuento, 0, ',', '.')}}
                </th>
            </tr>
        @endforeach
    </tbody>
</table>
