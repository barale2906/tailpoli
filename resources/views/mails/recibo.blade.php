<x-imprimir-layout>

    <a href="" class="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow md:flex-row md:max-w-xl hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
        <img class="object-cover h-20 w-28 rounded-sm rounded-t-lg " src="{{asset('img/logo.jpeg')}}" alt="{{$recibo->paga->name}}">
        <div class="flex flex-col justify-between p-4 leading-normal">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                Haz realizado un pago por $ {{number_format($recibo->valor_total, 0, '.', ' ')}}
            </h5>
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                Muchas gracias por tu pago <span class="uppercase font-semibold">{{$recibo->paga->name}}</span>
            </p>
        </div>
    </a>


</x-imprimir-layout>
