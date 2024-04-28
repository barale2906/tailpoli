<div>
    <div class="content-center text-center">
        @if ($is_nuevo)

            <h1 class=" text-center font-semibold p-6">
                Cargando documento firmado
            </h1>

            <div class="grid sm:grid-cols-1 md:grid-cols-3 gap-4 md:h-60">
                <div class="mb-6">
                    <label for="documento" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo de documento</label>
                    <select wire:model.live="documento" id="documento" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                        <option >Elegir...</option>
                        @foreach ($documentos as $item)
                            <option value={{$item->id}}>{{$item->titulo}}</option>
                        @endforeach
                    </select>
                    @error('documento')
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                            <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                        </div>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre del archivo</label>
                    <input type="text" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full m-2 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.live="name">
                    @error('name')
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                            <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                        </div>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="archivo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cargue Archivo soporte</label>
                    <input type="file" id="archivo" accept="image/jpg, image/bmp, image/png, image/jpeg, .pdf" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full m-2 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.live="archivo">
                    @error('archivo')
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                            <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                        </div>
                    @enderror
                    <div wire:loading wire:target="archivo" class="text-center text-xl font-extrabold text-orange-500 uppercase">Cargando</div>
                </div>
                @if ($archivo)
                    <a href="" wire:click.prevent="new()" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                        <i class="fa-solid fa-upload"></i> Crear
                    </a>
                @endif

                <a href="" wire:click.prevent="resetFields" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                    <i class="fa-solid fa-xmark"></i> Cancelar
                </a>
            </div>
        @else
            <h1 class=" text-center font-semibold p-6 uppercase">
                Documentos firmados
            </h1>
            <a href="#" wire:click.prevent="carga" class="text-black bg-gradient-to-r from-green-300 via-green-400 to-green-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                <i class="fa-solid fa-upload"></i> Cargar
            </a>

            @if ($actual->firmados->count()>0)
                <div class="md:inline-flex rounded-md shadow-sm m-3" role="group">
                    @foreach ($actual->firmados as $item)
                        <a href="{{Storage::url($item->ruta)}}" target="_blank">
                            <button type="button" class="px-4 py-2 text-sm font-medium text-gray-900 bg-blue-150 border border-gray-200 rounded-lg hover:bg-green-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                                {{$item->name}}
                            </button>
                        </a>
                    @endforeach
                </div>
            @else
                <h1 class=" text-center font-semibold m-3">
                    No tiene documentos firmados para esta matricula.
                </h1>
            @endif
        @endif
    </div>
</div>
