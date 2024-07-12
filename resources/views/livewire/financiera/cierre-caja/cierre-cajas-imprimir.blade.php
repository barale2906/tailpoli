<div>
    @if ($cierre->status)
        @include('includes.cierreaprobacion')
        @include('includes.cierrerecibos')
    @else
        @if ($accion===0)
            @include('includes.cierreaprobacion')
            <div class="mb-6">
                <label for="observaciones" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Observaciones de aprobación:</label>
                <input type="text" id="observaciones" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Anotaciones importantes" wire:model.blur="observaciones">

                @error('observaciones')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 m-2" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
            <a href="#" wire:click.prevent="aprobar()" class="text-black bg-gradient-to-r from-yellow-300 via-yellow-400 to-yellow-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-yellow-200 dark:focus:ring-yellow-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                <i class="fa-solid fa-check-double"></i> Aprobar Cierre.
            </a>
            @include('includes.cierrerecibos')
        @else
            <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
                <span class="font-medium">¡IMPORTANTE!</span> Cuando haya sido aprobado este cierre lo podrás revisar.
            </div>
            @switch($accion)
                @case(0)
                    <a href="#" wire:click.prevent="$dispatch('Inactivando')" class="w-full sm:w-auto bg-cyan-800 hover:bg-cyan-700 focus:ring-4 focus:outline-none focus:ring-cyan-300 text-white rounded-lg inline-flex items-center justify-center px-4 py-2.5 dark:bg-cyan-700 dark:hover:bg-cyan-600 dark:focus:ring-cyan-700">
                        <i class="fa-solid fa-backward-fast fa-beat"></i>
                        <div class="text-left rtl:text-right">

                            <div class="-mt-1 font-sans text-sm font-semibold">Volver</div>
                        </div>
                    </a>
                    @break
                @case(1)
                    <a href="#" wire:click.prevent="$dispatch('watched')" class="w-full sm:w-auto bg-cyan-800 hover:bg-cyan-700 focus:ring-4 focus:outline-none focus:ring-cyan-300 text-white rounded-lg inline-flex items-center justify-center px-4 py-2.5 dark:bg-cyan-700 dark:hover:bg-cyan-600 dark:focus:ring-cyan-700">
                        <i class="fa-solid fa-backward-fast fa-beat"></i>
                        <div class="text-left rtl:text-right">

                            <div class="-mt-1 font-sans text-sm font-semibold">Volver</div>
                        </div>
                    </a>
                    @break

                @case(2)
                    <a href="#" wire:click.prevent="$dispatch('volver')" class="w-full sm:w-auto bg-cyan-800 hover:bg-cyan-700 focus:ring-4 focus:outline-none focus:ring-cyan-300 text-white rounded-lg inline-flex items-center justify-center px-4 py-2.5 dark:bg-cyan-700 dark:hover:bg-cyan-600 dark:focus:ring-cyan-700">
                        <i class="fa-solid fa-backward-fast fa-beat"></i>
                        <div class="text-left rtl:text-right">

                            <div class="-mt-1 font-sans text-sm font-semibold">Volver</div>
                        </div>
                    </a>
                    @break
            @endswitch
        @endif
    @endif



</div>
