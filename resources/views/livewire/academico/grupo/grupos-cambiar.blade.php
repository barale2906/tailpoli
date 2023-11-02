<div>
    <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
        <span class="font-medium uppercase">{{$alumno->name}}!</span> Seleccione el grupo que quiere cambiar.
    </div>
    <div class="grid sm:grid-cols-1 md:grid-cols-3 gap-4 m-2">

        <div class="mb-6">
            <label for="grupo_actual" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Grupo Actual</label>
            <select wire:model.live="grupo_actual" id="grupo_actual" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                <option >Elija Grupo...</option>
                @foreach ($alumno->alumnosGrupo as $item)
                    <option value={{$item->id}}>{{$item->name}}</option>
                @endforeach
            </select>
            @error('grupo_actual')
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                </div>
            @enderror
        </div>
        @if ($grupo_actual>0)
            <div class="mb-6">
                <label for="grupo_nuevo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Grupo donde va</label>
                <select wire:model.live="grupo_nuevo" id="grupo_nuevo" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                    <option >Elija Grupo...</option>
                    @foreach ($grupos as $item)
                        @if ($item->id != $grupo_actual && $item->quantity_limit > $item->inscritos)
                            <option value={{$item->id}}>GRUPO: {{$item->name}} - MODULO: {{$item->modulo->name}} - SEDE: {{$item->sede->name}}</option>
                        @endif
                    @endforeach
                </select>
                @error('grupo_nuevo')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
        @endif
        @if ($grupo_nuevo>0)
            <a href="#" wire:click.prevent="cambiar"  class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm p-2 text-center mr-2 mb-2 capitalize">
                <i class="fa-solid fa-retweet"></i>
            </a>
        @endif
    </div>
</div>
