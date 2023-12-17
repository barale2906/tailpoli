<div>
    <div class="grid sm:grid-cols-1 md:grid-cols-4 gap-4 md:h-60">
        <div class="mb-6">
            <label for="estudiante_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Estudiante</label>
            <select wire:model.live="estudiante_id" id="estudiante_id" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option >Elegir...</option>
                @foreach ($estudiantes as $item)
                    <option value={{$item->id}}>{{$item->name}}</option>
                @endforeach
            </select>
            @error('estudiante_id')
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                </div>
            @enderror
        </div>
        @if ($estudiante_id)
            <div class="mb-6">
                <label for="tipo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo de requerimiento</label>
                <select wire:model.live="tipo" id="tipo" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option >Elegir...</option>
                    <option value=2>Pagos</option>
                    <option value=3>Notas</option>
                    <option value=4>Acádemico</option>
                    <option value=5>Profesor</option>
                    <option value=6>Planta</option>
                    <option value=7>Talleres </option>
                    <option value=8>Administración</option>
                    <option value=9>Observador</option>
                </select>
                @error('tipo')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
        @endif
        @if ($tipo)
            <div class="mb-6">
                <label for="observaciones" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Registre Observaciones</label>
                <textarea id="observaciones" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Información necesaria para la gestión." wire:model.live="observaciones">

                </textarea>
                @error('observaciones')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
        @endif
        {{-- @if ($observaciones)
            <div class="mb-6">
                <label for="archivo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cargue Archvivo soporte</label>
                <input type="file" id="archivo" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full m-2 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.live="archivo">
            </div>
        @endif --}}
    </div>
    <div class="grid sm:grid-cols-1 md:grid-cols-4 gap-4">
        @if ($editar)
            <a href="" wire:click.prevent="edit()" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                <i class="fa-solid fa-upload"></i> Actualizar
            </a>
        @else
            <a href="" wire:click.prevent="new()" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                <i class="fa-solid fa-upload"></i> Crear
            </a>
        @endif

        <a href="" wire:click.prevent="$dispatch('cancelando')" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
            <i class="fa-solid fa-rectangle-xmark"></i> cancelar
        </a>
    </div>
</div>
