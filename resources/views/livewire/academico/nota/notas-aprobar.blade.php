<div>
    <div class="p-4 mb-4 sm:col-span-1 md:col-span-4 text-red-800 text-2xl text-center rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
        <span class="font-medium">¡SEGURO(A)!</span> Esta operación es irreversible.
    </div>
    <div class="bg-green-100 rounded-s-sm m-3 p-2">
        <h2 class="text-4xl uppercase text-center ">Nota Final: <strong>{{$datoEstudiante->acumulado}}</strong>, calificaciones por cada item</h2>
        <dl class="grid max-w-screen-xl grid-cols-4 gap-3 mx-auto text-gray-900 sm:grid-cols-2 xl:grid-cols-6 dark:text-white sm:p-8">
            @foreach ($encabezado as $item)
                <div class="flex flex-col items-center justify-center">
                    <dt class="mb-2 text-3xl font-extrabold">{{$item['obtenidoNota']}} - {{$item['acumnota']}}</dt>
                    <dd class="text-gray-500 dark:text-gray-400 capitalize">{{$item['califica']}} - {{$item['porcentaje']}} %</dd>
                </div>
            @endforeach
        </dl>
    </div>
</div>
