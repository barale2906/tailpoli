<div class="border bg-cyan-50 border-cyan-500 mb-3 p-2 rounded-xl">
    <h1 class=" text-center font-bold uppercase mb-3">
        Ver historial de contratación de: {{$actual->user->name}}
    </h1>

    <div class="relative overflow-x-auto">

        <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3" >

                    </th>
                    <th scope="col" class="px-6 py-3" >
                        Nombre del documento
                    </th>
                    <th scope="col" class="px-6 py-3" >
                        Fecha del documento
                    </th>
                    <th scope="col" class="px-6 py-3" >
                        Tipo de documento
                    </th>
                    <th scope="col" class="px-6 py-3" >
                        Estatus
                    </th>
                    <th scope="col" class="px-6 py-3" >
                        Ver documento
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($docucontras as $item)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">

                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                            {{$item->name}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{$item->fecha_documento}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                            {{$documentosFuncionarios[$item->tipo]}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                            {{$estados[$item->status]}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                            <a href="{{Storage::url($item->ruta)}}" target="_blank">
                                <button type="button" class="px-4 py-2 text-sm font-medium text-gray-900 bg-blue-400 border border-gray-200 rounded-lg hover:bg-green-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                                    Ver
                                </button>
                            </a>
                        </th>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
