<div>
    @push('title')
        Contrato N°: {{$id}}
    @endpush

    <div class="relative overflow-x-auto bg-slate-200 shadow-sm shadow-teal-200 m-1">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">

                        <a href="{{$ruta}}" wire:navigate>
                            <img class="h-12 w-16 rounded-sm" src="{{asset('img/logo.jpeg')}}" alt="{{env('APP_NAME')}}">
                        </a>

                    </th>
                    <th scope="col" class="px-6 py-3">
                        <h1 class="text-center  font-extrabold uppercase">POLIANDINO</h1>
                        <h2 class="text-center  font-extrabold uppercase">nit: 900656857-5</h2>
                        <h2 class="text-center  font-extrabold uppercase">INSTITUTO DE CAPACITACIÓN POLIANDINO CENTRAL</h2>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <h1 class="text-center  uppercase">sede:</h1>
                        <h1 class="text-center  font-extrabold uppercase">{{$obtener->sede->name}}</h1>
                    </th>
                    <th scope="col" class="px-6 py-3 text-center">
                        <dd class="text-gray-500 dark:text-gray-400">Cierre N°:</dd>
                        <dt class="mb-2 text-xl font-extrabold">{{number_format($id, 0, '.', '.')}}</dt>
                    </th>
                </tr>
            </thead>
        </table>
    </div>
</div>
