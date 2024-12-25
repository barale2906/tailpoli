<div>
    <h1 class=" text-center font-bold uppercase mb-3">
        Ver / Registrar las personas dependientes de {{-- {{$actual->user->name}} --}}
    </h1>
    <div class="grid sm:grid-cols-1 md:grid-cols-4 gap-4 mb-3">
        <div class="mb-6">
            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
            <input type="text" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nombre del familiar" wire:model.blur="name">
            @error('name')
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                </div>
            @enderror
        </div>
        <div class="mb-6">
            <label for="edad" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Edad</label>
            <input type="number" id="edad" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="edad" wire:model.blur="edad">
            @error('edad')
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                </div>
            @enderror
        </div>
        <div class="mb-6">
            <label for="telefono" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Teléfono</label>
            <input type="text" id="telefono" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Teléfono de la persona" wire:model.blur="telefono">
            @error('telefono')
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                </div>
            @enderror
        </div>
        <div class="mb-6">
            <label for="relacion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Vinculo</label>
            <select wire:model.live="relacion" id="relacion" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                <option >Elija ...</option>
                @for ($i = 0; $i < count($familiares); $i++)
                    <option value={{$i}}>
                        {{$familiares[$i]}}
                    </option>
                @endfor
            </select>
            @error('relacion')
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                </div>
            @enderror
        </div>
        <div class="mb-6">
            <label for="beneficiario" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white capitalize">Beneficiario</label>
            <select wire:model.live="beneficiario" id="beneficiario" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 capitalize">
                <option >Elija ...</option>
                <option value=1>SI</option>
                <option value=0>NO</option>
            </select>
            @error('beneficiario')
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                </div>
            @enderror
        </div>
    </div>
    <div class="grid sm:grid-cols-1 md:grid-cols-4 gap-4 mt-3">
        <a href="" wire:click.prevent="new()" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
            <i class="fa-solid fa-upload"></i> Guardar
        </a>
        <a href="" wire:click.prevent="$dispatch('cancelando')" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
            <i class="fa-solid fa-rectangle-xmark"></i> cancelar
        </a>
    </div>

    <div class="relative overflow-x-auto">

        <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3" >

                    </th>
                    <th scope="col" class="px-6 py-3" >
                        Nombre
                    </th>
                    <th scope="col" class="px-6 py-3" >
                        Edad
                    </th>
                    <th scope="col" class="px-6 py-3" >
                        Teléfono
                    </th>
                    <th scope="col" class="px-6 py-3" >
                        Relación
                    </th>
                    <th scope="col" class="px-6 py-3" >
                        Beneficiario
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($familiares as $item)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">

                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                            {{$item->name}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{$item->edad}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                            {{$item->telefono}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                            {{$familiares[$item->relacion]}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                            {{$binario[$item->beneficiario]}}
                        </th>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
