<div class="p-3">
    <h3 class="text-justify text-lg p-1">
        Por favor utilice las siguientes palabras clave para agregar campos de datos a sus documentos, por ejemplo si quiere que aparezca el nombre del estudiante copie y pegue la palabra clave: <strong>nombreEstu</strong>, es importante que las copie y pegue tal cual y como aparecen en esta lista.
    </h3>
    <div class="grid mb-8 border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 md:mb-12 sm:grid-cols-1 md:grid-cols-4">
        @foreach ($palabras as $item)
            <figure class="flex flex-col items-center justify-center p-2 text-center bg-white border-b border-gray-200 rounded-t-lg md:rounded-t-none md:rounded-tl-lg md:border-r dark:bg-gray-800 dark:border-gray-700">
                <blockquote class="max-w-2xl mx-auto mb-4 text-gray-500 lg:mb-8 dark:text-gray-400">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{$item->palabra}}</h3>
                    <p class="my-4 capitalize">{{$item->descripcion}}</p>
                </blockquote>
            </figure>
        @endforeach
    </div>
</div>
