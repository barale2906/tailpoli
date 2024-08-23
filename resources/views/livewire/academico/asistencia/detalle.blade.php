<div>
    <table class=" text-xs md:text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3" >
                    Grupo - Modulo
                </th>
                @foreach ($encabezados as $item)
                    <th scope="col" class="px-6 py-3">
                        {{$item}}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-cyan-100">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 capitalize text-xs dark:text-white">
                    {{$grupo}}
                </th>
                @foreach ($encabezados as $item)
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap text-xs dark:text-white">
                        @if ($asistencias)
                            @foreach ($asistencias as $value)
                                @if ($item===$value->fecha_asis)
                                    <i class="fa-solid fa-check"></i>
                                @endif
                            @endforeach
                        @endif
                    </th>
                @endforeach
            </tr>
        </tbody>
    </table>
</div>
