<div>
    <h1 class="text-center">
        Va a realizar una traslado desde el almacén:
        <span class="text-xl font-bold capitalize">{{$almacen->name}}</span> de la sede:
        <span class="text-xl font-bold capitalize">{{$sede->name}}</span>
    </h1>

    <div class="grid sm:grid-cols-1 md:grid-cols-3 gap-4 m-2">
        <div class="mb-6">
            <label for="desede" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Escoja la sede</label>
            <select wire:model.live="desede" id="desede" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500 capitalize">
                <option >Elija sede...</option>
                @foreach ($sedes as $item)
                    @if ($item->id!==$sede->id)
                        <option value={{$item->id}}>{{$item->name}}</option>
                    @endif
                @endforeach
            </select>
            @error('desede')
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                </div>
            @enderror
        </div>
        @if ($almacenes)
            <div class="mb-6">
                <label for="dealma" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Escoja almacén</label>
                <select wire:model.live="dealma" id="dealma" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500 capitalize">
                    <option >Elija almacén...</option>
                    @foreach ($almacenes as $item)
                        <option value={{$item->id}}>{{$item->name}}</option>
                    @endforeach
                </select>
                @error('dealma')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
        @endif
    </div>
</div>
