<div>
    <h1 class=" text-lg uppercase font-semibold text-center">
        planes acádemicos cargados para el curso: {{$actual->name}}
    </h1>
    <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-4">
        <div class="mb-6">
            <label for="nombre" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre del Documento</label>
            <input  id="nombre" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nombre" wire:model.blur="nombre">
            @error('nombre')
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                </div>
            @enderror
        </div>

        <div class="mb-6">
            <label for="word" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cargar archivo word - excel</label>
            <input type="file" accept=".doc, .docx, .xls, .xlsx" id="word" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full m-2 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.live="word">
            @error('word')
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                </div>
            @enderror
            <div wire:loading wire:target="word" class="text-center text-xl font-extrabold text-orange-500 uppercase">Cargando</div>
        </div>

        <div class="mb-6">
            <label for="pdf" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cargar archivo pdf</label>
            <input type="file" accept=".pdf" id="pdf" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full m-2 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.live="pdf">
            @error('pdf')
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                </div>
            @enderror
            <div wire:loading wire:target="pdf" class="text-center text-xl font-extrabold text-orange-500 uppercase">Cargando</div>
        </div>

        @if ($word && $pdf)
            <a href="" wire:click.prevent="cargar" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                <i class="fa-solid fa-upload"></i> Cargar Plan
            </a>
        @endif

    </div>
    <div class="relative overflow-x-auto">
        <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3" >
                        Nomre del Documento
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Descargar documentos
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Estado
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($actual->planes as $item)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                            {{$item->name}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">


                            <div class="inline-flex rounded-md shadow-sm" role="group">
                                <a href="{{Storage::url($item->ruta_word)}}" target="_blank">
                                    <button type="button" class="px-4 py-2 text-sm font-medium text-green-900 bg-green-300 border border-gray-200 rounded-s-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
                                        <i class="fa-solid fa-file-word"></i> Word - Excel
                                    </button>
                                </a>

                                <a href="{{Storage::url($item->ruta_pdf)}}" target="_blank">
                                    <button type="button" class="px-4 py-2 text-sm font-medium text-red-900 bg-red-900 border border-gray-200 rounded-e-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
                                        <i class="fa-solid fa-file-pdf"></i> PDF
                                    </button>
                                </a>

                            </div>

                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                            @if ($item->status)
                                Vigente
                            @else
                                Obsoleto
                            @endif
                        </th>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
