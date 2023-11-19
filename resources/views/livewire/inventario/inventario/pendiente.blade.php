<div>
    <div class="grid sm:grid-cols-1 md:grid-cols-3 gap-4 m-2">
        <div class="mb-6">
            <label for="alumno_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Seleccione Alumno</label>
            <select wire:model.live="alumno_id" id="alumno_id" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                <option >Seleccione...</option>
                @foreach ($pendientes as $item)
                    <option value={{$item->id}}>{{$item->name}}</option>
                @endforeach
            </select>
            @error('alumno_id')
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                </div>
            @enderror
        </div>

        @if ($alumno_id)
            <div class="mb-6">
                <label for="producto_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Escoja el producto a entrega</label>
                <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-4 m-1">
                    @foreach ($productos as $item)
                        <a href="" wire:click.prevent="cargar({{$item->id}})" class="block max-w-sm p-2 bg-white border border-gray-200 rounded-lg shadow hover:bg-cyan-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                            <h5 class="mb-2 text-sm font-bold tracking-tight text-gray-900 dark:text-white capitalize">
                                {{$item->producto->name}}
                            </h5>
                            <p class="font-normal text-xs text-gray-700 dark:text-gray-400 capitalize">
                                Cantidad: {{$item->cantidad}}
                            </p>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        @if (count($entregar)>0)
            <div class="mb-6">
                <label for="producto_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Elegidos:</label>
                <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-4 m-1">
                    @foreach ($entregar as $item)
                        <a href="" wire:click.prevent="eliminar({{$item['id']}})" class="block max-w-sm p-2 bg-red-50 border border-gray-200 rounded-lg shadow hover:bg-cyan-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                            <h5 class="mb-2 text-sm font-bold tracking-tight text-gray-900 dark:text-white capitalize">
                                {{$item['name']}}
                            </h5>
                            <p class="font-normal text-xs text-gray-700 dark:text-gray-400 capitalize">
                                Cantidad: {{$item['cantidad']}}
                            </p>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    @if (count($entregar)>0)
        <div class="grid sm:grid-cols-1 md:grid-cols-5 gap-4 m">
            <a href="" wire:click.prevent="entregando" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                <i class="fa-solid fa-upload"></i> entregar
            </a>
            <a href="" wire:click.prevent="$dispatch('cancelando')" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                <i class="fa-solid fa-rectangle-xmark"></i> cancelar
            </a>
        </div>
    @endif
</div>
