<div>
    <form wire:submit.prevent="edit">
        <div class="flex p-4 text-sm text-blue-800 rounded-lg bg-cyan-100 dark:bg-gray-800 dark:text-blue-400" role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 mr-3 mt-[2px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <span class="sr-only">Info</span>
            <div>
                <span class="font-bold uppercase text-2xl ">Datos seleccionados para la matricula de: {{$matricula->alumno->name}} al curso: {{$matricula->curso->name}}</span>
                <div class="grid grid-cols-3 gap-3 m-3">
                    <div>
                        <ul class="mt-1.5 ml-4 list-disc list-inside mb-3 text-lg capitalize">
                            <li>Medio: <strong>{{$matricula->medio}}</strong></li>
                            <li>Nivel: <strong>{{$matricula->nivel}}</strong></li>
                            <li>Fecha de matricula: <strong>{{$matricula->created_at}}</strong></li>
                        </ul>
                    </div>
                    <div>
                        <ul class="mt-1.5 ml-4 list-disc list-inside mb-3 text-lg">
                            <li>Asesor que matriculo: <strong>{{$matricula->creador->name}}</strong></li>
                            <li>Asesor Comercial: <strong>{{$matricula->comercial->name}}</strong></li>
                        </ul>
                    </div>
                    <div>
                        <ul class="mt-1.5 ml-4 list-disc list-inside mb-3 text-lg">
                            <li>Metódo de pago: <strong>{{$matricula->metodo}}</strong></li>
                            <li>Valor: <strong>$ {{number_format($matricula->valor, 0, '.', ' ')}}</strong></li>
                        </ul>
                    </div>
                </div>
                <span class="font-bold uppercase text-sm ">Grupos:</span>
                <ul class="mt-1.5 ml-4 list-disc list-inside mb-3 text-lg capitalize">
                    @foreach ($matricula->grupos as $item)
                        <li><strong>{{$item->name}}</strong></li>
                    @endforeach
                </ul>
                <a href="#" wire:click.prevent="$dispatch('Editando')" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                    <i class="fa-solid fa-backward-fast fa-beat"></i> Volver
                </a>
            </div>
        </div>
        <div class="mb-6">
            <label for="motivo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Motivo de la anulación: </label>
            <input type="text" id="motivo" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="motivo" wire:model.blur="motivo">
        </div>
        @error('motivo')
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
            </div>
        @enderror

        <button type="submit"
        class="text-white bg-orange-500 hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-orange-400 dark:hover:bg-orange-500 dark:focus:ring-orange-400"
        >
            Anular Matricula
        </button>
        <a href="#" wire:click.prevent="$dispatch('Editando')" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
            <i class="fa-solid fa-rectangle-xmark"></i> cancelar
        </a>
    </form>
</div>
