<div>
    <h1 class="t text-center text-lg font-bold mb-2">
        Esta seguro(a) de reutilizar la programación: <strong>{{$actual->name}}</strong>
    </h1>
    <div class="grid sm:grid-cols-1 md:grid-cols-6 gap-4">

        <div class="mb-6">
            <label for="inicio" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha de Inicio:</label>
            <input type="date" id="inicio" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"  wire:model.live="inicio">
            @error('inicio')
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                </div>
            @enderror
        </div>
        @if ($inicio)
            <div class="mb-6">
                <a href="" wire:click.prevent="reutilizar()" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                    <i class="fa-solid fa-rectangle-xmark"></i> Reutilizar
                </a>
            </div>
        @endif

        <div class="mb-6">
            <a href="" wire:click.prevent="$dispatch('cancelando')" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                <i class="fa-solid fa-rectangle-xmark"></i> cancelar
            </a>
        </div>
    </div>
</div>
