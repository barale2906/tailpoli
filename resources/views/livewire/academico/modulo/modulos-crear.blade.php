<div>
    <form wire:submit.prevent="new">

        <div class="mb-6">
            <label for="curso" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Curso</label>
            <select wire:model.live="curso_id" wire:change="curso()" id="curso" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option >Elegir curso...</option>
                @foreach ($cursos as $item)
                    <option value={{$item->id}}>{{$item->name}}</option>
                @endforeach
            </select>
        </div>
        @if ($mostrar)
            <div class="mb-6">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre del Modulo</label>
                <input type="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nombre" wire:model.blur="name">
                @error('name')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>
            <div class="mb-6">
                <label for="slug" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Código del Modulo</label>
                <input  id="slug" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="código del modulo" wire:model.blur="slug">
                @error('slug')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>

            <label for="modulos" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Elija los modulos de los cuáles dependerá</label>
            <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-4 m-2">
                    <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-4 m-2">
                        @foreach ($cursodet->modulos as $item)
                            <a href="#" wire:click.prevent="selModulo({{$item['id']}})" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                                <i class="fa-regular fa-circle-check fa-beat-fade"></i> {{$item['name']}}
                            </a>
                        @endforeach
                    </div>

                @if (count($moduloDepen)>0)
                    <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-4 m-2">
                        @foreach ($moduloDepen as $item)
                            <a href="#" wire:click.prevent="elimModulo({{$item['id']}})" class="text-black bg-gradient-to-r from-orange-300 via-orange-400 to-orange-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-orange-200 dark:focus:ring-orange-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                                <i class="fa-solid fa-trash-can fa-bounce"></i> {{$item['name']}}
                            </a>
                        @endforeach
                    </div>
                @else
                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No ha agregado dependencias</label>
                    </div>
                @endif
            </div>

            <button type="submit"
            class="text-white bg-blue-500 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-400 dark:hover:bg-blue-500 dark:focus:ring-blue-400"
            >
                Nuevo Modulo
            </button>
        @endif

        <a href="#" wire:click.prevent="$dispatch('created')" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
            <i class="fa-solid fa-rectangle-xmark"></i> cancelar
        </a>
    </form>
</div>
