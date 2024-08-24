<div>
    <table class=" text-xs md:text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3" >
                    Grupo - Modulo
                </th>
                @foreach ($encabezado as $item)
                    <th scope="col" class="px-6 py-3">
                        {{$nots->$item}}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-cyan-100">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 capitalize text-xs dark:text-white">
                    {{$notas->grupo}}
                </th>
                @foreach ($encabezado as $item)
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap text-xs dark:text-white">
                        {{$notas->$item}}
                    </th>
                @endforeach
            </tr>
        </tbody>
    </table>
</div>
