<div>
    <form wire:submit.prevent="new">
        <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-4">
            <div class="mb-6">
                <select wire:model.live="sede_id" id="sede_id" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                    <option >Elija sede...</option>
                    @foreach ($sedes as $item)
                        <option value={{$item->id}}>{{$item->name}} - {{$item->sector->name}}</option>
                    @endforeach
                </select>
                @error('sede_id')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>

            @if ($sede_id>0)
                <div class="mb-6">
                    <select wire:model.live="cajero_id" id="cajero_id" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                        <option >Elija cajero...</option>
                        @foreach ($cajeros as $item)
                            <option value="{{$item[0]->creador['id']}}">{{$item[0]->creador['id']}} - {{$item[0]->creador['name']}}</option>
                        @endforeach
                    </select>
                    @error('cajero_id')
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                            <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                        </div>
                    @enderror
                    {{$cajero_id}}
                </div>
            @endif
        </div>
        @if ($sede_id>0 && $cajero_id>0)
            <div class="mb-6">
                <label for="observaciones" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Observaciones:</label>
                <input type="text" id="observaciones" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nombre" wire:model.blur="observaciones">

                @error('observaciones')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
            <div class="grid sm:grid-cols-1 md:grid-cols-4 gap-4">
                <div class="mb-6">
                    <div class="flex flex-col items-center justify-center">
                        <dt class="mb-2 text-3xl font-extrabold">$ {{number_format($valor_total, 0, ',', '.')}}</dt>
                        <dd class="text-gray-500 dark:text-gray-400 capitalize">Valor total</dd>
                    </div>
                </div>
            </div>

            <button type="submit"
            class="text-white bg-blue-500 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-400 dark:hover:bg-blue-500 dark:focus:ring-blue-400"
            >
                Generar Cierre de Caja
            </button>
        @endif

        <a href="#" wire:click.prevent="$dispatch('created')" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
            <i class="fa-solid fa-rectangle-xmark"></i> cancelar
        </a>
    </form>
</div>
