<div>
    <h1 class="font-extrabold text-xl text-center capitalize">registrar cambios para: <strong class="uppercase">{{$elegido->estudiante->name}}</strong></h1>
    <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-4">
        <div class="mb-6">
            <label for="comentarios" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre del Grupo</label>
            <input type="text" id="comentarios" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nombre" wire:model.live="comentarios">
            @error('comentarios')
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                </div>
            @enderror
        </div>
        <div class="mb-6">
            <p class="text-justify text-sm">
                {{$elegido->observaciones}}
            </p>
        </div>
        <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-4">

            @if ($comentarios)
                <div>
                    <a href="#" wire:click.prevent="guardar" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                        <i class="fa-solid fa-upload"></i> Guardar Comentario
                    </a>
                </div>
            @endif

            <div>
                <a href="" wire:click.prevent="$dispatch('cancelando')" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                    <i class="fa-solid fa-rectangle-xmark"></i> cancelar
                </a>
            </div>
        </div>
    </div>
</div>
