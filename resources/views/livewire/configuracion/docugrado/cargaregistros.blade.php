<div>
    <h2 class=" capitalize text-center bg-gray-400 rounded-full text-2xl">
        Cargar registros de graduandos
    </h2>
    <ul class="font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white text-xl">
        <li class="w-full px-4 py-2 border-b border-gray-200 rounded-t-lg dark:border-gray-600">
            Descargue el archivo anexo en este <a href="{{ asset('csv/ejemplo_graduaciones.csv') }}" target="_blank">LINK</a>
        </li>
        <li class="w-full px-4 py-2 border-b border-gray-200 dark:border-gray-600">
            Diligencie todos los campos con base en el ejemplo del archivo.
        </li>
        <li class="w-full px-4 py-2 border-b border-gray-200 dark:border-gray-600">
            Recuerde que todas las fechas deben ser bajo el formato AAAA-MM-DD, este se obtiene en excel dando clic derecho sobre el campo Formato de celdas, Personalizado y donde dice Tipo: borrar lo que haya escrito y escribir el formato YYYY-MM-DD.
        </li>
        <li class="w-full px-4 py-2 border-b border-gray-200 dark:border-gray-600 uppercase font-extrabold">
            Elimine todas las filas de ejemplo.
        </li>
        <li class="w-full px-4 py-2 rounded-b-lg">
            Guarde el archivo sin cambiar el tipo de formato (csv).
        </li>
        <li class="w-full px-4 py-2 rounded-b-lg">
            Cargue el archivo generado.
        </li>
    </ul>
    <div class="w-full p-4 text-center bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
        <div class="grid sm:grid-cols-1 md:grid-cols-4 gap-4">
            <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2">
                <label for="archivo" class="block mb-2 text-xs md:text-sm font-medium text-gray-900 dark:text-white">
                    Seleccione el archivo
                </label>
                <div class="relative z-0 w-full mb-5 group">
                    <input type="file" wire:model.live="archivo" accept=".csv" class="block py-2.5 px-0 w-full text-xs md:text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"  />
                    <label for="archivo" class="peer-focus:font-medium absolute text-xs md:text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Archivo</label>
                </div>
            </div>
            @if ($archivo)
                <a href="" wire:click.prevent="cargar()" class="text-black bg-blue-300 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-200 dark:focus:ring-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                    <i class="fa-solid fa-upload"></i> Guardar registros
                </a>
            @endif
        </div>
    </div>
    @if ($is_errores)
        @foreach ($crterrores as $item)
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                <span class="font-medium">Error:</span> {{$item}}.
            </div>
        @endforeach
    @endif
</div>
