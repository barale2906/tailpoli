<div class="border bg-cyan-50 border-cyan-500 mb-3 p-2 rounded-xl">
    <h1 class=" text-center font-bold uppercase mb-3">
        Ver / Asignar los salarios de {{$actual->user->name}}
    </h1>
    <div class="grid sm:grid-cols-1 md:grid-cols-4 gap-4 mb-3">
        <div class="mb-6">
            <label for="basico" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Básico</label>
            <input type="text" id="basico" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Salario básico" wire:model.blur="basico">
            @error('basico')
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                </div>
            @enderror
        </div>
        <div class="mb-6">
            <label for="subsidio_transporte" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Subsidio Transporte</label>
            <input type="text" id="subsidio_transporte" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="subsidio_transporte" wire:model.blur="subsidio_transporte">
            @error('subsidio_transporte')
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                </div>
            @enderror
        </div>
        <div class="mb-6">
            <label for="otros_subisidios" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Otros Subisidios</label>
            <input type="text" id="otros_subisidios" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="otros_subisidios" wire:model.blur="otros_subisidios">
            @error('otros_subisidios')
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                </div>
            @enderror
        </div>
        <div class="mb-6">
            <label for="bonificacion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bonificación</label>
            <input type="text" id="bonificacion" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="bonificacion" wire:model.blur="bonificacion">
            @error('bonificacion')
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                </div>
            @enderror
        </div>
        <div class="mb-6">
            <label for="vigencia" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Vigencia</label>
            <input type="date" id="vigencia" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="vigencia" wire:model.blur="vigencia">
            @error('vigencia')
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                </div>
            @enderror
        </div>
    </div>
    <div class="mb-6">
        <label for="observaciones" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Registre Observaciones</label>
        <textarea id="observaciones" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Comentarios al salario asignado" wire:model.live="observaciones">

        </textarea>
        @error('observaciones')
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
            </div>
        @enderror
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
                        Básico
                    </th>
                    <th scope="col" class="px-6 py-3" >
                        Auxilio Transporte
                    </th>
                    <th scope="col" class="px-6 py-3" >
                        Otros Auxilios
                    </th>
                    <th scope="col" class="px-6 py-3" >
                        Bonificaciones
                    </th>
                    <th scope="col" class="px-6 py-3" >
                        Vigencia
                    </th>
                    <th scope="col" class="px-6 py-3" >
                        Observaciones
                    </th>
                    <th scope="col" class="px-6 py-3" >
                        Estatus
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($salarios as $item)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">

                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                            $ {{number_format($item->basico, 0, ',', '.')}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            $ {{number_format($item->subsidio_transporte, 0, ',', '.')}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                            $ {{number_format($item->otros_subisidios, 0, ',', '.')}}
                        </th>
                        <th scope="row" class="px-1 py-1 font-medium text-gray-900  dark:text-white capitalize">
                            $ {{number_format($item->bonificacion, 0, ',', '.')}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                            {{$item->vigencia}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                            {{$item->observaciones}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900  dark:text-white capitalize">
                            {{$estados[$item->status]}}
                        </th>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
