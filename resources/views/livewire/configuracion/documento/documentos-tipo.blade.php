<div>
    <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-4 m-2">
        <div class="mb-6">
            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Nombre del tipo de documento</label>
            <input type="text" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Escriba el nombre del tipo del documento" wire:model.live="name">
            @error('name')
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                </div>
            @enderror
        </div>
        <div class="mb-6">
            <label for="descripcion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Descripción del tipo de documento</label>
            <input type="text" id="descripcion" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Escriba el nombre del tipo del documento" wire:model.live="descripcion">
            @error('descripcion')
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                </div>
            @enderror
        </div>
        <h1 class=" text-center">
            Elija tipo de plantilla aplicable:
        </h1>
        <div class="flex items-center mb-4">
            <input id="plantilla-1" type="radio" wire:model.live="plantilla" name="plantilla" value="1" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:focus:bg-blue-600 dark:bg-gray-700 dark:border-gray-600">
            <label for="plantilla-1" class="block ms-2  text-sm font-medium text-gray-900 dark:text-gray-300">
                Encabezado y pie de página (para documentos de una página).
            </label>
        </div>

        <div class="flex items-center mb-4">
            <input id="plantilla-2" type="radio" wire:model.live="plantilla" name="plantilla" value="2" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:focus:bg-blue-600 dark:bg-gray-700 dark:border-gray-600">
            <label for="plantilla-2" class="block ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                Solo encabezado. (documentos de varias páginas)
            </label>
        </div>

        <div class="flex items-center mb-4">
            <input id="plantilla-3" type="radio" wire:model.live="plantilla" name="plantilla" value="3" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:bg-gray-700 dark:border-gray-600">
            <label for="plantilla-3" class="block ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                Sin encabezado ni pie de página (Documentos legales como contratos, pagarés etc)
            </label>
            @error('plantilla')
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                </div>
            @enderror
        </div>

    </div>
    <div class="grid sm:grid-cols-1 md:grid-cols-5 gap-4 m">
        <button type="button" wire:click.prevent="new()"
        class="text-white bg-blue-500 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-400 dark:hover:bg-blue-500 dark:focus:ring-blue-400"
        >
            Nuevo Tipo de documento
        </button>
        <a href="#" wire:click.prevent="$dispatch('volver')" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
            <i class="fa-solid fa-rectangle-xmark"></i> cancelar / volver
        </a>
    </div>
    <div class="relative overflow-x-auto mt-2">
        <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('name')">
                        TITULO DEL DOCUMENTO
                        @if ($ordena != 'name')
                            <i class="fas fa-sort"></i>
                        @else
                            @if ($ordenado=='ASC')
                                <i class="fas fa-sort-up"></i>
                            @else
                                <i class="fas fa-sort-down"></i>
                            @endif
                        @endif
                    </th>
                    <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('descripcion')">
                        DESCRIPCION DEL DOCUMENTO
                        @if ($ordena != 'descripcion')
                            <i class="fas fa-sort"></i>
                        @else
                            @if ($ordenado=='ASC')
                                <i class="fas fa-sort-up"></i>
                            @else
                                <i class="fas fa-sort-down"></i>
                            @endif
                        @endif
                    </th>
                    <th scope="col" class="px-6 py-3">
                        PLANTILLA
                    </th>
                    <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('status')">
                        ESTADO DEL DOCUMENTO
                        @if ($ordena != 'status')
                            <i class="fas fa-sort"></i>
                        @else
                            @if ($ordenado=='ASC')
                                <i class="fas fa-sort-up"></i>
                            @else
                                <i class="fas fa-sort-down"></i>
                            @endif
                        @endif
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($documentos as $documento)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white capitalize">
                            {{$documento->name}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                            {{$documento->descripcion}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                            @switch($documento->plantilla)
                                @case(1)
                                    Usa encabezado y pie de página
                                    @break
                                @case(2)
                                    Usa Solo encabezado
                                    @break
                                @case(3)
                                    No usa encabezado ni pie de página
                                    @break

                            @endswitch
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                            @if ($documento->status)
                                VIGENTE
                            @else
                                OBSOLETO
                            @endif
                        </th>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-2 p-1 w-auto rounded-lg grid grid-cols-2 gap-4 bg-blue-100">
            <div>
                <label class="relative inline-flex items-center mb-4 cursor-pointer">
                    <span class="ml-3 mr-3 text-sm font-medium text-gray-900 dark:text-gray-300">Registros:</span>
                    <select wire:click="paginas($event.target.value)" id="countries" class="w-20 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value=15>15</option>
                        <option value=20>20</option>
                        <option value=50>50</option>
                        <option value=100>100</option>
                    </select>
                </label>
            </div>
            <div>
                {{ $documentos->links() }}
            </div>
        </div>
    </div>
</div>
