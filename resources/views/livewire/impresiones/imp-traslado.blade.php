<div>
    @push('title')
        Remisión N°: {{$fecha}}
    @endpush
    <div>
        <div class="relative overflow-x-auto bg-slate-200 shadow-sm shadow-teal-200 m-1">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">

                            <a href="{{$url}}" wire:navigate>
                                <img class="h-12 w-16 rounded-sm" src="{{asset('img/logopol.jpg')}}" alt="{{env('APP_NAME')}}">
                            </a>

                        </th>
                        <th scope="col" class="px-6 py-3">
                            <h1 class="text-center  font-extrabold uppercase">POLIDOTACIONES</h1>
                            <h2 class="text-center  font-extrabold uppercase">1018 422.760</h2>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <h1 class="text-center  uppercase">sede envía:</h1>
                            <h1 class="text-center  font-extrabold uppercase">{{$sedenv}}</h1>
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            <dd class="text-gray-500 dark:text-gray-400">Remisión N°:</dd>
                            <dt class="mb-2 text-xl font-extrabold">{{$fecha}}</dt>
                        </th>
                    </tr>
                    <tr>
                        <th scope="col" colspan="1" class="px-6 py-3 ">
                            <h1 class="text-justify  uppercase"> Traslado N°: {{$traslado}}</h1>
                        </th>
                        <th scope="col" colspan="1" class="px-6 py-3 ">
                            <h1 class="text-justify  uppercase"> Almacén Envía: {{$envia}}</h1>
                        </th>
                        <th scope="col" colspan="2" class="px-6 py-3">
                            <h1 class="text-justify text-xs capitalize">Dirección: {{$envDireccion}}</h1>
                        </th>
                    </tr>
                    <tr>
                        <th scope="col" colspan="1" class="px-6 py-3 ">
                            <h1 class="text-justify  uppercase"> Sede Destino: {{$sederec}}</h1>
                        </th>
                        <th scope="col" colspan="1" class="px-6 py-3 ">
                            <h1 class="text-justify  capitalize"> Almacén: {{$recibe}}</h1>
                        </th>
                        <th scope="col" colspan="2" class="px-6 py-3 ">
                            <h1 class="text-justify  capitalize"> Dirección: {{$recDireccion}}</h1>
                        </th>
                    </tr>
                </thead>
            </table>

        </div>

        <div class="relative overflow-x-auto m-1 shadow-sm shadow-teal-300">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-slate-300 dark:bg-gray-700  dark:text-gray-400">
                    <tr>
                        <th scope="col" colspan="5" class="px-6 py-3 text-center text-lg">
                            PRODUCTO
                        </th>
                        <th scope="col" class="px-6 py-3 text-center text-lg">
                            CANTIDAD
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($documento as $item)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row" colspan="5" class="px-3 py-1 font-medium text-gray-900 dark:text-white capitalize">
                                {{$item->producto->name}}
                            </th>
                            <td class="px-3 py-1 text-center font-medium text-gray-900">
                                {{$item->cantidad}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <h3 class="text-justify text-xl m-3">
            Firma Recibido: ________________________________________________________
        </h3>

    </div>

    <div class="border border-spacing-40 h-1 border-black"></div>

    <div>
        <div class="relative overflow-x-auto bg-slate-200 shadow-sm shadow-teal-200 m-1">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">

                            <a href="{{$url}}" wire:navigate>
                                <img class="h-12 w-16 rounded-sm" src="{{asset('img/logopol.jpg')}}" alt="{{env('APP_NAME')}}">
                            </a>

                        </th>
                        <th scope="col" class="px-6 py-3">
                            <h1 class="text-center  font-extrabold uppercase">POLIDOTACIONES</h1>
                            <h2 class="text-center  font-extrabold uppercase">1018 422.760</h2>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <h1 class="text-center  uppercase">sede envía:</h1>
                            <h1 class="text-center  font-extrabold uppercase">{{$sedenv}}</h1>
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            <dd class="text-gray-500 dark:text-gray-400">Remisión N°:</dd>
                            <dt class="mb-2 text-xl font-extrabold">{{$fecha}}</dt>
                        </th>
                    </tr>
                    <tr>
                        <th scope="col" colspan="1" class="px-6 py-3 ">
                            <h1 class="text-justify  uppercase"> Traslado N°: {{$traslado}}</h1>
                        </th>
                        <th scope="col" colspan="1" class="px-6 py-3 ">
                            <h1 class="text-justify  uppercase"> Almacén Envía: {{$envia}}</h1>
                        </th>
                        <th scope="col" colspan="2" class="px-6 py-3">
                            <h1 class="text-justify text-xs capitalize">Dirección: {{$envDireccion}}</h1>
                        </th>
                    </tr>
                    <tr>
                        <th scope="col" colspan="1" class="px-6 py-3 ">
                            <h1 class="text-justify  uppercase"> Sede Destino: {{$sederec}}</h1>
                        </th>
                        <th scope="col" colspan="1" class="px-6 py-3 ">
                            <h1 class="text-justify  capitalize"> Almacén: {{$recibe}}</h1>
                        </th>
                        <th scope="col" colspan="2" class="px-6 py-3 ">
                            <h1 class="text-justify  capitalize"> Dirección: {{$recDireccion}}</h1>
                        </th>
                    </tr>
                </thead>
            </table>

        </div>

        <div class="relative overflow-x-auto m-1 shadow-sm shadow-teal-300">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-slate-300 dark:bg-gray-700  dark:text-gray-400">
                    <tr>
                        <th scope="col" colspan="5" class="px-6 py-3 text-center text-lg">
                            PRODUCTO
                        </th>
                        <th scope="col" class="px-6 py-3 text-center text-lg">
                            CANTIDAD
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($documento as $item)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row" colspan="5" class="px-3 py-1 font-medium text-gray-900 dark:text-white capitalize">
                                {{$item->producto->name}}
                            </th>
                            <td class="px-3 py-1 text-center font-medium text-gray-900">
                                {{$item->cantidad}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <h3 class="text-justify text-xl m-3">
            Firma Recibido: ________________________________________________________
        </h3>

    </div>

</div>
